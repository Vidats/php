<?php
// Controller/order.php
session_start();
require_once '../Model/db.php';
require_once '../Model/order.php';
require_once '../Model/giohang.php'; // Sau khi làm bước 1, file này đã có getTotalPrice

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../View/form.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Gọi hàm lấy danh sách sản phẩm từ Model
    $items = getCartItems(); 
    
    // Gọi hàm tính tổng tiền từ Model (đã giải quyết được lỗi Call to undefined function)
    $total_price = getTotalPrice($items); 

    $order_id = createOrder($conn, $user_id, $full_name, $email, $address, $total_price);

    if ($order_id) {
        clearCart(); 
        header('Location: ../View/my_order.php'); // Chuyển hướng đến trang lịch sử đơn hàng
        exit();
    } else {
        echo "Lỗi hệ thống khi đặt hàng: " . $conn->error;
    }
}
?>