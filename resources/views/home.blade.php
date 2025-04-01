<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>
<x-app-layout>
<div id="promoPopup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden w-11/12 sm:w-[600px]">
        <!-- Nút đóng -->
        <button id="closePopup" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 bg-gray-200 hover:bg-gray-300 rounded-full p-2 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Nội dung popup -->
        <a href="{{ route('product') }}" class="block">
            <img src="{{ asset('img/banner/slide2.jpg') }}" alt="Khuyến mãi" class="w-full h-auto">
        </a>
        <div class="p-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">🎉 Ưu Đãi Đặc Biệt 🎉</h2>
            <p class="text-gray-600 mb-6">Khám phá ngay các sản phẩm giảm giá hấp dẫn chỉ có tại <span class="font-semibold text-blue-600">H2C Sports</span>.</p>
            <a href="{{ route('product') }}" class="bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-white py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">Khám Phá Ngay</a>
        </div>
    </div>
</div>

<!-- Banner -->
<div class="relative bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600 pat-50">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('img/banner/slide1.jpg') }}" alt="Slide 1" class="w-full h-[500px] object-cover rounded-lg shadow-lg">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('img/banner/slide2.jpg') }}" alt="Slide 2" class="w-full h-[500px] object-cover rounded-lg shadow-lg">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('img/banner/ad1.jpg') }}" alt="Slide 3" class="w-full h-[500px] object-cover rounded-lg shadow-lg">
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="absolute inset-0 flex items-center justify-center text-center text-white">
        <div data-aos="fade-up">
            <h1 class="text-6xl font-extrabold mb-4 drop-shadow-lg">✨ Chào Mừng Đến Với Cửa Hàng ✨</h1>
            <p class="text-2xl mb-6 font-medium">Khám phá các sản phẩm chất lượng cao với dịch vụ tuyệt vời.</p>
            <a href="{{ route('product') }}" class="bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-black py-4 px-10 rounded-full shadow-lg transition transform hover:scale-110">Khám Phá Ngay</a>
        </div>
    </div>
</div>



<!-- Danh Mục Sản Phẩm -->
<div class="max-w-7xl mx-auto py-20 px-6 bg-gray-100" data-aos="fade-up">
    <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">🎯 Danh Mục Sản Phẩm</h2>
    @if (!empty($categoryList))
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($categoryList as $category)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-105" data-aos="zoom-in">
            <a href="{{ route('byCategory', $category) }}" class="block">
                <img src="{{ $category->url }}" alt="{{ $category->name }}" class="w-full h-48 object-cover rounded-t-lg">
                <div class="p-4 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">{{ $category->name }}</h3>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>


<!-- Banner Quảng Cáo 1 -->
<div class="relative">
    <img src="{{ asset('img/banner/ad3.jpg') }}" alt="Quảng cáo 1" class="w-full h-[400px] object-cover rounded-lg shadow-lg" data-aos="fade-right">
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
        <a href="{{ route('product') }}" 
           class="bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-orange-500 hover:to-yellow-400 text-white py-3 px-8 rounded-full shadow-lg transition transform hover:scale-110 animate-bounce mt-4">
            Xem Ngay
        </a>
    </div>
</div>
<!-- Sản Phẩm Mới -->
@include('partials.new-products', ['products' => $products])

<!-- Banner Quảng Cáo 3 -->
<div class="">
    <img src="{{ asset('img/banner/ad1.jpg') }}" alt="Quảng cáo 3" class="w-full h-[400px] object-cover rounded-lg shadow-lg" data-aos="fade-right">
</div>

<!-- Đánh Giá Của Khách Hàng -->
<div class="py-20 px-6 bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 text-white" data-aos="fade-left">
    <h2 class="text-4xl font-bold text-center mb-12">⭐ Đánh Giá Của Khách Hàng</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white text-gray-800 rounded-lg shadow-md p-6 hover:shadow-lg transition transform hover:scale-105" data-aos="fade-right">
            <div class="flex items-center mb-4">
                <img src="{{ asset('img/cus.jpg') }}" alt="Khách hàng 1" class="w-16 h-16 object-cover rounded-full mr-4 border-2 border-blue-500">
                <div>
                    <h3 class="text-lg font-semibold">Nguyễn Văn A</h3>
                    <div class="text-yellow-400">★★★★★</div>
                </div>
            </div>
            <p class="text-gray-600 italic">"Dịch vụ tuyệt vời! Sản phẩm chất lượng cao, giao hàng nhanh chóng và chăm sóc khách hàng rất chu đáo."</p>
        </div>
        <!-- Thêm các đánh giá khác nếu cần -->
    </div>
</div>

@include('partials.news-item', ['news' => $news])

<!-- Chính Sách -->
<div class="py-20 px-6 bg-gray-100" data-aos="fade-up">
    <h2 class="text-4xl font-bold text-center mb-12 text-gray-800">📜 Chính Sách Của Chúng Tôi</h2>
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Chính Sách 1 -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition transform hover:scale-105" data-aos="fade-right">
            <div class="flex items-center mb-4">
                <i class="fas fa-shipping-fast text-4xl text-blue-500 mr-4"></i>
                <h3 class="text-lg font-semibold text-gray-800">Giao Hàng Nhanh Chóng</h3>
            </div>
            <p class="text-gray-600">Chúng tôi cam kết giao hàng nhanh chóng và đúng hẹn đến tay khách hàng.</p>
        </div>
        <!-- Chính Sách 2 -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition transform hover:scale-105" data-aos="fade-right">
            <div class="flex items-center mb-4">
                <i class="fas fa-undo text-4xl text-green-500 mr-4"></i>
                <h3 class="text-lg font-semibold text-gray-800">Đổi Trả Dễ Dàng</h3>
            </div>
            <p class="text-gray-600">Chính sách đổi trả linh hoạt, giúp khách hàng yên tâm mua sắm.</p>
        </div>
        <!-- Chính Sách 3 -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition transform hover:scale-105" data-aos="fade-right">
            <div class="flex items-center mb-4">
                <i class="fas fa-headset text-4xl text-yellow-500 mr-4"></i>
                <h3 class="text-lg font-semibold text-gray-800">Hỗ Trợ 24/7</h3>
            </div>
            <p class="text-gray-600">Đội ngũ hỗ trợ khách hàng luôn sẵn sàng phục vụ bạn mọi lúc, mọi nơi.</p>
        </div>
    </div>
</div>
</x-app-layout>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        AOS.init({
            duration: 1000,
            once: true,
        });

        new Swiper(".mySwiper", {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 2000
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
        });

        new Swiper("#productSwiper", {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2000
            },
        });

        new Swiper("#newsSwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 2000
            },
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        // Hiển thị popup khi vào trang
        const promoPopup = document.getElementById("promoPopup");
        const closePopup = document.getElementById("closePopup");

        // Hiển thị popup sau 1 giây
        setTimeout(() => {
            promoPopup.classList.remove("hidden");
        }, 1000);

        // Đóng popup khi nhấn nút "X"
        closePopup.addEventListener("click", () => {
            promoPopup.classList.add("hidden");
        });

        // Đóng popup khi click ra ngoài
        promoPopup.addEventListener("click", (e) => {
            if (e.target === promoPopup) {
                promoPopup.classList.add("hidden");
            }
        });
    });
</script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">