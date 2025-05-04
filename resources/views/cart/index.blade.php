<x-app-layout>
    <div class="container">
        <h1 class="cart-title">🛒 Giỏ hàng của bạn</h1>

        <div x-data="{
            cartItems: {{ json_encode(
                $products->map(fn($product) => [
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'image' => $product->image ?: '/img/noimage.png',
                    'title' => $product->title,
                    'price' => $product->price,
                    'size' => $product->size ?? null, // Hiển thị size nếu có
                    'quantity' => $cartItems[$product->id]['quantity'],
                    'href' => route('product.view', $product->slug),
                    'removeUrl' => route('cart.remove', $product),
                    'updateQuantityUrl' => route('cart.update-quantity', $product)
                ])
            ) }},
            get cartTotal() {
                return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity, 0).toFixed(2);
            },
        }" class="cart-container">
            <!-- Product Items -->
            <template x-if="cartItems.length">
                <div>
                    <!-- Product Item -->
                    <template x-for="product of cartItems" :key="product.id">
                        <div x-data="productItem(product)" class="cart-item">
                            <div class="cart-item-inner">
                                <a :href="product.href" class="cart-image-wrapper">
                                    <img :src="product.image" class="cart-image" alt="" />
                                </a>
                                <div class="cart-info">
                                    <div class="cart-info-header">
                                        <h3 class="cart-item-title" x-text="product.title"></h3>
                                        <div>
                                            <span x-text="new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)"></span>
                                        </div>
                                    </div>
                                    <div class="cart-info-footer">
                                        <div class="cart-quantity">
                                            <span>Số lượng:</span>
                                            <input
                                                type="number"
                                                min="1"
                                                x-model="product.quantity"
                                                @change="changeQuantity()"
                                                class="cart-quantity-input" />
                                        </div>
                                        <div x-show="product.size" class="cart-size">
                                            <span>Size:</span>
                                            <span x-text="product.size"></span>
                                        </div>
                                        <a href="#" @click.prevent="removeItemFromCart()" class="cart-remove-btn">Xóa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Product Item -->

                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="cart-total">
                            <span class="cart-total-title">Tổng cộng:</span>
                            <span id="cartTotal" x-text="new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(cartTotal)" class="cart-total-value"></span>
                        </div>
                        <p class="cart-note">Vận chuyển và thuế sẽ được tính khi thanh toán.</p>
                        <form action="{{ route('cart.checkout') }}" method="post">
                            @csrf
                            <button type="submit" class="cart-checkout-btn">
                                Thanh toán
                            </button>
                        </form>
                    </div>
                </div>
            </template>

            <!-- Empty Cart -->
            <template x-if="!cartItems.length">
                <div class="empty-cart">
                    <h2 class="empty-cart-title">Giỏ hàng của bạn đang trống</h2>
                    <p class="empty-cart-text">Hãy thêm sản phẩm vào giỏ hàng để thanh toán.</p>
                    <a href="{{ route('home') }}" class="empty-cart-back-btn">
                        Quay lại trang chủ
                    </a>
                </div>
            </template>
        </div>
    </div>
</x-app-layout>