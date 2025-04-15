<x-app-layout>
<div class="contact-container">
    <div class="contact-grid">
        <!-- Form liên hệ -->
        <div class="contact-form">
            <h1 class="contact-title">Liên hệ với chúng tôi</h1>
            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" id="name" name="name" placeholder="Nhập họ và tên">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email">
                </div>
                <div class="form-group">
                    <label for="message">Nội dung</label>
                    <textarea id="message" name="message" rows="5" placeholder="Nhập nội dung liên hệ"></textarea>
                </div>
                <button type="button" class="btn-submit">Gửi liên hệ</button>
            </form>
        </div>

        <!-- Google Maps -->
        <div class="contact-map">
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