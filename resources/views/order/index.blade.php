<?php
/** @var \Illuminate\Database\Eloquent\Collection $orders */
?>

<x-app-layout>
    <div class="mat-60 container mx-auto lg:w-2/3 p-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">🛍️ Đơn hàng của tôi</h1>
        <div class="bg-white rounded-lg shadow-md p-6 overflow-x-auto">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="text-left p-3 text-gray-600 font-semibold">Đơn hàng #</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Ngày đặt hàng</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Trạng thái</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Tổng tiền</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Số lượng</th>
                        <th class="text-left p-3 text-gray-600 font-semibold">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">
                                <a href="{{ route('order.view', $order) }}" class="text-blue-600 hover:text-blue-500 font-medium">
                                    #{{$order->id}}
                                </a>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700">{{$order->created_at->format('d/m/Y')}}</td>
                            <td class="py-3 px-4">
                                <span class="text-white py-1 px-3 rounded text-sm
                                    {{$order->isPaid() ? 'bg-green-500' : 'bg-gray-400'}}">
                                    {{$order->status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán'}}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-800 font-semibold">
                                {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{$order->items_count}} sản phẩm</td>
                            <td class="py-3 px-4">
                                @if (!$order->isPaid())
                                    <form action="{{ route('cart.checkout-order', $order) }}" method="POST">
                                        @csrf
                                        <button class="flex items-center gap-2 py-2 px-4 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
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
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
