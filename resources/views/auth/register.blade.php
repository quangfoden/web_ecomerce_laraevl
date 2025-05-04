<x-app-layout>
    <form action="{{ route('register') }}" method="post" class="register-form">
        @csrf

        <h2 class="form-title">Tạo tài khoản mới</h2>
        <p class="form-subtitle">
            hoặc
            <a href="{{ route('login') }}" class="form-link">
                Đăng nhập bằng tài khoản hiện có
            </a>
        </p>

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <div class="form-group">
            <x-input placeholder="Your name" type="text" name="name" :value="old('name')" />
        </div>
        <div class="form-group">
            <x-input placeholder="Your Email" type="email" name="email" :value="old('email')" />
        </div>
        <div class="form-group">
            <x-input placeholder="Password" type="password" name="password"/>
        </div>
        <div class="form-group">
            <x-input placeholder="Repeat Password" type="password" name="password_confirmation"/>
        </div>

        <button class="btn-submit">
            Tạo tài khoản
        </button>
    </form>
</x-app-layout>
