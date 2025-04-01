<h2>
    Trạng thái đơn hàng của bạn đã được cập nhật thành "{{$order->status}}"
</h2>
<p>
    Liên kết theo dõi đơn hàng của bạn:  
    <a href="{{ route('order.view', $order, true) }}">Đơn hàng #{{$order->id}}</a>
</p>
