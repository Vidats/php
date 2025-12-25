<?php
// Admin/Model/AdminOrderModel.php
require_once __DIR__ . '/../../Model/db.php';

function getAllOrdersAdmin($conn) {
    $sql = "SELECT * FROM orders ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function updateOrderStatusAdmin($conn, $order_id, $status) {
    $order_id = intval($order_id);
    $status = mysqli_real_escape_string($conn, $status);
    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    return $conn->query($sql);
}