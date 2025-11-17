<?php
// auth.php
session_start();

if (empty($_SESSION['role_id'])) {
    header('Location: login.php');
    exit;
}

// Nếu muốn chặn 1 số trang chỉ cho admin tổng:
// if ($_SESSION['role_id'] != 1) { ... }
