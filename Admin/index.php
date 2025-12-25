<?php
session_start();

// Kiểm tra quyền Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: ../View/form.php?tab=login&status=error&message=Vui lòng đăng nhập quyền Admin!");
    exit();
}
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
            --primary-color: #ff85a2;   /* Hồng dâu */
            --secondary-color: #a2d2ff; /* Xanh pastel */
            --dark-bg: #2d3436;
            --light-bg: #fff5f7;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            display: flex;
            background-color: var(--light-bg);
        }

        /* Sidebar - Thanh menu bên trái */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background-color: white;
            border-right: 3px solid var(--secondary-color);
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            flex-grow: 1;
        }

        .sidebar-menu li a {
            padding: 15px 25px;
            display: block;
            color: #444;
            text-decoration: none;
            transition: 0.3s;
            border-left: 5px solid transparent;
        }

        .sidebar-menu li a:hover {
            background-color: #fff0f3;
            color: var(--primary-color);
            border-left: 5px solid var(--primary-color);
        }

        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
        }

        /* Main Content - Khu vực nội dung bên phải */
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }

        .top-bar {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .content-body {
            padding: 30px;
        }

        /* Card thống kê nhanh */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(255, 133, 162, 0.1);
            border-bottom: 4px solid var(--secondary-color);
        }

        .card h3 { margin: 0; color: #888; font-size: 0.9rem; }
        .card p { margin: 10px 0 0; font-size: 1.8rem; font-weight: bold; color: var(--primary-color); }

        .btn-logout {
            color: #ff4757;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-user-shield"></i> ADMIN PANEL
        </div>
        <ul class="sidebar-menu">
            <li><a href="#"><i class="fas fa-home"></i> Tổng quan</a></li>
            <li><a href="View/quanlysp.php"><i class="fas fa-box"></i> Quản lý Sản phẩm</a></li>
            <li><a href="View/quanlydonhang.php"><i class="fas fa-shopping-cart"></i> Quản lý Đơn hàng</a></li>
            <li><a href="View/quanlyuser.php"><i class="fas fa-users"></i> Quản lý Người dùng</a></li>
            <li><a href="  View/tongdoanhthu.php"><i class="fas fa-chart-line"></i> Báo cáo doanh thu</a></li>
            <li><a href="#"><i class="fas fa-cog"></i> Cài đặt hệ thống</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div>
                <strong>Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</strong>
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
                    <p>120</p>
                </div>
                <div class="card">
                    <h3>Sản phẩm đang bán</h3>
                    <p>45</p>
                </div>
                <div class="card">
                    <h3>Thành viên mới</h3>
                    <p>12</p>
                </div>
                <div class="card">
                    <h3>Doanh thu tháng</h3>
                    <p>15.2M</p>
                </div>
            </div>

            <div class="card" style="min-height: 200px;">
                <h3>Hoạt động gần đây</h3>
                <hr>
                <p style="font-size: 1rem; font-weight: normal; color: #666;">
                    - Admin đã cập nhật sản phẩm "Son môi hồng".<br>
                    - Đơn hàng #1024 vừa được thanh toán thành công.
                </p>
            </div>
        </div>
    </div>

</body>
</html>