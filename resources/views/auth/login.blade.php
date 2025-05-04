<x-app-layout>
    <form method="POST" action="{{ route('login') }}" class="login-form">
        <h2 class="form-title">Đăng nhập tài khoản của bạn</h2>
        <p class="form-subtitle">
            hoặc
            <a href="{{ route('register') }}" class="form-link">
                Tạo tài khoản mới
            </a>
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        @csrf
        <div class="form-group">
            <x-input type="email" name="email" placeholder="Email..." :value="old('email')"/>
        </div>
        <div class="form-group">
            <x-input type="password" name="password" placeholder="Password..." :value="old('password')" />
        </div>
        <div class="form-options">
            <div class="form-remember">
                <input
                    id="loginRememberMe"
                    type="checkbox"
                    class="checkbox"
                />
                <label for="loginRememberMe">Remember Me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="form-link">
                    Quên mật khẩu?
                </a>
            @endif
        </div>
        <button class="btn-submit">
            Đăng nhập
        </button>
    </form>
</x-app-layout>
