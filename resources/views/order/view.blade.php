<x-app-layout>
    <div class="mat-60 container mx-auto lg:w-2/3 p-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">🛍️ Chi tiết đơn hàng #{{$order->id}}</h1>
        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Thông tin đơn hàng -->
            <table class="table-auto w-full mb-6">
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
                            <span class="text-white py-1 px-3 rounded text-sm
                                {{$order->isPaid() ? 'bg-green-500' : 'bg-gray-400'}}">
                                {{$order->status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán'}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-600 py-2">Tổng tiền</td>
                        <td class="text-gray-800 font-bold">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                </tbody>
            </table>

            <hr class="my-6" />

            <!-- Danh sách sản phẩm -->
            @foreach($order->items()->with('product')->get() as $item)
            <div class="flex flex-col sm:flex-row items-center gap-6 mb-6">
                <a href="{{ route('product.view', $item->product) }}" class="w-36 h-36 flex items-center justify-center overflow-hidden rounded-lg bg-gray-100">
                    <img src="{{$item->product->image}}" class="object-cover w-full h-full" alt="{{$item->product->title}}" />
                </a>
                <div class="flex flex-col justify-between flex-1">
                    <h3 class="text-lg font-semibold text-gray-800">{{$item->product->title}}</h3>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-gray-600">Số lượng: {{$item->quantity}}</span>
                        <span class="text-lg font-bold text-red-600">{{ number_format($item->unit_price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            </div>
            <hr class="my-4" />
            @endforeach

            <!-- Nút thanh toán -->
            @if (!$order->isPaid())
            <form action="{{ route('cart.checkout-order', $order) }}" method="POST">
                @csrf
                <button class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Thanh toán
                </button>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>