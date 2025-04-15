<x-app-layout>
    <div class="news-container" data-aos="fade-up">
        <h1 class="news-title">{{ $news->title }}</h1>
        <p class="news-date">{{ $news->created_at->format('d/m/Y') }}</p>
        <img src="{{ $news->url }}" alt="{{ $news->title }}" class="news-image">
        <div class="news-content">
            {!! html_entity_decode($news->content) !!}
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('partials.newslatest', ['news' => $relatedNews])
            </div>
        </div>
    </div>
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