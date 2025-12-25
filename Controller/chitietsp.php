<?php
// Controller/chitietsp.php
session_start();
require_once '../Model/sanpham.php';
require_once '../Model/giohang.php';

// --- 1. XỬ LÝ THÊM VÀO GIỎ HÀNG ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: form.php?tab=login&status=error&message=Vui lòng đăng nhập!');
        exit();
    }

    $id = intval($_POST['id']);
    $soluong = intval($_POST['quantity']);

    if ($soluong > 0) {
        // Gọi hàm từ Model/giohang.php (đã chỉnh ở bước trước)
        addToCart($id, $soluong); 
        header('Location: giohang.php');
        exit();
    }
}

// --- 2. LẤY DỮ LIỆU SẢN PHẨM ---
$product = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $product = get_product_by_id($id);
    
    if (!$product) {
        die("Sản phẩm không tồn tại.");
    }
} else {
    die("Không tìm thấy ID sản phẩm.");
}
?>