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

    <!-- SwiperJS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Font Awesome 6 Free CDN -->

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    @include('layouts.navigation')

    <main class="">
        {{ $slot }}
    </main>
    @include('layouts.footer')

    <!-- Biểu tượng liên hệ -->
    <div class="fixed-icons">
        <!-- Icon Điện thoại -->
        <a href="tel:0377456265"
            class="bg-green-500 text-white p-4 rounded-full shadow-lg animate-bounce hover:scale-110 transition transform">
            <i class="fas fa-phone-alt text-2xl"></i>
        </a>
        <!-- Icon Zalo -->
        <a href="https://zalo.me/0377456265" style="background: #3476ef;" target="_blank"
            class="bg-blue-500 text-white p-4 rounded-full shadow-lg animate-bounce hover:scale-110 transition transform">
            <img src="{{ asset('img/icon-zalo.svg') }}" alt="Zalo" class="w-6 h-6">
        </a>
    </div>

    <!-- Nút Quay Lại Đầu Trang -->
    <button id="backToTop"
        class="">
        <i class="fas fa-arrow-up text-xl"></i>
    </button>

    <!-- Toast -->
    <div
        x-data="toast"
        x-show="visible"
        x-transition
        x-cloak
        @notify.window="show($event.detail.message, $event.detail.type || 'success')"
        class="toast-container"
        :class="type === 'success' ? 'toast-success' : 'toast-error'">
        <div class="toast-message" x-text="message"></div>
        <button
            @click="close"
            class="toast-close-btn">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="toast-close-icon"
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
                class="toast-progress"
                :style="{'width': `${percent}%`}"></div>
        </div>
    </div>
    <!--/ Toast -->
</body>

<!-- SwiperJS CDN -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- Script for Back to Top Button -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js" integrity="sha384-VQqxDN0EQCkWoxt/0vsQvZswzTHUVOImccYmSyhJTp7kGtPed0Qcx8rK9h9YEgx+" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script>
    window.addEventListener('scroll', function() {
        const header = document.getElementById('header-middle');
        if (window.scrollY > 100) { // 100 là khoảng cách scroll bạn muốn
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    });
</script>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000, // thời gian chạy animation (ms)
        easing: 'ease-in-out', // kiểu easing
        once: true, // animation chỉ chạy 1 lần
    });
</script>

</html>