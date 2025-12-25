<?php
session_start();
require_once '../../Model/db.php';

// 1. CẬP NHẬT QUYỀN TRUY CẬP: Cho phép cả Admin (1) và Nhân viên (2)
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) {
    header("Location: ../../index.php?error=Access Denied");
    exit();
}

$action = $_GET['action'] ?? '';

// --- CHỨC NĂNG THÊM ---
if ($action == 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category = $_POST['category'];
    $gender = $_POST['gender']; // Thêm trường giới tính
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Xử lý ảnh: Upload vào thư mục vật lý nhưng lưu đường dẫn tương đối vào DB
    $image = $_FILES['image']['name'];
    $sub_folder = ($category == 'tui') ? "tui/" : "quanao/"; 
    $db_path = $sub_folder . basename($image); // Lưu: quanao/tenanh.jpg
    $target = "../../image/" . $db_path;        // Đường dẫn vật lý: ../../image/quanao/tenanh.jpg

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO products (name, price, category, image, description, gender) 
                VALUES ('$name', '$price', '$category', '$db_path', '$description', '$gender')";
        $conn->query($sql);
    }
    header("Location: ../View/quanlysp.php?message=Thêm sản phẩm thành công");
    exit();
}

// --- CHỨC NĂNG SỬA ---
if ($action == 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category = $_POST['category'];
    $gender = $_POST['gender'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $sub_folder = ($category == 'tui') ? "tui/" : "quanao/";
        $db_path = $sub_folder . basename($image);
        $target = "../../image/" . $db_path;
        
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "UPDATE products SET name='$name', price='$price', category='$category', image='$db_path', description='$description', gender='$gender' WHERE id=$id";
    } else {
        $sql = "UPDATE products SET name='$name', price='$price', category='$category', description='$description', gender='$gender' WHERE id=$id";
    }

    $conn->query($sql);
    header("Location: ../View/quanlysp.php?message=Cập nhật thành công");
    exit();
}

// --- CHỨC NĂNG XÓA ---
if ($action == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Nhân viên vẫn có quyền xóa sản phẩm, trừ khi bạn muốn chỉ Admin mới được xóa
    $res = $conn->query("SELECT image FROM products WHERE id = $id");
    if ($product = $res->fetch_assoc()) {
        $file_path = "../../image/" . $product['image'];
        if (file_exists($file_path)) { unlink($file_path); }
    }
    
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: ../View/quanlysp.php?message=Đã xóa sản phẩm");
    exit();
}