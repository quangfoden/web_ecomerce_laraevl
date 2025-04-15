<?php

/** @var \Illuminate\Database\Eloquent\Collection $products */
$categoryList = \App\Models\Category::getActiveAsTree();

?>
<header
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
    id="header"><!--header-->
    <div id="header-middle" class="header-middle {{ Request::is('/') ? 'page-home' : '' }}"><!--header-middle-->
        <div class="container">
            <div class="row" style="display: flex; align-items: center;">
                <div class="col-sm-1" style="padding: 0;">
                    <div class="logo pull-left">
                        <a href="{{ route('home') }}"><img style="width: 100px;" src="{{ asset('img/logo.png') }}" alt="" /></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="row" style="display: flex; align-items: center; border: 0;">
                        <div class="col-sm-9">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Chuyển đổi điều hướng</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="mainmenu pull-left">
                                <ul class="nav navbar-nav collapse navbar-collapse">
                                    <li><a href="{{ route('home') }}" class="mainmenu {{ Request::is('/') ? 'active' : '' }}">Trang chủ</a></li>
                                    <li class="dropdown">
                                        <a href="{{ route('product') }}" class="mainmenu">Sản phẩm<i class="fa fa-angle-down"></i>
                                        </a>
                                        <x-category-list :category-list="$categoryList" />
                                    </li>
                                    <li><a href="{{ route('news.index') }}" class="mainmenu {{ Request::is('news') ? 'active' : '' }}">Bài viết</a>
                                    </li>
                                    <li><a class="mainmenu" href="{{ route('about') }}">Giới thiệu</a></li>
                                    <li><a class="mainmenu" href="{{ route('support') }}">Liên hệ</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="search-container">
                            <!-- Icon tìm kiếm -->
                            <i class="fa fa-search search-icon"></i>
                            <!-- Ô input tìm kiếm -->
                            <input type="text" class="search-input" placeholder="Tìm kiếm" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @if (!Auth::guest())
                            <li><a href="{{ route('cart.index') }}" class="mainmenu"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                            <li x-data="{open: false}" class="position-relative">
                                <a @click="open = !open" href="#" class="mainmenu"><i class="fa fa-user"></i> Tài khoản
                                </a>
                                <ul class="list_account" style="position: absolute; left: 0;background-color:rgba(0, 0, 0, 0.6);;"
                                    @click.outside="open = false"
                                    x-show="open"
                                    x-transition
                                    x-cloak
                                    class="" style="background-color:rgba(0, 0, 0, 0.6);">
                                    <li class="d-block">
                                        <a
                                            href="{{ route('profile') }}"
                                            class="flex px-3 py-2">
                                            <i class="fa fa-user"></i>
                                            Trang cá nhân
                                        </a>
                                    </li>
                                    <li class="d-block">
                                        <a
                                            href="{{ route('order.index') }}"
                                            class="flex px-3 py-2">
                                            <i class="fa fa-shopping-bag"></i>
                                            Đơn hàng
                                        </a>
                                    </li>
                                    <li class="d-block">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <a href="{{ route('logout') }}"
                                                class="flex px-3 py-2"
                                                onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                                <i class="fa-solid fa-right-from-bracket"></i>
                                                {{ __('Log Out') }}
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @else
                            <li><a href="{{ route('cart.index') }}" class="mainmenu"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                            <li><a href="{{ route('login') }}" class="mainmenu"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                            <li><a href="{{ route('register') }}" class="mainmenu"><i class="fa-solid fa-circle-user"></i> Đăng ký ngay</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

</header><!--/header-->

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const searchContainer = document.querySelector(".search-container");
    const searchIcon = document.querySelector(".search-icon");
    const searchInput = document.querySelector(".search-input");

    // Khi nhấp vào icon, hiển thị ô input
    searchIcon.addEventListener("click", () => {
        searchContainer.classList.toggle("active");
        searchInput.focus(); // Đặt con trỏ vào ô input
    });

    // Khi nhấp ra ngoài, ẩn ô input
    document.addEventListener("click", (e) => {
        if (!searchContainer.contains(e.target)) {
            searchContainer.classList.remove("active");
        }
    });
});
</script>