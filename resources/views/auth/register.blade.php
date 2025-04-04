<x-app-layout>
    <form
        action="{{ route('register') }}"
        method="post"
        class="w-[400px] mx-auto p-6 my-16"
    >
        @csrf

        <h2 class="text-2xl font-semibold text-center mb-4">Tạo tài khoản mới</h2>
        <p class="text-center text-gray-500 mb-3">
            hoặc
            <a
                href="{{ route('login') }}"
                class="text-sm text-purple-700 hover:text-purple-600"
            >
                Đăng nhập bằng tài khoản hiện có
            </a>
        </p>

        @if (session('error'))
            <div class="py-2 px-3 bg-red-500 text-white mb-2 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>

        <div class="mb-4">
            <x-input placeholder="Your name" type="text" name="name" :value="old('name')" />
        </div>
        <div class="mb-4">
            <x-input placeholder="Your Email" type="email" name="email" :value="old('email')" />
        </div>
        <div class="mb-4">
            <x-input placeholder="Password" type="password" name="password"/>
        </div>
        <div class="mb-4">
            <x-input placeholder="Repeat Password" type="password" name="password_confirmation"/>
        </div>

        <button
            class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
        >
            Tạo tài khoản
        </button>
    </form>
</x-app-layout>
