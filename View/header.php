  <?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../Model/db.php';
// Nạp Model giỏ hàng ở đây để hàm demLoaiSanPham() luôn sẵn sàng
require_once __DIR__ . '/../Model/giohang.php';?>
  
  
  <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luxury Store - Thời Trang Cao Cấp</title>
    <link rel="stylesheet" href="../Content/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
    <div class="logo">
        <i class=""></i> LUXURY<span>STORE</span>
    </div>

    <div class="menu-toggle" id="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>

    <nav id="nav-menu">
        <ul>
            <li><a href="index.php">Trang Chủ</a></li>
            <li><a href="sanpham.php">Sản Phẩm</a></li>
            <li><a href="gioithieu.php">Giới thiệu</a></li>
            <li><a href="Lienhe.php">Liên Hệ</a></li>
        </ul>
    </nav>

   <div class="header-icons">
    <a href="my_order.php" class="me-3 position-relative" title="Đơn hàng của tôi">
        <i class="fas fa-bell"></i>
        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle"></span>
    </a>

    <a href="giohang.php" class="position-relative">
        <i class="fas fa-shopping-cart"></i>
        <?php $count = demLoaiSanPham(); if ($count > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark" style="font-size: 10px;">
                <?php echo $count; ?>
            </span>
        <?php endif; ?>
    </a>
    
    <?php if (isset($_SESSION['full_name'])): ?>
        <span class="user-name" style="margin-left: 10px;">
            <i class="fas fa-user-check"></i> Hi, <?= htmlspecialchars($_SESSION['full_name']) ?>
        </span>
        <a href="../Controller/logout.php" title="Đăng xuất" style="margin-left: 10px;">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    <?php else: ?>
        <a href="form.php"><i class="fas fa-user"></i></a>
    <?php endif; ?>
</div>
</div>
    </header>

    <script>
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.getElementById('nav-menu');

    mobileMenu.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        
        // Đổi icon từ 3 gạch sang dấu X khi mở
        const icon = mobileMenu.querySelector('i');
        if (navMenu.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
</script>