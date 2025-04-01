<x-app-layout>
    <div class="mat-60 container lg:w-2/3 xl:w-2/3 mx-auto py-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">🛒 Giỏ hàng của bạn</h1>

        <div x-data="{
            cartItems: {{
                json_encode(
                    $products->map(fn($product) => [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image ?: '/img/noimage.png',
                        'title' => $product->title,
                        'price' => $product->price,
                        'size' => $product->size,
                        'quantity' => $cartItems[$product->id]['quantity'],
                        'href' => route('product.view', $product->slug),
                        'removeUrl' => route('cart.remove', $product),
                        'updateQuantityUrl' => route('cart.update-quantity', $product)
                    ]))
            }},
            get cartTotal() {
                return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity, 0).toFixed(2);
            },
        }" class="bg-white p-6 rounded-lg shadow-lg">
            <!-- Product Items -->
            <template x-if="cartItems.length">
                <div>
                    <!-- Product Item -->
                    <template x-for="product of cartItems" :key="product.id">
                        <div x-data="productItem(product)" class="border-b border-gray-200 py-4">
                            <div class="flex flex-col sm:flex-row items-center gap-6">
                                <a :href="product.href" class="w-36 h-36 flex items-center justify-center overflow-hidden rounded-lg bg-gray-100">
                                    <img :src="product.image" class="object-cover w-full h-full" alt="" />
                                </a>
                                <div class="flex flex-col justify-between flex-1">
                                    <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-lg font-semibold text-gray-800" x-text="`${product.title} - ${product.size}`"></h3>
                                        <div x-data="{ formatCurrency(value) { return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value); } }">
                                            <span x-text="formatCurrency(product.price)"></span>
                                        </div>

                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <span class="text-gray-600">Số lượng:</span>
                                            <input
                                                type="number"
                                                min="1"
                                                x-model="product.quantity"
                                                @change="changeQuantity()"
                                                class="ml-3 py-1 px-2 border border-gray-300 focus:border-purple-600 focus:ring-purple-600 rounded w-16" />
                                        </div>
                                        <a href="#" @click.prevent="removeItemFromCart()" class="text-purple-600 hover:text-purple-500 font-semibold">Xóa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <!-- Product Item -->

                    <!-- Cart Summary -->
                    <div class="border-t border-gray-300 pt-6 mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-semibold text-gray-800">Tổng cộng:</span>
                            <span x-data="{ formatCurrency(value) { return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value); } }" id="cartTotal" class="text-2xl font-bold text-red-600" x-text="formatCurrency(cartTotal)"></span>
                        </div>
                        <p class="text-gray-500 mb-6">
                            Vận chuyển và thuế sẽ được tính khi thanh toán.
                        </p>

                        <form action="{{route('cart.checkout')}}" method="post">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg shadow-md hover:from-green-600 hover:to-green-700 transition">
                                Thanh toán
                            </button>
                        </form>
                    </div>
                </div>
            </template>

            <!-- Empty Cart -->
            <template x-if="!cartItems.length">
                <div class="text-center py-12 text-gray-500">
                    <h2 class="text-2xl font-semibold mb-4">Giỏ hàng của bạn đang trống</h2>
                    <p class="mb-6">Hãy thêm sản phẩm vào giỏ hàng để thanh toán.</p>
                    <a href="{{ route('home') }}" class="py-3 px-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-purple-600 hover:to-blue-500 transition">
                        Quay lại trang chủ
                    </a>
                </div>
            </template>
        </div>
    </div>
</x-app-layout>