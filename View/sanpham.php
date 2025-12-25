<?php 
include 'header.php'; 

// GỌI CONTROLLER để xử lý dữ liệu trước khi hiển thị
require_once '../Controller/sanpham.php'; 
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="section-title d-inline-block">Bộ Sưu Tập Mới</h2>
        <p class="mt-3">Phong cách thời thượng – Đẳng cấp phái đẹp</p>
    </div>

    <div class="category-menu mb-5">
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="sanpham.php" class="cat-item <?= $cat == '' ? 'active' : '' ?>">
                <i class="fas fa-border-all"></i> <span>TẤT CẢ</span>
            </a>
            <a href="sanpham.php?cat=ao" class="cat-item <?= $cat == 'quanao' ? 'active' : '' ?>">
                <i class="fas fa-tshirt"></i> <span>QUẦN ÁO</span>
            </a>
            <a href="sanpham.php?cat=giay" class="cat-item <?= $cat == 'giay' ? 'active' : '' ?>">
                <i class="fas fa-shoe-prints"></i> <span>GIÀY DÉP</span>
            </a>
            <a href="sanpham.php?cat=tui" class="cat-item <?= $cat == 'tui' ? 'active' : '' ?>">
                <i class="fas fa-shopping-bag"></i> <span>TÚI XÁCH</span>
            </a>
             <a href="sanpham.php?cat=phukien" class="cat-item <?= $cat == 'phukien' ? 'active' : '' ?>">
                <i class="fas fa-glasses"></i> <span>PHỤ KIỆN</span>
            </a>
        </div>
    </div>

    <div class="row g-4"> 
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-6 col-md-4 col-lg-3 mb-4"> 
                    <div class="card h-100 product-card shadow-sm">
                        <div class="product-img-container">
                            <a href="chitietsp.php?id=<?= $row['id'] ?>">
                                <img src="../image/<?= $row['image'] ?>" class="card-img-top product-image" alt="<?= $row['name'] ?>">
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <a href="chitietsp.php?id=<?= $row['id'] ?>" class="text-decoration-none product-name">
                                    <?= htmlspecialchars($row['name']) ?>
                                </a>
                            </h5>
                            <p class="card-text price-tag"><?= number_format($row['price'], 0, ',', '.') ?>đ</p>
                            <a href="chitietsp.php?id=<?= $row['id'] ?>" class="btn btn-add-to-cart mt-auto">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center w-100'>Hiện chưa có sản phẩm trong danh mục này.</p>";
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>