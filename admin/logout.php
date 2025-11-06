<?php
session_start();
// Chỉ xóa session liên quan đến người dùng frontend
unset($_SESSION['user_logged_in'], $_SESSION['username'], $_SESSION['user_id'], $_SESSION['role']);
// Chuyển về trang chủ
header('Location: home.php');
exit();