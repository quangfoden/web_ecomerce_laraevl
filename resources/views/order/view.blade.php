<x-app-layout>
    <div class="order-detail-container">
        <h1 class="order-detail-title">🛍️ Chi tiết đơn hàng #{{$order->id}}</h1>
        <div class="order-detail-card">
            <!-- Thông tin đơn hàng -->
            <table class="order-detail-table">
                <tbody>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2">Đơn hàng #</td>
                        <td class="text-gray-800">{{$order->id}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2">Ngày đặt hàng</td>
                        <td class="text-gray-800">{{$order->created_at->format('d/m/Y H:i')}}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2">Trạng thái</td>
                        <td>
                            <span class="order-detail-badge {{ $order->isPaid() ? 'paid' : 'unpaid' }}">
                                {{$order->status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán'}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2">Tổng tiền</td>
                        <td class="order-detail-price">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                </tbody>
            </table>

            <hr class="order-detail-divider" />

            <!-- Danh sách sản phẩm -->
            @foreach($order->items()->with(['product', 'size'])->get() as $item)
            <div class="order-item">
                <a href="{{ route('product.view', $item->product) }}" class="order-item-image">
                    <img src="{{$item->product->image}}" alt="{{$item->product->title}}" />
                </a>
                <div class="order-item-content">
                    <h3 class="order-item-title">{{$item->product->title}}</h3>
                    <div class="order-item-details">
                        @if ($item->size)
                            <span class="order-item-size">Size: {{$item->size->name}}</span>
                        @endif
                        <span class="order-item-quantity">Số lượng: {{$item->quantity}}</span>
                        <span class="order-item-price">{{ number_format($item->unit_price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            </div>
            <hr class="order-detail-divider" />
            @endforeach

            <!-- Nút thanh toán -->
            @if (!$order->isPaid())
            <form action="{{ route('cart.checkout-order', $order) }}" method="POST">
                @csrf
                <button class="order-payment-button" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Thanh toán
                </button>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>