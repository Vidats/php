<?php
// Model/order.php
require_once 'db.php';

// 1. Lưu đơn hàng mới
function createOrder($conn, $user_id, $full_name, $email, $address, $total_price) {
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $email = mysqli_real_escape_string($conn, $email);
    $address = mysqli_real_escape_string($conn, $address);
    $user_id = intval($user_id);
    
    $sql = "INSERT INTO orders (user_id, full_name, email, address, total_price, status, created_at) 
            VALUES ('$user_id', '$full_name', '$email', '$address', '$total_price', 'Đang xử lý', NOW())";
    
    if ($conn->query($sql)) {
        return $conn->insert_id;
    }
    return false;
}

// 2. Lấy danh sách đơn hàng của một người dùng cụ thể (Để user xem lịch sử)
function getOrdersByUser($conn, $user_id) {
    $user_id = intval($user_id);
    $sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// 3. Lấy TẤT CẢ đơn hàng (Dùng cho trang Admin)
function getAllOrders($conn) {
    $sql = "SELECT * FROM orders ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// 4. Cập nhật trạng thái đơn hàng (Admin duyệt hoặc User hủy)
function updateOrderStatus($conn, $order_id, $new_status) {
    $order_id = intval($order_id);
    $new_status = mysqli_real_escape_string($conn, $new_status);
    $sql = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    return $conn->query($sql);
}

// 5. Thống kê doanh thu: Tính tổng tiền các đơn hàng "Hoàn thành"
function getRevenueStatistics($conn) {
    $sql = "SELECT SUM(total_price) as total_revenue FROM orders WHERE status = 'Hoàn thành'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['total_revenue'] ?? 0;
}
?>