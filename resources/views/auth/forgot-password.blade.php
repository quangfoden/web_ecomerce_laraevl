<x-app-layout>
    <form action="{{ route('password.email') }}" method="post" class="max-w-md mx-auto p-6 my-16 bg-white rounded-lg shadow-lg">
        @csrf
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-5">
            🔑 Đặt lại mật khẩu
        </h2>

        <!-- Thông báo trạng thái -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <p class="text-center text-gray-600 mb-6">
            Nhập email của bạn để nhận liên kết đặt lại mật khẩu.
        </p>

        <div class="mb-3">
            <x-input id="email" 
                     class="block mt-1 w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500" 
                     type="email" 
                     name="email" 
                     :value="old('email')" 
                     required autofocus 
                     placeholder="Nhập địa chỉ email của bạn"/>
        </div>

        <button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 px-4 rounded-lg transition-all">
            📩 Gửi liên kết đặt lại mật khẩu
        </button>

        <p class="text-center text-gray-500 mt-6">
            hoặc
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-500 font-semibold">
                đăng nhập với tài khoản hiện có
            </a>
        </p>
    </form>
</x-app-layout>
