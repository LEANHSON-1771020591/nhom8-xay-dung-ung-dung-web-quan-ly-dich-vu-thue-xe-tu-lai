<head>
    <link rel="stylesheet" href="../src/assets/style/owner.css">
    <link rel="stylesheet" href="../src/assets/style/modal.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include __DIR__ . '/../view/components/nav.php'; ?>

    <div class="banner">
        
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                
                <h2>Đăng ký xe cho thuê</h2>
                <p class="modal-description">Bạn vui lòng điền đầy đủ thông tin, Vato sẽ liên hệ với bạn trong vòng một ngày làm việc.</p>

                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="rental-area">Khu vực cho thuê</label>
                        <select id="rental-area" name="rental_area" class="form-control">
                            <option value="" disabled selected>Chọn khu vực</option>
                            <option value="hcm">TP. Hồ Chí Minh</option>
                            <option value="hanoi">Hà Nội</option>
                            <option value="danang">Đà Nẵng</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="owner-name">Tên chủ xe*</label>
                            <input type="text" id="owner-name" name="owner_name" class="form-control" placeholder="Tên của bạn">
                        </div>
                        <div class="form-group">
                            <label for="phone-number">Số di động*</label>
                            <input type="tel" id="phone-number" name="phone_number" class="form-control" placeholder="Số của bạn">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="car-type">Xe cho thuê</label>
                        <input type="text" id="car-type" name="car_type" class="form-control" placeholder="Loại xe của bạn">
                    </div>

                    <button type="submit" class="submit-button">Gửi thông tin đến Vato</button>
                </form>

            </div>
        </div>


        <div class="banner-card">
            <h1><span>Cho Thuê Xe</span> Trên Vato Để Gia Tăng Thu Nhập Đến 10tr/Tháng!</h1>
            <p>Vato không thu phí khi bạn đăng xe. Bạn chỉ chia sẻ phí dịch vụ với Vato khi có giao dịch cho thuê
                thành
                công.</p>
            <hr class="line">
            <p>Hotline: 1900 9217 (7AM - 10PM)</p>
            <p>Hoặc để lại tin nhắn cho Vato qua Fanpage</p>
            <button id="openModal">Đăng ký ngay</button>
        </div>
    </div>


    <script src="../src/assets/js/modal.js"></script>
</body>