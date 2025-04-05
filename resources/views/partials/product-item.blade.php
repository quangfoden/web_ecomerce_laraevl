<div
    x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image ?: '/img/noimage.png',
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product)
                    ]) }})"
    class="product-image-wrapper">
    <div class="single-products">
        <div class="productinfo text-center">
            <img src="{{$product->image}}" alt="{{ $product->title }}" />
            <h2>{{$product->title}}</h2>
            <p>{{ number_format($product->price, 0, ',', '.') }} đ</p>
            <a href="#" class="btn btn-default add-to-cart"><i
                    class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
        </div>
        <div class="product-overlay">
            <div class="overlay-content">
                <h2>{{$product->title}}</h2>
                <p>{{ number_format($product->price, 0, ',', '.') }} đ</p>
                <a href="javascript:void(0)" @click="addToCart()" class="btn btn-default add-to-cart"><i
                        class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
            </div>
        </div>
    </div>
</div>