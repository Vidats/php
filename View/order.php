<?php 
// Nạp Controller để có hàm getCartItems() và getTotalPrice()
require_once '../Controller/giohang.php'; 
include 'header.php'; 

// Lấy danh sách sản phẩm để tính tổng tiền
$cart_items = getCartItems();
$total = getTotalPrice($cart_items);
?>

<div class="container py-5">
    <div class="card mx-auto border-0" style="max-width: 600px; background-color: var(--bg-light);">
        <div class="card-body p-5">
            <h2 class="text-center mb-5 text-uppercase fw-light" style="letter-spacing: 2px; color: var(--primary-color);">Thông tin giao hàng</h2>
            <form action="../Controller/order.php" method="POST">
                <div class="mb-4">
                    <label class="fw-bold text-uppercase small" style="letter-spacing: 1px;">Họ và tên</label>
                    <input type="text" name="full_name" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 bg-transparent shadow-none ps-0" 
                           style="border-bottom: 1px solid #ccc;"
                           value="<?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>" required>
                </div>
                <div class="mb-4">
                    <label class="fw-bold text-uppercase small" style="letter-spacing: 1px;">Email</label>
                    <input type="email" name="email" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 bg-transparent shadow-none ps-0" 
                           style="border-bottom: 1px solid #ccc;"
                           placeholder="Địa chỉ email nhận hóa đơn" required>
                </div>
                <div class="mb-4">
                    <label class="fw-bold text-uppercase small" style="letter-spacing: 1px;">Địa chỉ nhận hàng</label>
                    <textarea name="address" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 bg-transparent shadow-none ps-0" 
                              style="border-bottom: 1px solid #ccc;"
                              rows="2" placeholder="Số nhà, tên đường, phường/xã..." required></textarea>
                </div>
                
                <div class="d-flex justify-content-between align-items-center py-4 border-top border-bottom mb-4">
                    <span class="text-uppercase text-muted">Tổng thanh toán</span>
                    <b class="fs-4" style="color: var(--primary-color);"><?= number_format($total, 0, ',', '.') ?>đ</b>
                </div>
                
                <button type="submit" name="place_order" class="btn btn-dark w-100 rounded-0 py-3 text-uppercase" style="letter-spacing: 2px;">
                    XÁC NHẬN ĐẶT HÀNG
                </button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>