<div class="news-item">
    <a href="{{ route('news.view', $article->slug) }}" class="news-link">
        <img src="{{ $article->url }}" alt="{{ $article->title }}" class="news-image">
        <div class="news-content">
            <h3 class="news-title">{{ $article->title }}</h3>
            <p class="news-date">{{ $article->created_at->format('d/m/Y') }}</p>
            <p class="news-excerpt">{!! \Illuminate\Support\Str::words($article->content, 20, '...') !!}</p>
        </div>
    </a>
</div>