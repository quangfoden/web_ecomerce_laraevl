<x-app-layout>
    <div class="max-w-md mx-auto my-16 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-5">
            🔐 Đặt lại mật khẩu
        </h2>

        <!-- Hiển thị lỗi xác thực -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Token đặt lại mật khẩu -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Địa chỉ Email -->
            <div class="mb-4">
                <x-label for="email" :value="__('Email')" />
                <x-input id="email" 
                         class="block mt-1 w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
                         type="email" 
                         name="email" 
                         :value="old('email', $request->email)" 
                         required autofocus 
                         placeholder="Nhập địa chỉ email"/>
            </div>

            <!-- Mật khẩu mới -->
            <div class="mb-4">
                <x-label for="password" :value="__('Mật khẩu mới')" />
                <x-input id="password" 
                         class="block mt-1 w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" 
                         type="password" 
                         name="password" 
                         required 
                         placeholder="Nhập mật khẩu mới"/>
            </div>

            <!-- Xác nhận mật khẩu -->
            <div class="mb-4">
                <x-label for="password_confirmation" :value="__('Xác nhận mật khẩu')" />
                <x-input id="password_confirmation" 
                         class="block mt-1 w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
                         type="password" 
                         name="password_confirmation" 
                         required 
                         placeholder="Nhập lại mật khẩu"/>
            </div>

            <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                🔄 Đặt lại mật khẩu
            </button>
        </form>
    </div>
</x-app-layout>
