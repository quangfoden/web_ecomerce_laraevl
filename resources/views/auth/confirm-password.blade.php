<x-app-layout>
    <div class="max-w-md mx-auto mt-20 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">
            🔒 Xác nhận mật khẩu
        </h2>

        <p class="text-center text-gray-600 mb-4">
            Đây là khu vực bảo mật của ứng dụng. Vui lòng nhập mật khẩu để tiếp tục.
        </p>

        <!-- Hiển thị lỗi xác thực -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Mật khẩu -->
            <div class="mb-4">
                <x-label for="password" :value="__('Mật khẩu')" class="text-gray-700 font-medium" />
                <x-input id="password" 
                         class="block mt-1 w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500"
                         type="password"
                         name="password"
                         required autocomplete="current-password" 
                         placeholder="Nhập mật khẩu của bạn"/>
            </div>

            <div class="flex justify-center">
                <x-button class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
                    ✅ Xác nhận
                </x-button>
            </div>
        </form>
    </div>
</x-app-layout>
