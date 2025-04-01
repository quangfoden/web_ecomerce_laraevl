<h1>
    Đơn hàng mới đã được tạo
</h1>

<table>
    <tr>
        <th>Mã đơn hàng</th>
        <td>
            <a href="{{ $forAdmin ? env('BACKEND_URL').'/app/orders/'.$order->id : route('order.view', $order, true) }}">
                {{$order->id}}
            </a>
        </td>
    </tr>
    <tr>
        <th>Trạng thái đơn hàng</th>
        <td>{{ $order->status }}</td>
    </tr>
    <tr>
        <th>Tổng giá trị đơn hàng</th>
        <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
    </tr>
    <tr>
        <th>Ngày đặt hàng</th>
        <td>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</td>
    </tr>
</table>

<h2>Sản phẩm trong đơn hàng</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Hình ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
    </tr>
    @foreach($order->items as $item)
        <tr>
            <td>
                <img src="{{ $item->product->image }}" style="width: 100px">
            </td>
            <td>{{ $item->product->title }}</td>
            <td>{{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}₫</td>
            <td>{{ $item->quantity }}</td>
        </tr>
    @endforeach
</table>
