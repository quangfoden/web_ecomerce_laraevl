<div
    x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image ?: '/img/noimage.png',
                        'title' => $product->title,
                        'price' => $product->price,
                        'sizes' => $product->sizes->map(fn($size) => [
                            'id' => $size->id,
                            'name' => $size->name,
                            'quantity' => $size->pivot->quantity
                        ]),
                        'addToCartUrl' => route('cart.add', $product)
                    ]) }})"
    class="product-image-wrapper" data-aos="fade-up">
    <div class="single-products">
        <div class="productinfo text-center">
            <a href="{{ route('product.view', $product->slug) }}">
                <img src="{{$product->image}}" alt="{{ $product->title }}" />
            </a>
            <a href="{{ route('product.view', $product->slug) }}">
                <h2>{{$product->title}}</h2>
            </a>
            <p>{{ number_format($product->price, 0, ',', '.') }} đ</p>
            <template x-if="product.sizes.length > 0">
                <div class="size-selector-container">
                    <div class="size-selector-checkboxes">
                        <template x-for="size in product.sizes" :key="size.id">
                            <label class="size-checkbox">
                                <input type="radio" :value="size.id" x-model="selectedSize" class="size-checkbox-input" />
                                <span class="size-checkbox-label" x-text="`${size.name}`"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Nút thêm vào giỏ hàng -->
            <a href="javascript:void(0)"
                @click="addToCart()"
                class="btn btn-default add-to-cart"
                :class="{ 'disabled': product.sizes.length > 0 && !selectedSize }">
                <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng
            </a>
        </div>
    </div>
</div>