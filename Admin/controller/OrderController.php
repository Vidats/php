<?php
// Admin/controller/OrderController.php
require_once __DIR__ . '/../Model/AdminOrderModel.php';

// 1. Xử lý cập nhật trạng thái khi nhấn nút "Lưu"
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    if (updateOrderStatusAdmin($conn, $order_id, $status)) {
        // Có thể thêm session flash message thông báo thành công ở đây
        header("Location: ../View/quanlydonhang.php?status=success");
    } else {
        header("Location: ../View/quanlydonhang.php?status=error");
    }
    exit();
}

// 2. Lấy danh sách để hiển thị ra View
$orders = getAllOrdersAdmin($conn);