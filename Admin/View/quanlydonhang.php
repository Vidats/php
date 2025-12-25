<?php
// Admin/View/manage_orders.php
require_once __DIR__ . '/../controller/OrderController.php';
// Include thêm header của Admin nếu bạn có
?>

<div class="container mt-4">
    <h2 class="mb-4">📦 Quản lý đơn hàng (Admin)</h2>
    
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">Cập nhật trạng thái thành công!</div>
    <?php endif; ?>

    <table class="table table-hover border shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái hiện tại</th>
                <th>Thay đổi trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td class="fw-bold">#<?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['full_name']) ?></td>
                <td class="text-danger fw-bold"><?= number_format($order['total_price']) ?>đ</td>
                <td>
                    <?php 
                        $badgeClass = 'bg-secondary';
                        if($order['status'] == 'Đang xử lý') $badgeClass = 'bg-warning text-dark';
                        if($order['status'] == 'Đang giao') $badgeClass = 'bg-primary';
                        if($order['status'] == 'Hoàn thành') $badgeClass = 'bg-success';
                        if($order['status'] == 'Đã hủy') $badgeClass = 'bg-danger';
                    ?>
                    <span class="badge <?= $badgeClass ?>"><?= $order['status'] ?></span>
                </td>
                <td>
                    <form method="POST" action="../controller/OrderController.php" class="d-flex">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="status" class="form-select form-select-sm me-2 shadow-none">
                            <option value="Đang xử lý" <?= $order['status'] == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                            <option value="Đang giao" <?= $order['status'] == 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
                            <option value="Hoàn thành" <?= $order['status'] == 'Hoàn thành' ? 'selected' : '' ?>>Hoàn thành</option>
                            <option value="Đã hủy" <?= $order['status'] == 'Đã hủy' ? 'selected' : '' ?>>Hủy đơn</option>
                        </select>
                        <button name="update_status" class="btn btn-dark btn-sm px-3">Lưu</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>