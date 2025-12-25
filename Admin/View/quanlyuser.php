<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: ../../View/form.php");
    exit();
}
require_once '../../Model/db.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng - Icedream Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-pink: #ff85a2; --pastel-blue: #a2d2ff; }
        body { background-color: #fcfcfc; font-family: 'Segoe UI', sans-serif; }
        .admin-container { max-width: 1100px; margin: 40px auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .main-title { color: var(--primary-pink); font-weight: 800; text-transform: uppercase; margin-bottom: 30px; }
        .table thead { background-color: #eef6ff; }
        .badge-active { background-color: #2ecc71; color: white; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; }
        .badge-locked { background-color: #e74c3c; color: white; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; }
    </style>
</head>
<body>
<div class="admin-container">
    <h2 class="text-center main-title"><i class="fas fa-users"></i> Quản lý Người dùng</h2>

    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success"><?= $_GET['message'] ?></div>
    <?php endif; ?>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Ngày tạo</th>
                    <th>Quyền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td>#<?= $row['id'] ?></td>
                    <td><strong><?= htmlspecialchars($row['full_name']) ?></strong></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                    <td><?= $row['role'] == 1 ? '<span class="text-primary">Admin</span>' : 'Khách' ?></td>
                    <td>
                        <?= $row['status'] == 1 ? '<span class="badge-active">Hoạt động</span>' : '<span class="badge-locked">Bị khóa</span>' ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="../controller/quanlyuser.php?action=toggle_status&id=<?= $row['id'] ?>" 
                               class="btn btn-sm <?= $row['status'] == 1 ? 'btn-outline-danger' : 'btn-outline-success' ?>"
                               title="<?= $row['status'] == 1 ? 'Khóa tài khoản' : 'Mở khóa' ?>">
                                <i class="fas <?= $row['status'] == 1 ? 'fa-user-slash' : 'fa-user-check' ?>"></i>
                            </a>
                            
                            <a href="../controller/quanlyuser.php?action=delete&id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-outline-dark" 
                               onclick="return confirm('Xác nhận xóa người dùng này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <div class="text-center mt-4">
        <a href="../index.php" class="text-decoration-none text-muted fw-bold"><i class="fas fa-arrow-left"></i> QUAY LẠI</a>
    </div>
</div>
</body>
</html>