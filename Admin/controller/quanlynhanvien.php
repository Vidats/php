<?php
session_start();
require_once '../../Model/db.php';

// BẢO MẬT CAO: Chỉ cho phép Admin tuyệt đối (role 1)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: ../../index.php?error=Bạn không có quyền quản lý nhân viên");
    exit("Access Denied");
}

$action = $_GET['action'] ?? '';

// --- XỬ LÝ KHÓA / MỞ KHÓA NHÂN VIÊN ---
if ($action == 'toggle_status' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $res = $conn->query("SELECT role, status FROM users WHERE id = $id");
    $user = $res->fetch_assoc();
    
    // Chỉ xử lý nếu đối tượng là Nhân viên (role 2)
    if ($user && $user['role'] == 2) {
        $new_status = ($user['status'] == 1) ? 0 : 1;
        $conn->query("UPDATE users SET status = $new_status WHERE id = $id");
        header("Location: ../View/quanlynhanvien.php?message=Cập nhật trạng thái nhân viên thành công");
    }
    exit();
}

// --- XỬ LÝ XÓA NHÂN VIÊN ---
if ($action == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $res = $conn->query("SELECT role FROM users WHERE id = $id");
    $user = $res->fetch_assoc();

    if ($user && $user['role'] == 2) {
        $conn->query("DELETE FROM users WHERE id = $id");
        header("Location: ../View/quanlynhanvien.php?message=Đã xóa nhân viên");
    }
    exit();
}