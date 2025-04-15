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
]) }})" class="product-container">

    <div class="product-grid">

        <!-- Hình ảnh sản phẩm -->
        <div class="image-section">
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
            }" class="image-gallery">
                <template x-for="image in images">
                    <div x-show="activeImage === image" class="main-image">
                        <img :src="image" alt="Product Image" />
                    </div>
                </template>

                <a @click.prevent="prev" class="nav-button prev-button">&#10094;</a>
                <a @click.prevent="next" class="nav-button next-button">&#10095;</a>

                <div class="thumbnails">
                    <template x-for="image in images">
                        <a @click.prevent="activeImage = image" class="thumbnail">
                            <img :src="image" alt="Thumbnail" />
                        </a>
                    </template>
                </div>
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="info-section">
            <h1 class="product-title">{{$product->title}} <span class="product-size">{{$product->size ? 'size' : ''}} {!! $product->size !!}</span></h1>
            <div class="product-price">{{ number_format($product->price, 0, ',', '.') }} vnđ</div>

            @if ($product->quantity === 0)
                <div class="out-of-stock">Sản phẩm này đã hết hàng</div>
            @endif

            <div class="quantity-section">
                <label for="quantity">Số lượng</label>
                <input type="number" name="quantity" x-ref="quantityEl" value="1" min="1"/>
            </div>

            <button :disabled="product.quantity === 0" @click="addToCart($refs.quantityEl.value)" class="add-to-cart-btn">
                🛒 <span>Thêm vào giỏ hàng</span>
            </button>

            <div class="description" x-data="{ expanded: false }">
                <div x-show="!expanded" x-collapse x-html="`{!! $product->description !!}`"></div>
                <p class="toggle-description">
                    <a @click="expanded = !expanded" href="javascript:void(0)" x-text="expanded ? 'Xem thêm' : 'Thu gọn'"></a>
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