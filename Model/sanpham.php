<?php
// Model/sanpham.php
require_once 'db.php'; // Kết nối cơ sở dữ liệu

/**
 * Hàm lấy danh sách sản phẩm có bộ lọc category
 */
function get_products($category = '') {
    global $conn;
    
    $sql = "SELECT * FROM products";
    
    // Nếu có category thì thêm điều kiện lọc
    if (!empty($category)) {
        $category = mysqli_real_escape_string($conn, $category);
        $sql .= " WHERE category = '$category'";
    }
    
    $sql .= " ORDER BY id DESC"; // Sản phẩm mới nhất lên đầu
    return $conn->query($sql);
}

/**
 * Hàm lấy sản phẩm hot/mới (đã có của bạn)
 */
function get_hot_products($limit = 8) {
    global $conn;
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT $limit";
    return $conn->query($sql);
}


?>
<?php
// Model/sanpham.php
require_once 'db.php';

function get_product_by_id($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}
?>