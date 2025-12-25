<?php
// Admin/View/manage_orders.php
require_once __DIR__ . '/../controller/OrderController.php'; // Đã bao gồm Model/order.php
$revenue = getRevenueStatistics($conn);
?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5>💰 Tổng doanh thu</h5>
                    <h3><?= number_format($revenue, 0, ',', '.') ?> VNĐ</h3>
                    <small>(Chỉ tính đơn hàng "Hoàn thành")</small>
                </div>
            </div>
        </div>
    </div>
    
    ...
</div>