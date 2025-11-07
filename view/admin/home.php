<?php
session_start();
require_once __DIR__ . '/../functions/db_connection.php';

// Nạp danh sách xe từ DB
$conn = getDbConnection();
$cars = [];
$sql = "
    SELECT 
        c.CarID, c.CarName, c.Brand, c.Year, c.Seats, c.FuelType, c.Transmission,
        c.PricePerDay, c.Location, c.Rating, c.TripsCount, c.Status,
        u.Username AS OwnerName,
        (SELECT i.ImageURL FROM carimages i WHERE i.CarID = c.CarID ORDER BY i.ImageID DESC LIMIT 1) AS ImageURL
    FROM cars c
    LEFT JOIN carowners o ON c.OwnerID = o.OwnerID
    LEFT JOIN users u ON o.UserID = u.UserID
    WHERE c.Status = 'available'
    ORDER BY c.CarID ASC
    LIMIT 8
";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cars[] = $row;
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vato - Thuê xe gia đình trên toàn quốc</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <nav class="vato-header">
        <div class="vato-header__container">
            <div class="vato-header__brand">
                <img src="./images/logo.png" alt="">
            </div>

            <ul class="vato-header__nav">
                <li class="vato-header__nav-item"><a href="#" class="vato-header__nav-link">Về Vato</a></li>
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

    <div class="banner">
        <img src="../src/assets/images/banner.jpg" alt="">
        <p class="banner-title">Vato - Cùng Bạn Trên Mọi Hành Trình</p>
        <div class="line-bg"></div>
        <p class="banner-text">Trải nghiệm sự khác biệt từ <span>hơn 10.000</span> xe gia đình đời mới khắp Việt Nam
        </p>
    </div>

    <div class="promotion-section">
        <div class="promotion-container">
            <p class="promotion-title">Chương Trình Khuyến Mãi</p>
            <p class="promotion-text">Nhận nhiều ưu đãi hấp dẫn từ <span class="promotion-span">Vato</span></p>
            <div class="promotion-grid">
                <div class="promotion-card">
                    <img src="https://n1-cstg.mioto.vn/g/2025/09/17/16/4NMYQ32T.jpg" alt="Halloween Khuyến Mãi">
                </div>

                <div class="promotion-card">
                    <img src="https://n1-cstg.mioto.vn/g/2025/09/01/09/3I8R333Q.jpg" alt="Đặt xe dễ dàng">
                </div>

                <div class="promotion-card">
                    <img src="https://n1-cstg.mioto.vn/g/2025/09/10/09/FYSFNSQ2.jpg" alt="Linh hoạt theo giờ">
                </div>
            </div>
        </div>
    </div>

    <div class="list-car-container">
        <p class="list-car-title">Xe Dành Cho Bạn</p>
        <div class="list-cars">
            <?php if (count($cars) > 0): ?>
                <?php foreach ($cars as $car): ?>
                    <?php
                        $imageURL = !empty($car['ImageURL']) 
                            ? ('../src/assets/images/' . $car['ImageURL']) 
                            : '../src/assets/images/banner.jpg';
                        $ownerOrBrand = !empty($car['OwnerName']) ? $car['OwnerName'] : $car['Brand'];
                    ?>
                    <div class="car">
                        <img src="<?php echo htmlspecialchars($imageURL); ?>" alt="" class="image-car">
                        <p class="name-car"><?php echo htmlspecialchars($car['CarName']); ?></p>
                        <div class="features">
                            <p class="brand"><i class="ri-car-fill"></i> <?php echo htmlspecialchars($ownerOrBrand); ?></p>
                            <p class="seat"><i class="ri-user-fill"></i> <?php echo intval($car['Seats']); ?> chỗ</p>
                            <p class="type"><i class="ri-charging-pile-fill"></i> <?php echo htmlspecialchars($car['FuelType']); ?></p>
                        </div>
                        <p class="location"><i class="ri-map-pin-2-fill"></i> <?php echo htmlspecialchars($car['Location']); ?></p>
                        <div class="infomation">
                            <p class="star"><i class="ri-star-fill"></i> <?php echo number_format(floatval($car['Rating'] ?? 0), 1); ?></p>
                            <p class="trip"><i class="ri-signpost-fill"></i> <?php echo intval($car['TripsCount'] ?? 0); ?> chuyến</p>
                            <p class="price"><?php echo number_format(floatval($car['PricePerDay'] ?? 0), 0, ',', '.'); ?> /ngày</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; color: #666; padding: 1rem;">
                    Chưa có xe khả dụng.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="priority-points">
        <div class="points">
            <img src="https://www.mioto.vn/static/media/thue_xe_co_tai_xe.a6f7dc54.svg" alt="Lái xe an toàn" class="point-image">
            <div class="point-title">Lái xe an toàn cùng Vato</div>
            <div class="point-content">Chuyến đi trên Vato được bảo vệ với Gói bảo hiểm thuê xe tự lái từ MIC & DBV (VNI).
                Khách thuê sẽ chỉ bồi thường tối đa 2.000.000VNĐ trong trường hợp có sự cố ngoài ý muốn.</div>
        </div>
        <div class="points">
            <img src="https://www.mioto.vn/static/media/dich_vu_thue_xe_tu_lai_hanoi.f177339e.svg" alt="Lái xe an toàn" class="point-image">
            <div class="point-title">An tâm đặt xe</div>
            <div class="point-content">Chuyến đi trên Vato được bảo vệ với Gói bảo hiểm thuê xe tự lái từ MIC & DBV (VNI).
                Khách thuê sẽ chỉ bồi thường tối đa 2.000.000VNĐ trong trường hợp có sự cố ngoài ý muốn.</div>
        </div>
        <div class="points">
            <img src="https://www.mioto.vn/static/media/cho_thue_xe_tu_lai_tphcm.1e7cb1c7.svg" alt="Lái xe an toàn" class="point-image">
            <div class="point-title">Thủ tục đơn giản</div>
            <div class="point-content">Không tính phí huỷ chuyến trong vòng 1h sau khi thanh toán giữ chỗ. Hoàn tiền giữ chỗ và bồi thường 100% nếu chủ xe huỷ chuyến trong vòng 7 ngày trước chuyến đi.</div>
        </div>
        <div class="points">
            <img src="https://www.mioto.vn/static/media/cho_thue_xe_tu_lai_hanoi.735438af.svg" alt="Lái xe an toàn" class="point-image">
            <div class="point-title">Thanh toán dễ dàng</div>
            <div class="point-content">Chỉ cần có CCCD gắn chip (Hoặc Passport) & Giấy phép lái xe là bạn đã đủ điều kiện thuê xe trên Vato.</div>
        </div>
        <div class="points">
            <img src="https://www.mioto.vn/static/media/thue_xe_tu_lai_gia_re_hcm.ffd1319e.svg" alt="Lái xe an toàn" class="point-image">
            <div class="point-title">Giao xe tận nơi</div>
            <div class="point-content">Bạn có thể lựa chọn giao xe tận nhà/sân bay... Phí tiết kiệm chỉ từ 15k/km.</div>
        </div>
        <div class="points">
            <img src="https://www.mioto.vn/static/media/thue_xe_tu_lai_gia_re_hanoi.4035317e.svg" alt="Lái xe an toàn" class="point-image">
            <div class="point-title">Dòng xe đa dạng</div>
            <div class="point-content">Hơn 100 dòng xe cho bạn tuỳ ý lựa chọn: Mini, Sedan, CUV, SUV, MPV, Bán tải.</div>
        </div>
    </div>

    <div class="guides-title">Hướng Dẫn Thuê Xe</div>
    <div class="guides-text">Chỉ với 4 bước đơn giản để trải nghiệm thuê xe Mioto một cách nhanh chóng</div>
    <div class="guides">
        <div class="guide">
            <img src="https://www.mioto.vn/static/media/cho_thue_xe_co_taigia_re_tphcm.12455eba.svg" alt="Lái xe an toàn" class="guide-image">
            <div class="guides-content"><span>01</span>
                Đặt xe trên
                app/web Vito</div>
        </div>
        <div class="guide">
            <img src="https://www.mioto.vn/static/media/gia_thue_xe_7cho_tai_tphcm.9455973a.svg" alt="Lái xe an toàn" class="guide-image">
            <div class="guides-content"><span>02</span>
                Nhận xe</div>
        </div>
        <div class="guide">
            <img src="https://www.mioto.vn/static/media/gia_thue_xe_7cho_tai_hanoi.0834bed8.svg" alt="Lái xe an toàn" class="guide-image">
            <div class="guides-content"><span>03</span>
                Bắt đầu
                hành trình</div>
        </div>
        <div class="guide">
            <img src="https://www.mioto.vn/static/media/gia_thue_xe_4cho_tai_tphcm.9dcd3930.svg" alt="Lái xe an toàn" class="guide-image">
            <div class="guides-content"><span>04</span>
                Trả xe & kết thúc
                chuyến đi</div>
        </div>
    </div>

    <div class="about-vato-section">
        <div class="about-vato-container">
            <div class="about-vato-image">
                <img src="https://www.mioto.vn/static/media/thue_xe_co_tai_xe_tphcm_gia_re.84f8483d.png" alt="Vato App">
            </div>
            <div class="about-vato-content">
                <div class="about-vato-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z" fill="#4CAF50" />
                    </svg>
                </div>
                <h2 class="about-vato-title">Bạn muốn biết thêm về Vato?</h2>
                <p class="about-vato-text">
                    Vato kết nối khách hàng có nhu cầu thuê xe với hàng ngàn chủ xe ô tô ở TP.HCM, Hà Nội & các tỉnh thành khác. Vato hướng đến việc xây dựng cộng đồng người dùng ô tô văn minh & uy tín tại Việt Nam.
                </p>
                <button class="about-vato-btn">Tìm hiểu thêm</button>
            </div>
        </div>
    </div>

    <div class="car-rental-section">
        <div class="car-rental-container">
            <div class="car-rental-content">
                <div class="car-rental-icon">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5H6.5C5.84 5 5.28 5.42 5.08 6.01L3 12V20C3 20.55 3.45 21 4 21H5C5.55 21 6 20.55 6 20V19H18V20C18 20.55 18.45 21 19 21H20C20.55 21 21 20.55 21 20V12L18.92 6.01ZM6.5 16C5.67 16 5 15.33 5 14.5S5.67 13 6.5 13 8 13.67 8 14.5 7.33 16 6.5 16ZM17.5 16C16.67 16 16 15.33 16 14.5S16.67 13 17.5 13 19 13.67 19 14.5 18.33 16 17.5 16ZM5 11L6.5 6.5H17.5L19 11H5Z" fill="#4A90E2" />
                    </svg>
                </div>
                <h2 class="car-rental-title">Bạn muốn cho thuê xe?</h2>
                <p class="car-rental-text">
                    Hơn 10.000 chủ xe đang cho thuê hiệu quả trên Vato<br>
                    Đăng ký trở thành đối tác của chúng tôi ngay hôm nay để gia tăng thu nhập hàng tháng.
                </p>
                <div class="car-rental-buttons">
                    <button class="car-rental-btn car-rental-btn-secondary">Tìm hiểu ngay</button>
                    <button class="car-rental-btn car-rental-btn-primary">Đăng ký xe</button>
                </div>
            </div>
            <div class="car-rental-image">
                <img src="https://www.mioto.vn/static/media/thue_xe_oto_tu_lai_di_du_lich_gia_re.fde3ac82.png" alt="Car Rental">
            </div>
        </div>
    </div>

    <script>
        if (!document.querySelector('.vato-header').classList.contains('vato-header-js-added')) {
            document.querySelector('.vato-header__menu-toggle').addEventListener('click', function() {
                document.querySelector('.vato-header__nav').classList.toggle('vato-header--active');
                document.querySelector('.vato-header__menu-toggle').classList.toggle('vato-header--active');
            });
            document.querySelector('.vato-header').classList.add('vato-header-js-added');
        }
    </script>
</body>

</html>
