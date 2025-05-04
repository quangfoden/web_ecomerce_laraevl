<div class="container">
    <!-- Sản Phẩm Mới -->
    <div class="bg-gray-100 py-20" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800 p-2">🛒 {{$title}}</h2>
            <div id="productSwiper" class="swiper">
                <div class="swiper-wrapper">
                    @foreach($products as $product)
                    <div class="swiper-slide">
                        @include('partials.product-item', ['product' => $product])
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>

<script>

</script>