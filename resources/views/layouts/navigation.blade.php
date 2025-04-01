<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>
<header style="background-color: #001A2D; position: fixed;top:0;width: 100%; height: 50px; z-index: 1000;"
    x-data="{
        mobileMenuOpen: false,
        cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }},
            searchKeyword: '{{ request()->get('search') }}',
            updateUrl() {
                const params = new URLSearchParams(window.location.search)
                if (this.selectedSort && this.selectedSort !== '-updated_at') {
                    params.set('sort', this.selectedSort)
                } else {
                    params.delete('sort')
                }

                if (this.searchKeyword) {
                    params.set('search', this.searchKeyword)
                } else {
                    params.delete('search')
                }
                window.location.href = window.location.origin + window.location.pathname + '?'
                + params.toString();
            }
    }"
    @cart-change.window="cartItemsCount = $event.detail.count"
    class="shadow-md text-white">
    <!-- Responsive Menu -->
    <div style="margin-top:50px;"
        class="block fixed z-10 top-0 bottom-0 height h-full w-[220px] transition-all bg-slate-900 md:hidden"
        :class="mobileMenuOpen ? 'left-0' : '-left-[220px]'">
        <ul>
            <li>
                <a
                    href="{{ route('cart.index') }}"
                    class="relative flex items-center justify-between py-2 px-3 transition-colors hover:bg-slate-800">
                    <div class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2 -mt-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cart
                    </div>
                    <!-- Cart Items Counter -->
                    <small
                        x-show="cartItemsCount"
                        x-transition
                        x-text="cartItemsCount"
                        x-cloak
                        class="py-[2px] px-[8px] rounded-full bg-red-500"></small>
                    <!--/ Cart Items Counter -->
                </a>
            </li>
            @if (!Auth::guest())
            <li x-data="{open: false}" class="relative">
                <a
                    @click="open = !open"
                    class="cursor-pointer flex justify-between items-center py-2 px-3 hover:bg-slate-800">
                    <span class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Tài khoản
                    </span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <ul
                    x-show="open"
                    x-transition
                    class="z-10 right-0 bg-slate-800 py-2">
                    <li>
                        <a href="{{ route('profile') }}" class="flex px-3 py-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Trang cá nhân
                        </a>
                    </li>
                    <li class="">
                        <a
                            href="{{ route('order.index') }}"
                            class="flex items-center px-3 py-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Đơn hàng
                        </a>
                    </li>
                    <li class="">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                                class="flex items-center px-3 py-2"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
            @else
            <li>
                <a
                    href="{{ route('login') }}"
                    class="flex items-center py-2 px-3 transition-colors hover:bg-slate-800">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Đăng nhập
                </a>
            </li>
            <li class="px-3 py-3">
                <a
                    href="{{ route('register') }}"
                    class="block text-center text-white bg-emerald-600 py-2 px-3 rounded shadow-md hover:bg-emerald-700 active:bg-emerald-800 transition-colors w-full">
                    Đăng ký ngay
                </a>
            </li>
            @endif
        </ul>
    </div>
    <!--/ Responsive Menu -->
    <nav class="hidden md:block h-full">
        <ul class="flex items-center w-full h-full">
            <a href="{{ route('home') }}" class="block py-navbar-item pl-5"> <img width="70" src="{{ asset('/img/logo.png') }}" alt="logo"> </a>

            <x-category-list :category-list="$categoryList" class="-ml-5 -mt-5 -mr-5 px-4" />
            <li class="news-menu">
                <a
                    href="{{ route('news.index') }}"
                    class="block py-navbar-item pl-5">
                    Tin tức
                </a>
            </li>
            <div class="flex items-center ml-auto space-x-4">
                <li>
                    <div class="relative flex items-center ml-auto space-x-4" x-data="{ showSearch: false }">
                        <!-- Icon tìm kiếm -->
                        <button @click="showSearch = !showSearch" class="p-2">
                            <i class="fas fa-search text-xl cursor-pointer"></i>
                        </button>

                        <!-- Ô input tìm kiếm (ẩn mặc định, hiện khi click vào icon) -->
                        <form style="z-index: 1000;" action="" method="GET" class="absolute right-0 top-full mt-2 w-64 bg-white shadow-lg p-2 rounded-md transition-all duration-300 ease-in-out"
                            x-show="showSearch"
                            x-transition
                            @click.outside="showSearch = false">
                            <x-input type="text" name="search" placeholder="Bạn đang tìm gì?"
                                x-model="searchKeyword" class="w-full border p-2 rounded-md" />
                        </form>
                    </div>


                </li>
                <li>
                    <a
                        href="{{ route('cart.index') }}"
                        class="relative inline-flex items-center py-navbar-item px-navbar-item">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cart
                        <small
                            x-show="cartItemsCount"
                            x-transition
                            x-cloak
                            x-text="cartItemsCount"
                            class="absolute z-[100] top-4 -right-3 py-[2px] px-[8px] rounded-full bg-red-500"></small>
                    </a>
                </li>

                @if (!Auth::guest())
                <li x-data="{open: false}" class="relative">
                    <a
                        @click="open = !open"
                        class="cursor-pointer flex items-center py-navbar-item px-navbar-item pr-5">
                        <span class="flex items-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Tài khoản
                        </span>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 ml-2"
                            viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <ul
                        @click.outside="open = false"
                        x-show="open"
                        x-transition
                        x-cloak
                        class="absolute z-10 right-0 py-2 w-48" style="background-color: #001A2D;">
                        <li>
                            <a
                                href="{{ route('profile') }}"
                                class="flex px-3 py-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Trang cá nhân
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('order.index') }}"
                                class="flex px-3 py-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Đơn hàng
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}"
                                    class="flex px-3 py-2"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 mr-2"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li>
                    <a
                        href="{{ route('login') }}"
                        class="flex items-center py-navbar-item px-navbar-item">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Đăng nhập
                    </a>
                </li>
                <li>
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center text-white bg-emerald-600 py-2 px-3 rounded shadow-md hover:bg-emerald-700 active:bg-emerald-800 transition-colors mx-5">
                        Đăng ký ngay
                    </a>
                </li>
                @endif
            </div>
        </ul>
    </nav>
    <button
        @click="mobileMenuOpen = !mobileMenuOpen"
        class="p-4 block md:hidden">
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
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</header>