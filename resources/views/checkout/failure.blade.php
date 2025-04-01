<x-app-layout>
    <div class="mat-60 w-[400px] mt-6 mb-6 mx-auto bg-red-500 py-2 px-3 text-white rounded text-center">
        <h1>Thanh toán không thành công</h1>
        <p>{{$message ?? ''}}</p>
        <p class="mt-2">Bạn sẽ được chuyển về trang chủ sau <span id="countdown">5</span> giây.</p>
    </div>

    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = "{{ url('/') }}";
            }
        }, 1000); // Cập nhật mỗi 1 giây
    </script>
</x-app-layout>