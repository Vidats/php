<?php
session_start();
require_once '../../Model/db.php';

// Kiểm tra quyền: Cho phép Admin (1) và Nhân viên (2)
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) {
    header("Location: ../../index.php");
    exit("Access Denied");
}

$action = $_GET['action'] ?? '';

// --- XỬ LÝ KHÓA / MỞ KHÓA KHÁCH HÀNG ---
if ($action == 'toggle_status' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Kiểm tra xem có đúng là khách hàng (role 0) không
    $res = $conn->query("SELECT role, status FROM users WHERE id = $id");
    $user = $res->fetch_assoc();

    if ($user && $user['role'] == 0) {
        $new_status = ($user['status'] == 1) ? 0 : 1;
        $conn->query("UPDATE users SET status = $new_status WHERE id = $id");
        header("Location: ../View/quanlykhachhang.php?message=Cập nhật khách hàng thành công");
    } else {
        header("Location: ../View/quanlykhachhang.php?error=Bạn không thể tác động lên tài khoản quản trị");
    }
    exit();
}

// --- XỬ LÝ XÓA KHÁCH HÀNG ---
if ($action == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $res = $conn->query("SELECT role FROM users WHERE id = $id");
    $user = $res->fetch_assoc();

    if ($user && $user['role'] == 0) {
        $conn->query("DELETE FROM users WHERE id = $id");
        header("Location: ../View/quanlykhachhang.php?message=Đã xóa khách hàng");
    } else {
        header("Location: ../View/quanlykhachhang.php?error=Không có quyền xóa tài khoản này");
    }
    exit();
}