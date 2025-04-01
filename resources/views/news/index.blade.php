<x-app-layout>

@section('content')
<div class="container mx-auto py-8 mat-60">
    <!-- Thanh danh mục tin tức -->
    <ul class="flex space-x-4 mb-6 border-b pb-2">
        @foreach($categories as $category)
            <li>
                <a href="{{ route('news.index', ['category' => $category->id]) }}"
                   class="px-4 py-2 text-lg font-semibold transition duration-300 {{ $selectedCategoryId == $category->id ? 'text-blue-500 border-b-2 border-blue-500' : 'text-gray-600 hover:text-blue-500 hover:border-b-2 hover:border-blue-500' }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Danh sách tin tức -->
    <div class="grid grid-cols-3 gap-6">
        @forelse($news as $item)
            <div class="border rounded-lg overflow-hidden shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-2xl" data-aos="fade-up">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $item->title }}</h2>
                    <p class="text-gray-600 text-sm">{{ Str::limit(strip_tags(html_entity_decode($item->content)), 100) }}</p>
                    <a href="{{ route('news.view', $item->slug) }}" class="text-blue-500 mt-2 inline-block transition duration-300 hover:text-blue-700">Xem chi tiết</a>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Không có tin tức nào.</p>
        @endforelse
    </div>
</div>
</x-app-layout>

<!-- Thêm thư viện AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        AOS.init({
            duration: 1000, // Thời gian animation (ms)
            once: true, // Animation chỉ chạy một lần
        });
    });
</script>