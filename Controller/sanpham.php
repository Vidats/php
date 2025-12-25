<?php
// Controller/sanpham.php
require_once '../Model/sanpham.php'; // Gọi Model để lấy dữ liệu

// 1. Nhận tham số lọc từ URL (Ví dụ: ?cat=Kem ốc quế)
$cat = isset($_GET['cat']) ? $_GET['cat'] : '';

// 2. Gọi hàm từ Model để lấy danh sách sản phẩm
$result = get_products($cat);

// 3. (Tùy chọn) Bạn có thể thêm các logic xử lý khác tại đây như phân trang, 
// hoặc xử lý tìm kiếm sản phẩm.

// Cuối cùng: View sẽ gọi file này hoặc file này sẽ bao gồm View tùy cách bạn route.
// Ở đây chúng ta sẽ để View gọi Controller.
?>