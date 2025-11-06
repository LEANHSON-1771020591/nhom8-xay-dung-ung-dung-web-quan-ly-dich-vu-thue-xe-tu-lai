<?php
session_start();
require_once __DIR__ . '/../functions/db_connection.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'registerOwner') {
    $conn = getDbConnection();
    $userId = intval($_SESSION['user_id'] ?? 0);

    if ($userId > 0) {
        $stmt = mysqli_prepare($conn, "SELECT OwnerID FROM carowners WHERE UserID = ?");
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $exists = ($res && mysqli_fetch_assoc($res));
        mysqli_stmt_close($stmt);

        if ($exists) {
            $message = 'Tài khoản của bạn đã là chủ xe.';
            $message_type = 'info';
        } else {
            $ratingDefault = 4.5;
            $stmtInsert = mysqli_prepare($conn, "INSERT INTO carowners (UserID, Rating) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmtInsert, "id", $userId, $ratingDefault);
            if (mysqli_stmt_execute($stmtInsert)) {
                // Cập nhật Role để khớp với admin
                $stmtRole = mysqli_prepare($conn, "UPDATE users SET Role = 'owner' WHERE UserID = ?");
                mysqli_stmt_bind_param($stmtRole, "i", $userId);
                mysqli_stmt_execute($stmtRole);
                mysqli_stmt_close($stmtRole);

                // Cập nhật session role (nếu có dùng ở frontend)
                $_SESSION['role'] = 'owner';

                // Thông báo theo yêu cầu
                $message = 'Bạn đang đăng ký thành công';
                $message_type = 'success';
            } else {
                $message = 'Lỗi đăng ký: ' . mysqli_error($conn);
                $message_type = 'error';
            }
            mysqli_stmt_close($stmtInsert);
        }
    } else {
        $message = 'Vui lòng đăng nhập để đăng ký làm chủ xe.';
        $message_type = 'error';
    }

    mysqli_close($conn);
}

// Thêm xử lý tạo đặt xe giống admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'createBooking') {
    $conn = getDbConnection();
    $carID = intval($_POST['carID'] ?? 0);
    $startDate = $_POST['startDate'] ?? '';
    $endDate = $_POST['endDate'] ?? '';
    $statusInput = $_POST['status'] ?? 'pending';
    $status = ($statusInput === 'cancelled') ? 'canceled' : $statusInput;

    // Lấy/khởi tạo CustomerID theo username hiện tại
    $customerID = 0;
    $fullName = trim($_SESSION['username'] ?? '');
    if ($fullName !== '') {
        $stmtC = mysqli_prepare($conn, "SELECT CustomerID FROM customers WHERE FullName = ? LIMIT 1");
        mysqli_stmt_bind_param($stmtC, "s", $fullName);
        mysqli_stmt_execute($stmtC);
        $resC = mysqli_stmt_get_result($stmtC);
        $rowC = $resC ? mysqli_fetch_assoc($resC) : null;
        mysqli_stmt_close($stmtC);

        if ($rowC) {
            $customerID = intval($rowC['CustomerID']);
        } else {
            // Tạo nhanh khách hàng nếu chưa tồn tại (tối thiểu FullName)
            $stmtAddC = mysqli_prepare($conn, "INSERT INTO customers (FullName) VALUES (?)");
            mysqli_stmt_bind_param($stmtAddC, "s", $fullName);
            if (mysqli_stmt_execute($stmtAddC)) {
                $customerID = mysqli_insert_id($conn);
            }
            mysqli_stmt_close($stmtAddC);
        }
    }

    $startDT = $startDate ? ($startDate . ' 00:00:00') : '';
    $endDT   = $endDate ? ($endDate . ' 00:00:00') : '';

    if ($customerID && $carID && $startDT && $endDT) {
        $startObj = DateTime::createFromFormat('Y-m-d H:i:s', $startDT);
        $endObj   = DateTime::createFromFormat('Y-m-d H:i:s', $endDT);
        if ($startObj && $endObj && $startObj <= $endObj) {
            $sql = "INSERT INTO bookings (CustomerID, CarID, StartDate, EndDate, Status, CreatedAt) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmtB = mysqli_prepare($conn, $sql);
            if ($stmtB) {
                mysqli_stmt_bind_param($stmtB, "iisss", $customerID, $carID, $startDT, $endDT, $status);
                if (mysqli_stmt_execute($stmtB)) {
                    $message = 'Tạo đặt xe thành công!';
                    $message_type = 'success';
                } else {
                    $message = 'Lỗi thực thi: ' . mysqli_error($conn);
                    $message_type = 'error';
                }
                mysqli_stmt_close($stmtB);
            } else {
                $message = 'Lỗi chuẩn bị câu lệnh: ' . mysqli_error($conn);
                $message_type = 'error';
            }
        } else {
            $message = 'Ngày bắt đầu/kết thúc không hợp lệ';
            $message_type = 'error';
        }
    } else {
        $message = 'Thiếu dữ liệu hợp lệ';
        $message_type = 'error';
    }

    mysqli_close($conn);
}

