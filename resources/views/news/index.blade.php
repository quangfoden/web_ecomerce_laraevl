<x-app-layout>

    @section('content')
    <div class="container mx-auto py-8 mat-60">
        <!-- Thanh danh mục tin tức -->
        <div class="tabs-container">
            <ul class="tabs">
                @foreach($categories as $category)
                <li class="tab-item {{ $selectedCategoryId == $category->id ? 'active' : '' }}">
                    <a href="{{ route('news.index', ['category' => $category->id]) }}">
                        {{ $category->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>


        <!-- Danh sách tin tức -->
        <div class="section">
            <div class="container">
                <div class="row">
                    @forelse($news as $article)
                    <div class="col-sm-4 p-10">
                        @include('partials.news-item', ['article' => $article])
                    </div>
                    @empty
                    <p class="col-span-3 text-center text-gray-500">Không có tin tức nào.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Thêm thư viện AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        AOS.init({
            duration: 1000, // Thời gian animation (ms)
            once: true, // Animation chỉ chạy một lần
        });
    });
</script>