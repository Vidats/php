<?php include 'header.php'; ?>
<?php include 'db.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div id="heroBanner" class="hero-banner">
    <div class="container position-relative text-center">
        <img id="bannerImage" src="../image/nen.jpg" 
             class="img-fluid hero-image" 
             alt="Bộ sưu tập thời trang cao cấp">

        <h1 class="display-3">PREMIUM COLLECTION</h1>
        <p class="fs-4">Khám phá phong cách lịch lãm và đẳng cấp thời thượng.</p>
        <a href="sanpham.php" class="btn-hero">Khám Phá Ngay</a>
    </div>
</div>

<div class="container py-5">
    <h2 class="section-title text-center mb-5">Sản Phẩm Mới Nhất</h2>

    <div class="row g-4"> 
    <?php
    // Kết nối theo kiểu MySQLi (theo code cũ của bạn dùng $conn)
    // Nếu db.php dùng PDO, bạn cần đổi đoạn truy vấn này một chút
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 8"; 
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Đường dẫn ảnh: ../image/ + giá trị trong DB (ví dụ: quanao/ao.avif)
            $imgPath = "../image/" . $row['image'];
            
            echo '
            <div class="col-6 col-md-4 col-lg-3 mb-4"> 
                <div class="product-card">
                    <div class="product-img-container">
                        <a href="chitietsp.php?id='.$row['id'].'">
                            <img src="'.$imgPath.'" 
                                 class="product-image" 
                                 alt="'.$row['name'].'">
                        </a>
                        <div class="badge-new">New Arrival</div>
                    </div>

                    <div class="card-body">
                        <h5 class="product-name">
                            <a href="chitietsp.php?id='.$row['id'].'" class="text-decoration-none">
                                '.$row['name'].'
                            </a>
                        </h5>
                        <p class="price-tag">'.number_format($row['price'], 0, ',', '.').'đ</p>
                        <a href="chitietsp.php?id='.$row['id'].'" 
                           class="btn-add-to-cart">
                           Xem Chi Tiết
                        </a>
                    </div>
                </div>
            </div>
            ';
        }
    } else {
        echo "<p class='text-center'>Hiện chưa có sản phẩm trong bộ sưu tập.</p>";
    }
    ?>
    </div>
</div>

<script>
const banners = [
    "../image/nen.jpg",    // Đảm bảo bạn có các file này trong thư mục image
    "../image/nen2.webp",
    "../image/nen3.webp"
];

let current = 0;
const bannerImg = document.getElementById("bannerImage");

if (bannerImg) {
    setInterval(() => {
        current = (current + 1) % banners.length;
        // Thêm hiệu ứng mờ dần khi đổi ảnh (tùy chọn)
        bannerImg.style.opacity = 0.8;
        setTimeout(() => {
            bannerImg.src = banners[current];
            bannerImg.style.opacity = 1;
        }, 300);
    }, 5000); // 5 giây đổi một lần cho sang trọng
}
</script>

<?php include 'footer.php'; ?>