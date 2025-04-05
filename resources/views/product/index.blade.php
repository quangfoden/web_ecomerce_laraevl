<x-app-layout>
    <!-- Tìm kiếm và Sắp xếp -->
    <div class="mat-60 flex flex-col md:flex-row gap-4 items-center p-6 bg-gradient-to-r from-blue-500 via-teal-400 to-green-500 text-white rounded-lg shadow-md" x-data="{
        selectedSort: '{{ request()->get('sort', '-updated_at') }}',
        searchKeyword: '{{ request()->get('search') }}',
        updateUrl() {
            const params = new URLSearchParams(window.location.search)
            if (this.selectedSort && this.selectedSort !== '-updated_at') {
                params.set('sort', this.selectedSort)
            } else {
                params.delete('sort')
            }

            if (this.searchKeyword) {
                params.set('search', this.searchKeyword)
            } else {
                params.delete('search')
            }
            window.location.href = window.location.origin + window.location.pathname + '?' + params.toString();
        }
    }">
        <!-- Tìm kiếm -->
        <input
            x-model="searchKeyword"
            @input="updateUrl"
            type="text"
            name="search"
            placeholder="🔍 Tìm kiếm sản phẩm..."
            class="w-full md:w-2/3 focus:border-blue-500 focus:ring-blue-500 border-gray-300 rounded-lg px-4 py-2 text-gray-800"
        />
        <!-- Sắp xếp -->
        <select
            x-model="selectedSort"
            @change="updateUrl"
            name="sort"
            class="w-full md:w-1/3 focus:border-blue-500 focus:ring-blue-500 border-gray-300 rounded-lg px-4 py-2 text-gray-800"
        >
            <option value="updated_at">Mới nhất</option>
            <option value="price">Giá (Tăng dần)</option>
            <option value="-price">Giá (Giảm dần)</option>
            <option value="title">Tên sản phẩm (A-Z)</option>
            <option value="-title">Tên sản phẩm (Z-A)</option>
        </select>
    </div>

    <!-- Nếu không có sản phẩm -->
    @if($products->count() === 0)
        <div class="text-center text-gray-600 py-16 text-xl">
            Không có sản phẩm nào
        </div>
    @else
        <!-- Danh sách sản phẩm -->
        <div class="section box-allproducts">
            @foreach($products as $product)
                <!-- Sản phẩm -->
                <div
                    x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image ?: '/img/noimage.png',
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product)
                    ]) }})"
                    class="bg-white rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105 flex flex-col"
                >
                    <a href="{{ route('product.view', $product->slug) }}" class="aspect-w-3 aspect-h-2 block overflow-hidden">
                        <img
                            :src="product.image"
                            alt="{{ $product->title }}"
                            class="object-cover rounded-t-lg hover:scale-110 transition-transform"
                        />
                    </a>
                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <a href="{{ route('product.view', $product->slug) }}" class="hover:text-blue-500">
                                {{ $product->title }}
                            </a>
                        </h3>
                        <h5 class="font-bold text-xl text-red-600 mt-2">{{ number_format($product->price, 0, ',', '.') }} vnđ</h5>
                    </div>
                    <div class="p-4 bg-gray-100 rounded-b-lg">
                        <button class="w-full bg-gradient-to-r from-green-400 to-green-600 text-white py-2 px-4 rounded-lg shadow-md hover:from-green-500 hover:to-green-700 transition transform hover:scale-105" @click="addToCart()">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
                <!--/ Sản phẩm -->
            @endforeach
        </div>
        <!-- Phân trang -->
        <div class="text-center mt-6 mb-6 p-6">
            {{ $products->appends(['sort' => request('sort'), 'search' => request('search')])->links() }}
        </div>
    @endif
 
</x-app-layout>
