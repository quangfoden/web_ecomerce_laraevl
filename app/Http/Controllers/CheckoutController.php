<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Mail\NewOrderEmail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // Kiểm tra thông tin địa chỉ của khách hàng
        $customer = $user->customer;
        if (!$customer->billingAddress || !$customer->shippingAddress) {
            return redirect()->route('profile')->with('error', 'Vui lòng cung cấp thông tin địa chỉ của bạn trước.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        // Lấy sản phẩm và giỏ hàng
        [$products, $cartItems] = Cart::getProductsAndCartItems();

        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;

        DB::beginTransaction();

        try {
            // Kiểm tra tồn kho và chuẩn bị dữ liệu đơn hàng
            foreach ($products as $product) {
                $cartItem = $cartItems[$product->id];
                $quantity = $cartItem['quantity'];
                $sizeId = $cartItem['size_id'] ?? null;

                // Kiểm tra tồn kho
                if ($product->quantity !== null && $product->quantity < $quantity) {
                    $message = match ($product->quantity) {
                        0 => 'Sản phẩm "' . $product->title . '" đã hết hàng',
                        1 => 'Chỉ còn lại 1 sản phẩm "' . $product->title,
                        default => 'Chỉ có ' . $product->quantity . ' sản phẩm còn lại cho "' . $product->title,
                    };
                    return redirect()->back()->with('error', $message);
                }

                // Tính tổng tiền
                $totalPrice += $product->price * $quantity;

                // Chuẩn bị dữ liệu cho Stripe
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'vnd',
                        'product_data' => [
                            'name' => $product->title,
                            'images' => $product->url ? [$product->url] : [],
                        ],
                        'unit_amount' => (int) ($product->price), // Stripe yêu cầu giá trị tính bằng cent
                    ],
                    'quantity' => $quantity,
                ];

                // Chuẩn bị dữ liệu cho OrderItem
                $orderItems[] = [
                    'product_id' => $product->id,
                    'size_id' => $sizeId,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                ];

                // Cập nhật tồn kho sản phẩm
                if ($product->quantity !== null) {
                    $product->quantity -= $quantity;
                    $product->save();
                }
            }

            // Tạo phiên thanh toán Stripe
            $session = \Stripe\Checkout\Session::create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.failure', [], true),
            ]);

            // Tạo đơn hàng
            $orderData = [
                'total_price' => $totalPrice,
                'status' => OrderStatus::Unpaid,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ];
            $order = Order::create($orderData);

            // Tạo các mục trong đơn hàng
            foreach ($orderItems as $orderItem) {
                $orderItem['order_id'] = $order->id;
                OrderItem::create($orderItem);
            }

            // Tạo thanh toán
            $paymentData = [
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'status' => PaymentStatus::Pending,
                'type' => 'cc',
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'session_id' => $session->id,
            ];
            Payment::create($paymentData);

            DB::commit();

            // Xóa giỏ hàng
            CartItem::where(['user_id' => $user->id])->delete();

            return redirect($session->url);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình thanh toán.');
        }
    }

    public function success(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session_id = $request->get('session_id');
            $session = \Stripe\Checkout\Session::retrieve($session_id);
            if (!$session) {
                return view('checkout.failure', ['message' => 'Invalid Session ID']);
            }

            $payment = Payment::query()
                ->where(['session_id' => $session_id])
                ->whereIn('status', [PaymentStatus::Pending, PaymentStatus::Paid])
                ->first();
            if (!$payment) {
                throw new NotFoundHttpException();
            }

            if ($payment->status === PaymentStatus::Pending->value) {
                $this->updateOrderAndSession($payment);
            }

            $customer = \Stripe\Customer::retrieve($session->customer);

            return view('checkout.success', compact('customer'));
        } catch (NotFoundHttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            return view('checkout.failure', ['message' => $e->getMessage()]);
        }
    }

    public function failure(Request $request)
    {
        return view('checkout.failure', ['message' => ""]);
    }

    public function checkoutOrder(Order $order, Request $request)
    {
        // \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
        Stripe::setApiKey(config('services.stripe.secret'));
        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'vnd',
                    'product_data' => [
                        'name' => $item->product->title,
                        //                        'images' => [$product->image]
                    ],
                    'unit_amount' => (int) ($item->unit_price),
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
        ]);

        $order->payment->session_id = $session->id;
        $order->payment->save();


        return redirect($session->url);
    }

    public function webhook()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $endpoint_secret = env('WEBHOOK_SECRET_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 401);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 402);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $sessionId = $paymentIntent['id'];

                $payment = Payment::query()
                    ->where(['session_id' => $sessionId, 'status' => PaymentStatus::Pending])
                    ->first();
                if ($payment) {
                    $this->updateOrderAndSession($payment);
                }
                // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }

    private function updateOrderAndSession(Payment $payment)
    {
        DB::beginTransaction();
        try {
            $payment->status = PaymentStatus::Paid->value;
            $payment->update();
    
            $order = $payment->order;
            $order->status = OrderStatus::Paid->value;
            $order->update();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $e->getMessage());
            throw $e;
        }
    
        DB::commit();
    
        try {
            $adminUsers = User::where('is_admin', 1)->get();
    
            foreach ([...$adminUsers, $order->user] as $user) {
                Mail::to($user)->send(new NewOrderEmail($order, (bool)$user->is_admin));
            }
        } catch (\Exception $e) {
            Log::critical('Email sending does not work. ' . $e->getMessage());
        }
    }

  
}
