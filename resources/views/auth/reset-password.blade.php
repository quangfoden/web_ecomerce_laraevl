<x-app-layout>
    <div class="reset-password-container">
        <h2 class="form-title">
            🔐 Đặt lại mật khẩu
        </h2>

        <!-- Hiển thị lỗi xác thực -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Token đặt lại mật khẩu -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="form-group">
                <x-label for="email" :value="__('Email')" />
                <x-input
                    id="email"
                    class="input"
                    type="email"
                    name="email"
                    :value="old('email', $request->email)"
                    required
                    autofocus
                    placeholder="Nhập địa chỉ email"
                />
            </div>

            <!-- Mật khẩu mới -->
            <div class="form-group">
                <x-label for="password" :value="__('Mật khẩu mới')" />
                <x-input
                    id="password"
                    class="input"
                    type="password"
                    name="password"
                    required
                    placeholder="Nhập mật khẩu mới"
                />
            </div>

            <!-- Xác nhận mật khẩu -->
            <div class="form-group">
                <x-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />
                <x-input
                    id="password_confirmation"
                    class="input"
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Nhập lại mật khẩu"
                />
            </div>

            <button class="btn-submit">
                🔄 Đặt lại mật khẩu
            </button>
        </form>
    </div>
</x-app-layout>
