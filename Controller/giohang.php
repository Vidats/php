<?php
// Controller/giohang.php
session_start();
require_once __DIR__ . '/../Model/giohang.php';

// Xử lý các hành động từ form (POST) hoặc link (GET)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clear_cart'])) {
        clearCart();
    }
    header('Location: ../View/giohang.php');
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'increase' || $action == 'decrease') {
        updateQuantity($id, $action);
    }
    header('Location: ../View/giohang.php');
    exit();
}

// Hàm bổ trợ cho View
function getCartData() {
    return getCartItems();
}


?>