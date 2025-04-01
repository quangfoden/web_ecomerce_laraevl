<x-app-layout>
    <div x-data="productItem({{ json_encode([
            'id' => $product->id,
            'slug' => $product->slug,
            'image' => $product->image ?: '/img/noimage.png',
            'title' => $product->title,
            'price' => $product->price,
            'size' => $product->size,
            'quantity' => $product->quantity,
            'addToCartUrl' => route('cart.add', $product)
        ]) }})" class="mat-60 container mx-auto px-6 py-12">
        
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            <!-- Hình ảnh sản phẩm -->
            <div class="lg:col-span-3">
                <div x-data="{
                    images: {{$product->images->count() ? $product->images->map(fn($im) => $im->url) : json_encode(['/img/noimage.png'])}},
                    activeImage: null,
                    prev() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === 0) index = this.images.length;
                        this.activeImage = this.images[index - 1];
                    },
                    next() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === this.images.length - 1) index = -1;
                        this.activeImage = this.images[index + 1];
                    },
                    init() {
                        this.activeImage = this.images.length > 0 ? this.images[0] : null
                    }
                }" class="relative">
                    <template x-for="image in images">
                        <div x-show="activeImage === image" class="w-full h-[400px] sm:h-[600px] flex items-center justify-center overflow-hidden">
                            <img :src="image" alt="Product Image" class="w-auto h-auto max-h-full object-cover rounded-lg shadow-md"/>
                        </div>
                    </template>

                    <!-- Navigation Buttons for Image -->
                    <a @click.prevent="prev" class="cursor-pointer bg-black/50 text-white absolute left-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full hover:bg-black/70 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <a @click.prevent="next" class="cursor-pointer bg-black/50 text-white absolute right-0 top-1/2 transform -translate-y-1/2 p-3 rounded-full hover:bg-black/70 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>

                    <!-- Image Thumbnails -->
                    <div class="flex mt-4 space-x-2">
                        <template x-for="image in images">
                            <a @click.prevent="activeImage = image" class="cursor-pointer w-20 h-20 border border-gray-300 hover:border-purple-500 flex items-center justify-center p-1 rounded-md transition">
                                <img :src="image" alt="Thumbnail" class="w-full h-full object-cover rounded-md"/>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{$product->title}} <span class="mx-5 text-green-500">{{$product->size?"size":""}} {!! $product->size !!}</span> </h1>
                <div class="text-2xl font-bold text-red-600 mb-6">{{ number_format($product->price, 0, ',', '.') }} vnđ</div>

                <!-- Tình trạng sản phẩm -->
                @if ($product->quantity === 0)
                    <div class="bg-red-500 text-white py-2 px-4 rounded mb-6">
                        Sản phẩm này đã hết hàng
                    </div>
                @endif

                <!-- Chọn số lượng -->
                <div class="flex items-center justify-between mb-6">
                    <label for="quantity" class="font-semibold text-gray-700">Số lượng</label>
                    <input type="number" name="quantity" x-ref="quantityEl" value="1" min="1" class="w-32 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-600 rounded px-3 py-2"/>
                </div>

                <!-- Thêm vào giỏ hàng -->
                <button :disabled="product.quantity === 0" @click="addToCart($refs.quantityEl.value)" class="w-full py-3 bg-gradient-to-r from-purple-600 to-purple-800 text-white font-semibold rounded-lg flex justify-center items-center space-x-2 transition-all hover:from-purple-700 hover:to-purple-900 disabled:cursor-not-allowed disabled:opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Thêm vào giỏ hàng</span>
                </button>

                <!-- Mô tả sản phẩm -->
                <div class="mt-8" x-data="{ expanded: false }">
                    <div x-show="!expanded" x-collapse class="text-gray-600 leading-relaxed" x-html="`{!! $product->description !!}`"></div>
                    <p class="text-right mt-2">
                        <a @click="expanded = !expanded" href="javascript:void(0)" class="text-purple-600 hover:text-purple-800 font-semibold" x-text="expanded ? 'Xem thêm' : 'Thu gọn'"></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
        @include('partials.new-products', ['products' => $products])
</x-app-layout>

<script>
         new Swiper("#productSwiper", {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000
            },
        });
</script>