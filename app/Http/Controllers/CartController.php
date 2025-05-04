<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        [$products, $cartItems] = Cart::getProductsAndCartItems();
        $total = 0;
        foreach ($products as $product) {
            $sizeId = $cartItems[$product->id]['size_id'] ?? null; // Lấy size_id từ giỏ hàng
            $quantity = $cartItems[$product->id]['quantity'];
            
            $total += $product->price * $quantity;
            
            // Gắn thông tin size vào sản phẩm
            if ($sizeId) {
                $product->size = $product->sizes->firstWhere('id', $sizeId)->name ?? null;
            } else {
                $product->size = null;
            }
        }
        return view('cart.index', compact('cartItems', 'products', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);
        $sizeId = $request->post('size_id'); // Lấy size_id từ request
        $user = $request->user();
    
        $totalQuantity = 0;
    
        if ($user) {
            // Kiểm tra sản phẩm trong giỏ hàng của người dùng
            $cartItem = CartItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'size_id' => $sizeId, // Kiểm tra theo size
            ])->first();
    
            if ($cartItem) {
                $totalQuantity = $cartItem->quantity + $quantity;
            } else {
                $totalQuantity = $quantity;
            }
        } else {
            // Kiểm tra sản phẩm trong giỏ hàng lưu trữ bằng cookie
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            $productFound = false;
    
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id && $item['size_id'] === $sizeId) {
                    $totalQuantity = $item['quantity'] + $quantity;
                    $productFound = true;
                    break;
                }
            }
    
            if (!$productFound) {
                $totalQuantity = $quantity;
            }
        }
    
        // Kiểm tra số lượng tồn kho
        if ($product->quantity !== null && $product->quantity < $totalQuantity) {
            return response([
                'message' => match ($product->quantity) {
                    0 => 'Sản phẩm đã hết hàng',
                    1 => 'Chỉ còn lại một sản phẩm',
                    default => 'Chỉ có ' . $product->quantity . ' sản phẩm'
                }
            ], 422);
        }
    
        if ($user) {
            // Thêm sản phẩm vào giỏ hàng của người dùng
            $cartItem = CartItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'size_id' => $sizeId, // Kiểm tra theo size
            ])->first();
    
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->update();
            } else {
                $data = [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'size_id' => $sizeId, // Lưu size
                    'quantity' => $quantity,
                ];
                CartItem::create($data);
            }
    
            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            // Thêm sản phẩm vào giỏ hàng lưu trữ bằng cookie
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            $productFound = false;
    
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id && $item['size_id'] === $sizeId) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }
    
            if (!$productFound) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'size_id' => $sizeId, // Lưu size
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }
    
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
    
            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    public function remove(Request $request, Product $product)
    {
        $user = $request->user();
        if ($user) {
            $cartItem = CartItem::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if ($cartItem) {
                $cartItem->delete();
            }

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as $i => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $quantity = (int)$request->post('quantity');
        $user = $request->user();

        if ($product->quantity !== null && $product->quantity < $quantity) {
            return response([
                'message' => match ( $product->quantity ) {
                    0 => 'The product is out of stock',
                    1 => 'There is only one item left',
                    default => 'There are only ' . $product->quantity . ' items left'
                }
            ], 422);
        }

        if ($user) {
            CartItem::where(['user_id' => $request->user()->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }
}
