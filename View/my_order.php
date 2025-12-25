<?php 
// 1. Nạp các thành phần cần thiết
include 'header.php'; 
require_once '../Model/order.php';

// 2. Xử lý logic Hủy đơn (Lẽ ra nên nằm ở Controller, nhưng để đơn giản bạn có thể để ở đầu View)
if (isset($_POST['cancel_order'])) {
    $order_id = $_POST['order_id'];
    
    // Kiểm tra lại một lần nữa trong DB để đảm bảo trạng thái vẫn là 'Đang xử lý' trước khi hủy
    // Ở đây ta gọi hàm updateOrderStatus đã viết trong Model/order.php
    if (updateOrderStatus($conn, $order_id, 'Đã hủy')) {
        echo "<script>alert('Đã hủy đơn hàng thành công!'); window.location='my_order.php';</script>";
    }
}

// 3. Lấy dữ liệu hiển thị
$user_id = $_SESSION['user_id'];
$orders = getOrdersByUser($conn, $user_id);
?>

<div class="container py-5">
    <h2 class="mb-5 text-uppercase fw-light" style="letter-spacing: 1px;">
        Đơn hàng của bạn
    </h2>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle border-top">
            <thead class="text-white" style="background-color: var(--primary-color);">
                <tr>
                    <th class="py-3 ps-3">MÃ ĐƠN</th>
                    <th class="py-3">NGÀY ĐẶT</th>
                    <th class="py-3">TỔNG TIỀN</th>
                    <th class="py-3">TRẠNG THÁI</th>
                    <th class="py-3 text-end pe-3">HÀNH ĐỘNG</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Bạn chưa có đơn hàng nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="fw-bold ps-3">#<?= $order['id'] ?></td>
                        <td class="text-muted"><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                        <td class="fw-bold"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                        <td>
                            <?php 
                                $status = $order['status'];
                                $badgeClass = 'bg-secondary'; // Default gray
                                if ($status == 'Đang giao') $badgeClass = 'bg-primary';
                                if ($status == 'Hoàn thành') $badgeClass = 'bg-success';
                                if ($status == 'Đã hủy') $badgeClass = 'bg-danger';
                                if ($status == 'Đang xử lý') $badgeClass = 'bg-dark';
                            ?>
                            <span class="badge rounded-0 fw-normal <?= $badgeClass ?>"><?= $status ?></span>
                        </td>
                        <td class="text-end pe-3">
                            <?php if ($status == 'Đang xử lý'): ?>
                                <form method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <button name="cancel_order" class="btn btn-outline-dark btn-sm rounded-0 px-3">
                                        Hủy đơn
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted small">---</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>