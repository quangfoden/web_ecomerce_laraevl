<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>
<x-app-layout>
    <div id="promoPopup" class="hidden">
        <div class="promoPopup_content">
            <!-- Nút đóng -->
            <button id="closePopup" class="">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <!-- Nội dung popup -->
            <a href="{{ route('product') }}" class="">
                <img src="{{ asset('img/banner/slide2.jpg') }}" alt="Khuyến mãi" class="w-full h-auto">
            </a>
            <div class="">
                <h2 class="">🎉 Ưu Đãi Đặc Biệt 🎉</h2>
                <p class="">Khám phá ngay các sản phẩm giảm giá hấp dẫn chỉ có tại <span class="font-semibold text-blue-600">H2C Sports</span>.</p>
                <a href="{{ route('product') }}" class="goproduct">Khám Phá Ngay</a>
            </div>
        </div>
    </div>

    <!-- Banner -->
    <div class="banner-home" data-aos="fade-right">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="{{ asset('img/banner/slide1.jpg') }}" alt="Slide 1" class="w-full h-[500px] object-cover rounded-lg shadow-lg">
                </div>
                <div class="swiper-slide">
                    <img src="{{ asset('img/banner/ad1.jpg') }}" alt="Slide 3" class="w-full h-[500px] object-cover rounded-lg shadow-lg">
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Danh mục sản phẩm -->
    <div class="section pb-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                @include('partials.categorybox', ['categories' => $categoryList])
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @include('partials.features-product', ['products' => $products,'title'=>'Sản phẩm mới'])
                </div>
            </div>
        </div>
    </div>

    @include('components.product-banner')

    @include('components.policy')

    <!-- News -->
    <div class="section">
        <div class="container">
            <div class="row">
             <div class="col-12">
             @include('partials.newslatest', ['news' => $news, 'newstitle' => 'Tin Tức Mới Nhất'])
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

        new Swiper("#newsSwiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
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
    });

    document.addEventListener("DOMContentLoaded", function() {
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