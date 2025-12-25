<?php
session_start();
// Kiểm tra quyền truy cập (Admin và Nhân viên)
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) {
    header("Location: ../../View/form.php");
    exit();
}
require_once __DIR__ . '/../controller/OrderController.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        
        .admin-container { 
            max-width: 1100px; 
            margin: 40px auto; 
            background: white; 
            padding: 35px; 
            border-radius: 15px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
        }

        .main-title { 
            color: #C5A085; 
            font-weight: 800; 
            text-transform: uppercase; 
            margin-bottom: 35px; 
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        /* Table Styling */
        .table thead { 
            background-color: #e9ecef; 
            color: #495057; 
        }
        
        .table th {
            border: none;
            padding: 15px;
            font-size: 0.9rem;
            text-transform: none;
        }

        .table td { 
            vertical-align: middle; 
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        /* Badge Status Styling */
        .status-badge {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .status-processing { background-color: #fff3cd; color: #856404; } /* Vàng nhạt */
        .status-shipping { background-color: #cfe2ff; color: #084298; }   /* Xanh nhạt */
        .status-completed { background-color: #d1e7dd; color: #0f5132; }  /* Lục nhạt */
        .status-cancelled { background-color: #f8d7da; color: #842029; }  /* Đỏ nhạt */

        /* Form Controls */
        .form-select-custom {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px;
            font-size: 0.9rem;
            outline: none;
        }

        .btn-save {
            background-color: #fff;
            border: 1px solid #dee2e6;
            color: #333;
            padding: 5px 10px;
            transition: all 0.2s;
        }
        .btn-save:hover {
            background-color: #1a1a1a;
            color: #fff;
        }

        .btn-back {
            background-color: #1a1a1a;
            color: #fff;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-back:hover { color: #ccc; }
    </style>
</head>
<body>

<div class="admin-container">
    <h2 class="text-center main-title">
        <i class="fas fa-shopping-bag"></i> QUẢN LÝ ĐƠN HÀNG HỆ THỐNG
    </h2>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i> Cập nhật trạng thái đơn hàng thành công!
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Tên khách hàng</th>
                    <th>Tổng thanh toán</th>
                    <th>Trạng thái hiện tại</th>
                    <th>Thao tác xử lý</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td class="text-muted">#<?= $order['id'] ?></td>
                    <td><strong><?= htmlspecialchars($order['full_name']) ?></strong></td>
                    <td class="fw-bold text-dark"><?= number_format($order['total_price']) ?>đ</td>
                    <td>
                        <?php 
                            $statusClass = 'status-processing';
                            if($order['status'] == 'Đang giao') $statusClass = 'status-shipping';
                            if($order['status'] == 'Hoàn thành') $statusClass = 'status-completed';
                            if($order['status'] == 'Đã hủy') $statusClass = 'status-cancelled';
                        ?>
                        <span class="status-badge <?= $statusClass ?>">
                           ● <?= $order['status'] ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="../controller/OrderController.php" class="d-flex gap-2">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="status" class="form-select-custom">
                                <option value="Đang xử lý" <?= $order['status'] == 'Đang xử lý' ? 'selected' : '' ?>>Đang xử lý</option>
                                <option value="Đang giao" <?= $order['status'] == 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
                                <option value="Hoàn thành" <?= $order['status'] == 'Hoàn thành' ? 'selected' : '' ?>>Hoàn thành</option>
                                <option value="Đã hủy" <?= $order['status'] == 'Đã hủy' ? 'selected' : '' ?>>Hủy đơn</option>
                            </select>
                            <button name="update_status" class="btn btn-save shadow-sm">
                                <i class="fas fa-save"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="../index.php" class="btn-back">
            <i class="fas fa-home"></i> TRANG QUẢN TRỊ
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>