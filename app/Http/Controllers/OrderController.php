<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $orders = Order::with(['items.product', 'items.size']) // Load sản phẩm và size của từng item
            ->withCount('items') // Đếm số lượng sản phẩm trong đơn hàng
            ->where(['created_by' => $user->id])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        return view('order.index', compact('orders'));
    }
    public function view(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = \request()->user();
        if ($order->created_by !== $user->id) {
            return response("Bạn không có quyền truy cập", 403);
        }
    
        // Load quan hệ items, product và size
        $order->load(['items.product', 'items.size']);
    
        return view('order.view', compact('order'));
    }
}
