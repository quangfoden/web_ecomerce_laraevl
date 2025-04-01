<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 mat-60">
        <h1 class="text-3xl font-bold">{{ $news->title }}</h1>
        <p class="text-gray-500 mt-2">{{ $news->created_at->format('d/m/Y') }}</p>
        <img src="{{ $news->url }}" alt="{{ $news->title }}" class="w-full my-4">
        <div class="content">
            {!! html_entity_decode($news->content) !!}
        </div>
    </div>
    @include('partials.news-item', ['news' => $relatedNews])
</x-app-layout>

<script>
     new Swiper("#newsSwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2000
            },
        });
</script>