<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../src/assets/style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container login-container">
        <div class="login">
            <div class="form-wrapper login-form">
                <h1>Đăng nhập</h1>
                <p class="subtitle">Đăng nhập miễn phí để truy cập vào tất cả sản phẩm của chúng tôi</p>

                <form class="auth-form">
                    <div class="form-group">
                        <label for="login-email">Địa chỉ email</label>
                        <input type="email" id="login-email" placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label for="login-password">Mật khẩu</label>
                        <div class="password-wrapper">
                            <input type="password" id="login-password" placeholder="" required>
                            <button type="button" class="toggle-password" onclick="togglePasswordLogin()">
                                <i class="fas fa-eye-slash"></i>
                                <span>Ẩn</span>
                            </button>
                        </div>
                        <p class="helper-text">Sử dụng 8 ký tự trở lên với sự kết hợp của chữ cái, số và ký hiệu</p>
                    </div>

                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" checked>
                            <span>Đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a> của chúng tôi</span>
                        </label>
                    </div>

                    <div class="checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" checked>
                            <span>Đăng ký nhận bản tin hàng tháng của chúng tôi</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </form>

                <p class="footer-text">Đã có tài khoản? <a href="register.php">Đăng ký</a></p>
            </div>
        </div>
    </div>
</body>
</html>

