<?php
function getDbConnection() {
    $servername = "127.0.0.1";
    $username   = "root";
    $password   = "";
    $dbname     = "carrentaldb"; 
    $port       = 3306;

    // Tạo kết nối
    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối database thất bại: " . mysqli_connect_error());
    }

    // Charset để hiển thị tiếng Việt đúng
    mysqli_set_charset($conn, "utf8mb4");

    return $conn;
}
?>