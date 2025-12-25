<?php
// View/giohang.php
require_once '../Controller/giohang.php'; // Nạp Controller trước để xử lý logic
include 'header.php'; // Nạp header sau

$cart_items = getCartData();
?>

<div class="container py-5">
    <h2 class="mb-4 text-uppercase fw-light" style="letter-spacing: 2px;">Giỏ hàng của bạn</h2>
    <?php if (empty($cart_items)): ?>
        <div class="alert alert-light text-center border-0" style="background-color: var(--bg-light);">
            Giỏ hàng của bạn đang trống. <br>
            <a href="sanpham.php" class="btn btn-dark mt-3 rounded-0 px-4">TIẾP TỤC MUA SẮM</a>
        </div>
    <?php else: ?>
        <table class="table align-middle">
            <thead class="text-white" style="background-color: var(--primary-color);">
                <tr>
                    <th class="py-3 ps-4">SẢN PHẨM</th>
                    <th class="py-3">THÔNG TIN</th>
                    <th class="py-3">GIÁ</th>
                    <th class="py-3">SỐ LƯỢNG</th>
                    <th class="py-3">THÀNH TIỀN</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td class="ps-4">
                            <img src="../image/<?php echo $item['hinh']; ?>" width="80" class="shadow-sm border">
                        </td>
                        <td>
                            <span class="fw-bold text-uppercase" style="font-size: 0.9rem; letter-spacing: 1px;">
                                <?php echo htmlspecialchars($item['tensp']); ?>
                            </span>
                        </td>
                        <td class="text-muted"><?php echo number_format($item['gia'], 0, ',', '.'); ?>đ</td>
                        <td>
                            <div class="input-group input-group-sm rounded-0" style="max-width: 100px;">
                                <a href="../Controller/giohang.php?action=decrease&id=<?php echo $item['id']; ?>" class="btn btn-outline-dark rounded-0 border">-</a>
                                
                                <input type="text" class="form-control text-center shadow-none border-top border-bottom rounded-0" value="<?php echo $item['soluong']; ?>" readonly>
                                
                                <a href="../Controller/giohang.php?action=increase&id=<?php echo $item['id']; ?>" class="btn btn-outline-dark rounded-0 border">+</a>
                            </div>
                        </td>
                        <td class="fw-bold" style="color: var(--primary-color);"><?php echo number_format($item['gia'] * $item['soluong'], 0, ',', '.'); ?>đ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot style="background-color: var(--bg-light);">
                <tr>
                    <th colspan="4" class="text-end py-4 pe-4 text-uppercase text-muted fw-normal">Tổng thanh toán:</th>
                    <th class="fs-4 py-4 fw-bold" style="color: var(--primary-color);"><?php echo number_format(getTotalPrice($cart_items), 0, ',', '.'); ?>đ</th>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between mt-5 align-items-center">
            <form action="../Controller/giohang.php" method="post">
                <button type="submit" name="clear_cart" class="btn text-muted text-decoration-underline" onclick="return confirm('Xóa toàn bộ giỏ hàng?')">Xóa giỏ hàng</button>
            </form>
            <a href="order.php" class="btn btn-dark rounded-0 py-3 px-5 text-uppercase" style="letter-spacing: 1px;">Tiến hành đặt hàng</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>