<x-app-layout>
    <div class="order-container">
        <h1 class="order-title">🛍️ Đơn hàng của tôi</h1>
        <div class="order-card">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Đơn hàng #</th>
                        <th>Ngày đặt hàng</th>
                        <th>Trạng thái</th>
                        <th>Tổng tiền</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('order.view', $order) }}" class="order-link">#{{ $order->id }}</a>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                <span class="order-badge {{ $order->isPaid() ? 'paid' : 'unpaid' }}">
                                    {{ $order->status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                </span>
                            </td>
                            <td class="order-price">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $order->items_count }} sản phẩm</td>
                            <td>
                                @if (!$order->isPaid())
                                    <form action="{{ route('cart.checkout-order', $order) }}" method="POST">
                                        @csrf
                                        <button class="order-button" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                            Thanh toán
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="order-pagination">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
