<head>
    <link rel="stylesheet" href="../src/assets/style/selectBox.css">
</head>
<body>
    <div class="select-container">
        <div class="custom-select-wrapper">
            <select name="dia-diem" id="select-location">
                <option value="" disabled selected>Chọn Địa điểm</option>
                <option value="hcm">TP. Hồ Chí Minh</option>
                <option value="hn">Hà Nội</option>
                <option value="dn">Đà Nẵng</option>
                <option value="ld">Lâm Đồng</option>
                <option value="hp">Hải Phòng</option>
            </select>
        </div>

        <div class="custom-select-wrapper">
            <select name="xu-huong" id="select-trend">
                <option value="" disabled selected>Chọn Xu hướng</option>
                <option value="dien">Xe điện</option>
                <option value="hybrid">Xe hybrid</option>
                <option value="xang">Xe xăng</option>
            </select>
        </div>

        <div class="custom-select-wrapper">
            <select name="nhu-cau" id="select-need">
                <option value="" disabled selected>Chọn Nhu cầu</option>
                <option value="dilai">Đi lại</option>
                <option value="laimoi">Lái mới</option>
                <option value="dongnguoi">Đông người</option>
                <option value="tiepkhach">Tiếp khách - dự tiệc</option>
                <option value="giadinh">Gia đình</option>
            </select>
        </div>
    </div>

    <script src="../src/assets/js/selectBox.js"></script>
</body>