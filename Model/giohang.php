<?php
// Model/giohang.php
require_once __DIR__ . '/db.php';

function addToCart($id, $soluong) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $check = $conn->query("SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $id");
    
    if ($check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $new_qty = $row['quantity'] + $soluong;
        return $conn->query("UPDATE cart SET quantity = $new_qty WHERE id = " . $row['id']);
    } else {
        return $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $id, $soluong)");
    }
}
function demLoaiSanPham() {
    global $conn;
    if (!isset($_SESSION['user_id'])) return 0;
    
    $user_id = $_SESSION['user_id'];
    // Đếm số dòng (số loại sản phẩm) trong giỏ hàng của user
    $res = $conn->query("SELECT COUNT(*) as total FROM cart WHERE user_id = $user_id");
    $row = $res->fetch_assoc();
    return $row['total'] ?? 0;
}
function updateQuantity($id, $action) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    if ($action == 'increase') {
        return $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $id");
    } elseif ($action == 'decrease') {
        $res = $conn->query("SELECT id, quantity FROM cart WHERE user_id = $user_id AND product_id = $id");
        $row = $res->fetch_assoc();
        if ($row['quantity'] > 1) {
            return $conn->query("UPDATE cart SET quantity = quantity - 1 WHERE id = " . $row['id']);
        } else {
            return $conn->query("DELETE FROM cart WHERE id = " . $row['id']);
        }
    }
}

function getCartItems() {
    global $conn;
    if (!isset($_SESSION['user_id'])) return [];
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT p.id, p.name as tensp, p.price as gia, p.image as hinh, c.quantity as soluong 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = $user_id";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function clearCart() {
    global $conn;
    $user_id = $_SESSION['user_id'];
    return $conn->query("DELETE FROM cart WHERE user_id = $user_id");
}

function getTotalPrice($items) {
    $tong = 0;
    if (is_array($items)) {
        foreach ($items as $item) {
            $tong += $item['gia'] * $item['soluong'];
        }
    }
    return $tong;
}
?>