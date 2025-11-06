<?php
session_start();
require_once __DIR__ . '/../functions/db_connection.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $displayName = trim($_POST['profile_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $conn = getDbConnection();

        // Kiểm tra trùng username
        $stmt = mysqli_prepare($conn, "SELECT 1 FROM users WHERE Username=?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $exists = ($res && mysqli_fetch_row($res));
        mysqli_stmt_close($stmt);

        if ($exists) {
            $message = 'Username đã được sử dụng. Vui lòng chọn username khác.';
            $message_type = 'error';
        } else {
            $stmtInsert = mysqli_prepare($conn, "INSERT INTO users (Username, Password, Role, CreatedAt) VALUES (?, ?, 'owner', NOW())");
            mysqli_stmt_bind_param($stmtInsert, "ss", $username, $password);
            if (mysqli_stmt_execute($stmtInsert)) {
                $message = 'Tạo tài khoản thành công! Bạn có thể đăng nhập ngay.';
                $message_type = 'success';
            } else {
                $message = 'Lỗi tạo tài khoản: ' . mysqli_error($conn);
                $message_type = 'error';
            }
            mysqli_stmt_close($stmtInsert);
        }

        mysqli_close($conn);
    } else {
        $message = 'Vui lòng nhập đầy đủ username và mật khẩu.';
        $message_type = 'error';
    }
}
?>
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
                <img src="images/logo.png" alt="">
                </a>
            </div>

            <?php if ($message): ?>
                <div class="<?php echo $message_type === 'success' ? 'success-message' : 'error-message'; ?>" style="margin-bottom:1rem;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <h1>Tạo tài khoản</h1>
            <p class="subtitle">Đã có tài khoản? <a href="index.php">Đăng nhập</a></p>

            <form class="auth-form" method="POST" data-live="1">
                <div class="form-group">
                    <label for="profile-name">Chúng tôi nên gọi bạn là gì?</label>
                    <input type="text" id="profile-name" name="profile_name" placeholder="Nhập tên hiển thị của bạn">
                </div>

                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" placeholder="Nhập username" required>
                </div>

                <div class="form-group">
                    <label for="password">Tạo mật khẩu</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" placeholder="Mật khẩu" required>
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

