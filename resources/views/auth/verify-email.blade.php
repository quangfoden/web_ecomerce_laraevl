<x-app-layout>
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg p-6 mt-20">
        <h2 class="text-xl font-semibold text-gray-700 text-center">
            🎉 Cảm ơn bạn đã đăng ký!
        </h2>

        <p class="text-gray-600 text-center mt-2">
            Trước khi bắt đầu, vui lòng xác minh địa chỉ email của bạn bằng cách nhấp vào liên kết mà chúng tôi vừa gửi qua email.  
            Nếu bạn không nhận được email, chúng tôi sẽ gửi lại cho bạn.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 p-3 text-green-700 bg-green-100 border border-green-400 rounded-md text-center">
                ✉️ Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.
            </div>
        @endif

        <div class="mt-6 flex justify-center gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    🔄 Gửi lại email xác minh
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 text-gray-700 bg-gray-200 border rounded-lg hover:bg-gray-300 transition duration-300">
                    🚪 Đăng xuất
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
