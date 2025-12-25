<?php
session_start();
// Bảo mật: Chỉ duy nhất Admin (1) được vào trang này
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: ../../View/index.php?error=Ban không có quyền truy cập trang quản lý nhân sự");
    exit();
}
require_once '../../Model/db.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Nhân viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .admin-container { max-width: 1100px; margin: 40px auto; background: white; padding: 35px; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
        .main-title { color: #C5A085; font-weight: 800; text-transform: uppercase; margin-bottom: 35px; letter-spacing: 1px; }
        .table thead { background-color: #1a1a1a; color: white; }
        .badge-staff { background-color: #3498db; color: white; padding: 5px 12px; border-radius: 5px; font-size: 0.75rem; font-weight: bold; }
        .status-on { color: #2ecc71; font-weight: bold; }
        .status-off { color: #e74c3c; font-weight: bold; }
    </style>
</head>
<body>
<div class="admin-container">
    <h2 class="text-center main-title"><i class="fas fa-user-tie"></i> Quản lý Đội ngũ Nhân viên</h2>

    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-info alert-dismissible fade show"><?= htmlspecialchars($_GET['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Tên Nhân Viên</th>
                    <th>Email Công Việc</th>
                    <th>Chức vụ</th>
                    <th>Trạng thái làm việc</th>
                    <th>Quản lý</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Lọc chỉ lấy nhân viên (role = 2)
                $result = $conn->query("SELECT * FROM users WHERE role = 2 ORDER BY id DESC");
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td>#NV<?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><span class="badge-staff">Nhân viên</span></td>
                    <td>
                        <?= $row['status'] == 1 ? '<span class="status-on">● Đang làm việc</span>' : '<span class="status-off">● Đã nghỉ/Khóa</span>' ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="../controller/quanlynhanvien.php?action=toggle_status&id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-light border" title="Thay đổi trạng thái">
                                <i class="fas fa-power-off <?= $row['status'] == 1 ? 'text-danger' : 'text-success' ?>"></i>
                            </a>
                            
                            <a href="../controller/quanlynhanvien.php?action=delete&id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-light border text-dark" 
                               onclick="return confirm('Bạn có chắc muốn xóa nhân viên này khỏi hệ thống?')">
                                <i class="fas fa-user-minus"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-between mt-4">
        <a href="../index.php" class="btn btn-dark btn-sm"><i class="fas fa-home"></i> TRANG QUẢN TRỊ</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>