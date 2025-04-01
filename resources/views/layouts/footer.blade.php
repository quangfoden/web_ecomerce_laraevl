<footer class="bg-gradient-to-r from-[#001A2D] to-[#002B45] text-white py-12">
    <div class="container mx-auto px-5 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Cột 1: Thông tin liên hệ -->
        <div>
            <h2 class="text-xl font-bold mb-4">📞 Liên hệ</h2>
            <p class="mb-2"><i class="fas fa-envelope mr-2"></i>Email: <a href="mailto:support@example.com" class="text-gray-300 hover:text-gray-400">support@example.com</a></p>
            <p class="mb-2"><i class="fas fa-phone-alt mr-2"></i>Điện thoại: <a href="tel:+84123456789" class="text-gray-300 hover:text-gray-400">+84 123 456 789</a></p>
            <p><i class="fas fa-map-marker-alt mr-2"></i>Địa chỉ: 123 Đường ABC, Quận 1, TP. HCM</p>
        </div>

        <!-- Cột 2: Các liên kết quan trọng -->
        <div>
            <h2 class="text-xl font-bold mb-4">🔗 Liên kết nhanh</h2>
            <ul class="space-y-3">
                <li><a href="{{ route('about') }}" class="flex items-center text-gray-300 hover:text-gray-400"><i class="fas fa-angle-right mr-2"></i>Về chúng tôi</a></li>
                <li><a href="{{ route('warranty.policy') }}" class="flex items-center text-gray-300 hover:text-gray-400"><i class="fas fa-angle-right mr-2"></i>Chính sách bảo hành</a></li>
                <li><a href="{{ route('terms') }}" class="flex items-center text-gray-300 hover:text-gray-400"><i class="fas fa-angle-right mr-2"></i>Điều khoản sử dụng</a></li>
                <li><a href="{{ route('support') }}" class="flex items-center text-gray-300 hover:text-gray-400"><i class="fas fa-angle-right mr-2"></i>Hỗ trợ khách hàng</a></li>
            </ul>
        </div>

        <!-- Cột 3: Mạng xã hội -->
        <div>
            <h2 class="text-xl font-bold mb-4">🌐 Theo dõi chúng tôi</h2>
            <p class="mb-4">Kết nối với chúng tôi qua các nền tảng mạng xã hội:</p>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/H2C.Sports" target="_blank" class="hover:text-blue-400 transition transform hover:scale-110">
                    <i class="fab fa-facebook text-3xl"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="hover:text-blue-300 transition transform hover:scale-110">
                    <i class="fab fa-twitter text-3xl"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="hover:text-pink-400 transition transform hover:scale-110">
                    <i class="fab fa-instagram text-3xl"></i>
                </a>
                <a href="https://youtube.com" target="_blank" class="hover:text-red-500 transition transform hover:scale-110">
                    <i class="fab fa-youtube text-3xl"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Bản quyền -->
    <div class="mt-12 border-t border-gray-600 pt-6 text-center text-sm text-gray-400">
        <p>© 2025 {{ config('app.name') }}. All rights reserved.</p>
        <p>Thiết kế bởi <a href="https://github.com" target="_blank" class="text-gray-300 hover:text-gray-400">H2C Team</a></p>
    </div>
</footer>