<?php
session_start();
require_once '../Model/db.php'; // Đảm bảo đường dẫn này đúng với cấu trúc của bạn

// 1. Kiểm tra quyền truy cập (Admin và Nhân viên)
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) {
    header("Location: ../View/form.php?tab=login&status=error&message=Vui lòng đăng nhập tài khoản quản trị!");
    exit();
}

// 2. Lấy dữ liệu thống kê từ SQL
// Tổng đơn hàng
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];

// Sản phẩm đang bán (số lượng > 0)
$total_products = $conn->query("SELECT COUNT(*) as total FROM products WHERE quantity > 0")->fetch_assoc()['total'];

// Thành viên mới (Đăng ký trong tháng hiện tại)
$new_members = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 0 AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())")->fetch_assoc()['total'];

// Doanh thu tháng (Chỉ tính đơn hàng 'Hoàn thành' trong tháng hiện tại)
$revenue_query = $conn->query("SELECT SUM(total_price) as total FROM orders WHERE status = 'Hoàn thành' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
$monthly_revenue = $revenue_query->fetch_assoc()['total'] ?? 0;
?>

<?php
// Truy vấn doanh thu trong tháng hiện tại
$revenue_query = $conn->query("
    SELECT SUM(total_price) as total 
    FROM orders 
    WHERE status = 'Hoàn thành' 
    AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
    AND YEAR(created_at) = YEAR(CURRENT_DATE())
");

// Lấy kết quả, nếu không có đơn hàng nào thì mặc định là 0
$row = $revenue_query->fetch_assoc();
$monthly_revenue = $row['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Trị Hệ Thống - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
            --dark-bg: #1a202c;
            --light-bg: #f8f9fc;
            --text-color: #333;
            --sidebar-width: 250px;
        }

        body { font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; background-color: var(--light-bg); color: var(--text-color); }

        .sidebar { width: var(--sidebar-width); height: 100vh; background-color: var(--dark-bg); position: fixed; display: flex; flex-direction: column; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar-header { padding: 25px 20px; text-align: center; background-color: var(--primary-color); color: white; font-weight: 800; font-size: 1.1rem; letter-spacing: 1px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 10px 0; flex-grow: 1; }
        .sidebar-menu li a { padding: 15px 25px; display: flex; align-items: center; color: #a0aec0; text-decoration: none; transition: 0.3s; border-left: 4px solid transparent; }
        .sidebar-menu li a:hover { background-color: rgba(255,255,255,0.05); color: white; border-left: 4px solid var(--primary-color); }
        .sidebar-menu li a i { margin-right: 12px; font-size: 1.1rem; }

        .main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); min-height: 100vh; }
        .top-bar { background-color: white; padding: 0 30px; height: 70px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 15px rgba(0,0,0,0.05); }
        .content-body { padding: 40px; }

        .dashboard-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px; margin-bottom: 35px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); border: 1px solid #e3e6f0; border-left: 5px solid var(--primary-color); transition: 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .card h3 { margin: 0; color: #4e73df; font-size: 0.75rem; text-transform: uppercase; font-weight: bold; }
        .card p { margin: 10px 0 0; font-size: 1.5rem; font-weight: 700; color: #5a5c69; }

        .btn-logout { color: #e74a3b; text-decoration: none; font-weight: 600; padding: 8px 15px; border-radius: 5px; }
        .btn-logout:hover { background-color: #fff5f5; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-user-shield"></i> ADMIN PANEL
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php"><i class="fas fa-home"></i> Tổng quan</a></li>
            <li><a href="View/quanlysp.php"><i class="fas fa-box"></i> Quản lý Sản phẩm</a></li>
            <li><a href="View/quanlydonhang.php"><i class="fas fa-shopping-cart"></i> Quản lý Đơn hàng</a></li>
            <li><a href="View/quanlyuser.php"><i class="fas fa-user-friends"></i> Quản lý Khách hàng</a></li>
            
            <?php if ($_SESSION['role'] == 1): ?>
                <li><a href="View/quanlynhanvien.php"><i class="fas fa-user-tie"></i> Quản lý Nhân Viên</a></li>
            <?php endif; ?>

            <li><a href="View/tongdoanhthu.php"><i class="fas fa-chart-line"></i> Báo cáo doanh thu</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Cài đặt hệ thống</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div>
                <strong>Xin chào, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</strong> 
                <small class="badge bg-light text-dark border ms-2">
                    <?php echo $_SESSION['role'] == 1 ? 'Quản trị viên' : 'Nhân viên'; ?>
                </small>
            </div>
            <div>
                <a href="../Controller/logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </a>
            </div>
        </div>

        <div class="content-body">
            <h2 style="color: var(--primary-color);">Bảng điều khiển</h2>
            
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Tổng đơn hàng</h3>
                    <p><?php echo number_format($total_orders); ?></p>
                </div>
                <div class="card" style="border-left-color: #1cc88a;">
                    <h3 style="color: #1cc88a;">Sản phẩm đang bán</h3>
                    <p><?php echo number_format($total_products); ?></p>
                </div>
                <div class="card" style="border-left-color: #36b9cc;">
                    <h3 style="color: #36b9cc;">Thành viên mới</h3>
                    <p><?php echo number_format($new_members); ?></p>
                </div>
                <div class="card" style="border-left-color: #f6c23e;">
                    <h3 style="color: #f6c23e;">Doanh thu tháng</h3>
                    <p><?php echo number_format($monthly_revenue / 1000000, 1); ?>M</p>
                </div>
            </div>

            <div class="card" style="min-height: 200px; border-left: none;">
                <h3>Hoạt động gần đây</h3>
                <hr>
                <div style="font-size: 0.95rem; color: #666;">
                    <?php
                    // Lấy 2 hoạt động đơn hàng mới nhất làm mẫu
                    $recent = $conn->query("SELECT full_name, total_price, created_at FROM orders ORDER BY created_at DESC LIMIT 2");
                    while($r = $recent->fetch_assoc()) {
                        echo "<p><i class='fas fa-check-circle text-success me-2'></i> Khách hàng <strong>{$r['full_name']}</strong> vừa đặt đơn hàng trị giá " . number_format($r['total_price']) . "đ (" . date('H:i d/m', strtotime($r['created_at'])) . ")</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>