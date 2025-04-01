<x-app-layout>
    <div class="mat-60 container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Form liên hệ -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-4xl font-bold text-gray-800 mb-6">Liên hệ với chúng tôi</h1>
                <form action="" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Họ và tên</label>
                        <input type="text" id="name" name="name" placeholder="Nhập họ và tên" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" placeholder="Nhập email" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 font-semibold mb-2">Nội dung</label>
                        <textarea id="message" name="message" rows="5" placeholder="Nhập nội dung liên hệ" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg shadow-md">Gửi liên hệ</button>
                </form>
            </div>

            <!-- Google Maps -->
            <div class="rounded-lg overflow-hidden shadow-lg">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.682574839676!2d106.68006831533467!3d10.762622992327846!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3c5b5d5b0b%3A0x2d9b1f3b5b5d5b0b!2zQ8O0bmcgVHkgVGjhuqFvIFRo4buLIFRo4buLIE5naOG7hyBUaOG7iyBOZ2jhu4cgVGjhuqFv!5e0!3m2!1sen!2s!4v1616581234567!5m2!1sen!2s" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</x-app-layout>