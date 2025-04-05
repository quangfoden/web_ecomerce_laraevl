 <div class="bg-gray-100 py-20" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="box-title">{{$newstitle}}</h2>
            <div id="newsSwiper" class="swiper">
                <div class="swiper-wrapper">
                    @foreach($news as $article)
                    <div class="swiper-slide" data-aos="zoom-in">
                    @include('partials.news-item', ['article' => $article])
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <!-- Nút Xem Thêm -->
            <div class="text-center mt-12">
                <a href="{{ route('news.index') }}" class="button">
                    Xem Thêm
                </a>
            </div>
        </div>
    </div>