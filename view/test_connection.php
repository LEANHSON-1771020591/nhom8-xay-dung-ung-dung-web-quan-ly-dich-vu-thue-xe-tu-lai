<?php
require_once __DIR__ . '/../functions/db_connection.php';

$conn = getDbConnection();

// Thử truy vấn đơn giản
$result = mysqli_query($conn, "SELECT 1 AS ok");
$row = mysqli_fetch_assoc($result);

echo ($row && $row['ok'] == 1) ? "Kết nối OK" : "Kết nối không thành công";

mysqli_close($conn);
?>