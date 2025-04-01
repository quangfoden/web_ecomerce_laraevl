<!-- Sản Phẩm Mới -->
<div class="bg-gray-100 py-20" data-aos="fade-up">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">🛒 {{$title}}</h2>
        <div id="productSwiper" class="swiper">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                <div 
                    x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image ?: '/img/noimage.png',
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product)
                    ]) }})"
                    class="swiper-slide" data-aos="flip-left">
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105 flex flex-col h-full">
                        <a href="{{ route('product.view', $product->slug) }}" class="block h-full">
                            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="w-full h-56 object-cover rounded-t-lg">
                            <div class="p-4 flex flex-col justify-between h-full">
                                <h3 class="text-lg font-semibold text-gray-700 line-clamp-2">{{ $product->title }}</h3>
                                <p class="text-lg text-gray-600 mt-4">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                            </div>
                        </a>
                        <div class="p-4 flex justify-center">
                            <button @click="addToCart()" class="bg-gradient-to-r from-green-400 to-green-600 text-white py-2 px-4 rounded-full shadow-md hover:from-green-500 hover:to-green-700 transition transform hover:scale-110">
                                Thêm Vào Giỏ
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