// Tải danh sách xe để hiển thị trong form giống admin
$cars = [];
$connList = getDbConnection();
$cRes = mysqli_query($connList, "SELECT CarID, CarName FROM cars ORDER BY CarName");
if ($cRes) { while ($row = mysqli_fetch_assoc($cRes)) { $cars[] = $row; } }
mysqli_close($connList);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trở thành chủ xe</title>
    <link rel="stylesheet" href="style/owner.css">
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">

</head>

<body>

    <?php if (!empty($message)): ?>
        <div
            class="<?php echo $message_type === 'success' ? 'success-message' : ($message_type === 'error' ? 'error-message' : 'info-message'); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <nav class="vato-header">
        <div class="vato-header__container">
            <div class="vato-header__brand">
                <img src="../src/assets/images/logo.png" alt="">
            </div>

            <ul class="vato-header__nav">
                <li class="vato-header__nav-item"><a href="home.php" class="vato-header__nav-link">Về Vato</a></li>
                <li class="vato-header__nav-item"><a href="becomeOwner.php" class="vato-header__nav-link">Trở thành chủ xe</a></li>

                <?php if (!empty($_SESSION['user_logged_in'])): ?>
                    <li class="vato-header__nav-item">
                        <span class="user-badge"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span>
                    </li>
                    <li class="vato-header__nav-item">
                        <a href="logout.php" class="vato-header__nav-link vato-header__btn vato-header__btn--secondary">Đăng xuất</a>
                    </li>
                <?php else: ?>
                    <li class="vato-header__nav-item">
                        <a href="register.php" class="vato-header__nav-link vato-header__btn vato-header__btn--secondary">Đăng ký</a>
                    </li>
                    <li class="vato-header__nav-item">
                        <a href="index.php" class="vato-header__nav-link vato-header__btn vato-header__btn--primary">Đăng nhập</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="vato-header__menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>


    <section class="owner-hero">
        <div class="owner-hero__card">
            <h2 class="owner-hero__title">Cho Thuê Xe Trên Vato Để Gia Tăng Thu Nhập</h2>
            <p class="owner-hero__desc">Vato không thu phí khi bạn đăng xe. Bạn chỉ chia sẻ phí dịch vụ với Vato khi có
                giao dịch cho thuê thành công.</p>
            <hr style="margin: 1rem 0; border: none; border-top: 1px solid #eee;">
            <p class="owner-hero__desc">Hotline: 0772365592 (10PM - 11PM)</p>
            <button id="openOwnerModal" class="owner-hero__cta">Đăng ký ngay</button>
        </div>
    </section>

    <div id="ownerModal" class="modal-overlay">
        <div class="owner-modal">
            <div class="owner-modal__header">
                <div class="owner-modal__title">Đăng ký xe cho thuê</div>
                <button id="closeOwnerModal" class="owner-modal__close"><i class="ri-close-line"></i></button>
            </div>
            <div class="owner-modal__body">
                <p style="margin-bottom: 1rem;">Bạn vui lòng điền đầy đủ thông tin, VATO sẽ liên hệ với bạn trong vòng
                    một ngày làm việc.</p>
                <form class="owner-form" method="POST">
                    <input type="hidden" name="action" value="registerOwner">
                    <div class="form-group">
                        <label for="region">Khu vực cho thuê</label>
                        <select id="region" name="region" required>
                            <option value="">Chọn khu vực</option>
                            <option value="TP.HCM">TP.HCM</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                            <option value="Khác">Khu vực khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ownerName">Tên chủ xe</label>
                        <input id="ownerName" name="ownerName" type="text" placeholder="Tên của bạn"
                            value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="ownerPhone">Số di động</label>
                        <input id="ownerPhone" name="ownerPhone" type="tel" placeholder="Số của bạn" required>
                    </div>
                    <div class="form-group">
                        <label for="carType">Xe cho thuê</label>
                        <input id="carType" name="carType" type="text" placeholder="Loại xe của bạn" required>
                    </div>
                    <button type="submit" class="owner-form__submit">Gửi thông tin đến VATO</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const openBtn = document.getElementById('openOwnerModal');
        const overlay = document.getElementById('ownerModal');
        const closeBtn = document.getElementById('closeOwnerModal');

        function openModal() {
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        openBtn.addEventListener('click', openModal);
        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });
    </script>
</body>

</html>