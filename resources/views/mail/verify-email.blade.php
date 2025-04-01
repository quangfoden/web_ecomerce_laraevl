<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh tài khoản</title>
</head>
<body>
    <h2>Chào {{ $user->name }},</h2>
    <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>My Shop</strong>.</p>
    <p>Vui lòng nhấn vào nút bên dưới để xác minh email của bạn:</p>
    <a href="{{ $verificationUrl }}" 
       style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">
        Xác minh Email
    </a>
    <p>Nếu bạn không yêu cầu đăng ký tài khoản, vui lòng bỏ qua email này.</p>
</body>
</html>
