 <!-- Tin Tức Mới Nhất -->
 <div class="bg-gray-100 py-20" data-aos="fade-up">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">📰 {{$newstitle}}</h2>
            <div id="newsSwiper" class="swiper">
                <div class="swiper-wrapper">
                    @foreach($news as $article)
                    <div class="swiper-slide" data-aos="zoom-in">
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105">
                            <a href="{{ route('news.view', $article->slug) }}" class="block">
                                <img src="{{ $article->url }}" alt="{{ $article->title }}" class="w-full h-56 object-cover rounded-t-lg">
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-700">{{ $article->title }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">{{ $article->created_at->format('d/m/Y') }}</p>
                                    <p class="text-gray-600">{!! \Illuminate\Support\Str::words($article->content, 20, '...') !!}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <!-- Nút Xem Thêm -->
            <div class="text-center mt-12">
                <a href="{{ route('news.index') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 px-8 rounded-full shadow-md hover:from-purple-600 hover:to-blue-500 transition transform hover:scale-105">
                    Xem Thêm
                </a>
            </div>
        </div>
    </div>