<?php
session_start();
require_once __DIR__ . '/../functions/db_connection.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['login_username'] ?? '');
    $password = trim($_POST['login_password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $conn = getDbConnection();
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE Username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if ($user['Password'] === $password) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['username'] = $user['Username'];
                $_SESSION['user_id'] = $user['UserID'];
                $_SESSION['role'] = $user['Role'];
                header('Location: home.php');
                exit();
            } else {
                $error_message = 'Mật khẩu không đúng!';
            }
        } else {
            $error_message = 'Tài khoản không tồn tại!';
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        $error_message = 'Vui lòng nhập đầy đủ thông tin!';
    }
}
?>
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

                <?php if (!empty($error_message)): ?>
                    <div class="error-message" style="margin-bottom:1rem;">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <form class="auth-form" method="POST" data-live="1">
                    <div class="form-group">
                        <label for="login-username">Tên đăng nhập</label>
                        <input type="text" id="login-username" name="login_username" placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label for="login-password">Mật khẩu</label>
                        <div class="password-wrapper">
                            <input type="password" id="login-password" name="login_password" placeholder="" required>
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

                <p class="footer-text">Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
            </div>
        </div>
    </div>

    <script src="js/script.js?v=3"></script>
</body>
</html>

