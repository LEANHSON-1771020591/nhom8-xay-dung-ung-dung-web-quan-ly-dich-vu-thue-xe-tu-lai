<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo tài khoản</title>
    <link rel="stylesheet" href="../src/assets/style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-wrapper">
            <div class="avatar">
                <a href="home.php">
                <img src="../src/assets/images/logos/logo.png" alt="">
                </a>
            </div>

            <h1>Tạo tài khoản</h1>
            <p class="subtitle">Đã có tài khoản? <a href="index.php">Đăng nhập</a></p>

            <form class="auth-form">
                <div class="form-group">
                    <label for="profile-name">Chúng tôi nên gọi bạn là gì?</label>
                    <input type="text" id="profile-name" placeholder="Nhập tên hiển thị của bạn" required>
                </div>

                <div class="form-group">
                    <label for="email">Email của bạn là gì?</label>
                    <input type="email" id="email" placeholder="Nhập địa chỉ email của bạn" required>
                </div>

                <div class="form-group">
                    <label for="password">Tạo mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" placeholder="Nhập mật khẩu của bạn" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye-slash"></i>
                            <span>Ẩn</span>
                        </button>
                    </div>
                    <p class="helper-text">Sử dụng 8 ký tự trở lên với sự kết hợp của chữ cái, số và ký hiệu</p>
                </div>

                <p class="terms-text">
                    Bằng cách tạo tài khoản, bạn đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a> của chúng tôi.
                </p>

                <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
            </form>

            <div class="divider">
                <span>HOẶC Tiếp tục với</span>
            </div>

            <div class="social-buttons">
                <button class="btn btn-social">
                    <i class="fab fa-facebook"></i>
                    Facebook
                </button>
                <button class="btn btn-social">
                    <i class="fab fa-google"></i>
                    Google
                </button>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>

