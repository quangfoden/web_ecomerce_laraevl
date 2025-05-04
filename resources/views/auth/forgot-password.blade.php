<x-app-layout>
    <form action="{{ route('password.email') }}" method="post" class="reset-password-form">
        @csrf
        <h2 class="form-title">
            🔑 Đặt lại mật khẩu
        </h2>

        <!-- Thông báo trạng thái -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <p class="form-description">
            Nhập email của bạn để nhận liên kết đặt lại mật khẩu.
        </p>

        <div class="form-group">
            <x-input
                id="email"
                class="input"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                placeholder="Nhập địa chỉ email của bạn"
            />
        </div>

        <button class="btn-submit">
            📩 Gửi liên kết đặt lại mật khẩu
        </button>

        <p class="form-footer">
            hoặc
            <a href="{{ route('login') }}" class="form-link">
                đăng nhập với tài khoản hiện có
            </a>
        </p>
    </form>
</x-app-layout>
