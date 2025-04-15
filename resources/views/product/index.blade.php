<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>
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
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <input style="padding: 5px;"
                        x-model="searchKeyword"
                        @input="updateUrl"
                        type="text"
                        name="search"
                        placeholder="🔍 Tìm kiếm sản phẩm..."
                        class="w-full md:w-2/3 focus:border-blue-500 focus:ring-blue-500 border-gray-300 rounded-lg px-4 py-2 text-gray-800" />
                </div>
                <!-- Sắp xếp -->
                <div class="col-sm-6" style="text-align: end;">
                    <select style="width: 250px; border-radius: 10px; padding: 10px;"
                        x-model="selectedSort"
                        @change="updateUrl"
                        name="sort"
                        class="w-full md:w-1/3 focus:border-blue-500 focus:ring-blue-500 border-gray-300 rounded-lg px-4 py-2 text-gray-800">
                        <option value="updated_at">Mới nhất</option>
                        <option value="price">Giá (Tăng dần)</option>
                        <option value="-price">Giá (Giảm dần)</option>
                        <option value="title">Tên sản phẩm (A-Z)</option>
                        <option value="-title">Tên sản phẩm (Z-A)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Nếu không có sản phẩm -->
    @if($products->count() === 0)
    <div class="text-center text-gray-600 py-16 text-xl">
        Không có sản phẩm nào
    </div>
    @else
    <!-- Danh sách sản phẩm -->
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('partials.sidecategory', ['categories' => $categoryList])
                </div>
                <div class="col-sm-9" data-aos="fade-left">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col-sm-4">
                            @include('partials.product-item', ['product' => $product])
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Phân trang -->
    <div class="text-center p-10 fs-20">
        {{ $products->appends(['sort' => request('sort'), 'search' => request('search')])->links() }}
    </div>
    @endif

</x-app-layout>