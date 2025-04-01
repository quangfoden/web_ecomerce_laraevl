<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/logo.jpg') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel E-commerce Website') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SwiperJS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>
<body>
    @include('layouts.navigation')

    <main class="">
        {{ $slot }}
    </main>
    @include('layouts.footer')

    <!-- Biểu tượng liên hệ -->
    <div class="fixed bottom-4 left-4 flex flex-col space-y-4 z-50">
        <!-- Icon Điện thoại -->
        <a href="tel:0377456265" 
           class="bg-green-500 text-white p-4 rounded-full shadow-lg animate-bounce hover:scale-110 transition transform">
            <i class="fas fa-phone-alt text-2xl"></i>
        </a>
        <!-- Icon Zalo -->
        <a href="https://zalo.me/0377456265" target="_blank" 
           class="bg-blue-500 text-white p-4 rounded-full shadow-lg animate-bounce hover:scale-110 transition transform">
            <img src="{{ asset('img/icon-zalo.svg') }}" alt="Zalo" class="w-6 h-6">
        </a>
    </div>

    <!-- Nút Quay Lại Đầu Trang -->
    <button id="backToTop" 
            class="hidden fixed bottom-20 right-4 bg-gray-800 text-white p-3 rounded-full shadow-lg hover:bg-gray-700 transition transform hover:scale-110 z-50">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <!-- Toast -->
    <div
        x-data="toast"
        x-show="visible"
        x-transition
        x-cloak
        @notify.window="show($event.detail.message, $event.detail.type || 'success')"
        class="fixed w-[400px] left-1/2 -ml-[200px] top-16 py-2 px-4 pb-4 text-white"
        :class="type === 'success' ? 'bg-emerald-500' : 'bg-red-500'">
        <div class="font-semibold" x-text="message"></div>
        <button
            @click="close"
            class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Progress -->
        <div>
            <div
                class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10"
                :style="{'width': `${percent}%`}"></div>
        </div>
    </div>
    <!--/ Toast -->
</body>

<!-- SwiperJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Script for Back to Top Button -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const backToTopButton = document.getElementById("backToTop");

        // Hiển thị nút khi cuộn xuống
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove("hidden");
            } else {
                backToTopButton.classList.add("hidden");
            }
        });

        // Cuộn lên đầu trang khi nhấn nút
        backToTopButton.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    });
</script>
<!-- SwiperJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</html>