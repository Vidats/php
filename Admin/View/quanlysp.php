<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 1 && $_SESSION['role'] != 2)) {
    header("Location: ../../View/form.php");
    exit();
}
require_once '../../Model/db.php';

$edit_product = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $res = $conn->query("SELECT * FROM products WHERE id = $edit_id");
    $edit_product = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm - Icedream Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-pink: #ff85a2;
            --soft-pink: #fff0f3;
            --pastel-blue: #a2d2ff;
            --light-blue: #eef6ff;
            --text-dark: #4a4a4a;
        }

        body {
            background-color: #fcfcfc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }

        .admin-container {
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .main-title {
            color: var(--primary-pink);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        /* Card Form Styles */
        .card-form {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(162, 210, 255, 0.2);
            transition: 0.3s;
        }

        .card-form.editing {
            border: 2px dashed var(--primary-pink);
            background-color: var(--soft-pink);
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary-pink), var(--pastel-blue));
            color: white;
            font-weight: bold;
            border: none;
            padding: 15px 20px;
        }

        .form-label {
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 10px 15px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 133, 162, 0.25);
            border-color: var(--primary-pink);
        }

        /* Table Styles */
        .table-container {
            margin-top: 40px;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--light-blue);
        }

        .table thead {
            background-color: var(--light-blue);
            color: var(--text-dark);
        }

        .table th { border: none; padding: 15px; font-weight: 700; }
        .table td { vertical-align: middle; padding: 15px; border-bottom: 1px solid #f5f5f5; }

        .img-thumb {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .badge-cat {
            background-color: var(--pastel-blue);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Buttons */
        .btn-pink { background-color: var(--primary-pink); color: white; border-radius: 10px; font-weight: 600; border: none; }
        .btn-pink:hover { background-color: #ff6b8e; color: white; transform: translateY(-2px); }
        
        .btn-edit { color: #ff9f43; border: 1px solid #ff9f43; background: none; }
        .btn-edit:hover { background: #ff9f43; color: white; }

        .btn-delete { color: #ff6b6b; border: 1px solid #ff6b6b; background: none; }
        .btn-delete:hover { background: #ff6b6b; color: white; }

        .action-btns { display: flex; gap: 8px; }
    </style>
</head>
<body>

<div class="admin-container">
    <h2 class="text-center main-title"><i class="fas fa-ice-cream"></i> Cửa Hàng Quần áo</h2>

    <div class="card card-form mb-5 <?= $edit_product ? 'editing' : '' ?>">
        <div class="card-header">
            <i class="fas <?= $edit_product ? 'fa-edit' : 'fa-plus-circle' ?>"></i>
            <?= $edit_product ? 'CHỈNH SỬA SẢN PHẨM' : 'THÊM MÓN SẢN PHẨM' ?>
        </div>
        <div class="card-body p-4">
            <form action="../controller/quanlysp.php?action=<?= $edit_product ? 'edit' : 'add' ?>" method="POST" enctype="multipart/form-data">
                
                <?php if ($edit_product): ?>
                    <input type="hidden" name="id" value="<?= $edit_product['id'] ?>">
                <?php endif; ?>

                <div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" value="<?= $edit_product ? htmlspecialchars($edit_product['name']) : '' ?>" placeholder="Ví dụ: Áo Sơ Mi Versace" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Giá bán (đ)</label>
        <input type="number" name="price" class="form-control" value="<?= $edit_product ? $edit_product['price'] : '' ?>" placeholder="0" required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Loại SP (Tự điền)</label>
        <input type="text" name="category" class="form-control" value="<?= $edit_product ? htmlspecialchars($edit_product['category']) : '' ?>" placeholder="ao, quan, tui..." required>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Giới tính</label>
        <select name="gender" class="form-select" required>
            <option value="nam" <?= ($edit_product && $edit_product['gender'] == 'nam') ? 'selected' : '' ?>>Nam</option>
            <option value="nu" <?= ($edit_product && $edit_product['gender'] == 'nu') ? 'selected' : '' ?>>Nữ</option>
            <option value="unisex" <?= ($edit_product && $edit_product['gender'] == 'unisex') ? 'selected' : '' ?>>Unisex</option>
        </select>
    </div>
    
    <div class="col-md-12 mb-3">
        <label class="form-label">Mô tả sản phẩm</label>
        <textarea name="description" class="form-control" rows="2" placeholder="Nhập mô tả chi tiết sản phẩm..."><?= $edit_product ? htmlspecialchars($edit_product['description']) : '' ?></textarea>
    </div>

    <div class="col-md-12 mb-4">
        <label class="form-label">Hình ảnh minh họa</label>
        <?php if ($edit_product): ?>
            <div class="mb-2">
                <small class="text-muted">Ảnh hiện tại:</small><br>
                <img src="../../image/<?= $edit_product['image'] ?>" width="60" class="rounded shadow-sm">
            </div>
        <?php endif; ?>
        <input type="file" name="image" class="form-control" <?= $edit_product ? '' : 'required' ?>>
    </div>
</div>

                <div class="d-flex justify-content-end gap-2">
                    <?php if ($edit_product): ?>
                        <a href="quanlysp.php" class="btn btn-secondary px-4 shadow-sm" style="border-radius: 10px;">HỦY BỎ</a>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-pink px-5 shadow-sm">
                        <?= $edit_product ? 'CẬP NHẬT NGAY' : 'THÊM VÀO' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container shadow-sm bg-white">
        <table class="table mb-0">
           <thead>
    <tr>
        <th width="80">Mã</th>
        <th width="120">Hình ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Giá tiền</th>
        <th>Phân loại</th>
        <th>Giới tính</th> <th width="150">Thao tác</th>
    </tr>
</thead>
            <tbody>
    <?php
    $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
    while($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><b class="text-muted">#<?= $row['id'] ?></b></td>
        <td><img src="../../image/<?= $row['image'] ?>" class="img-thumb"></td>
        <td>
            <div class="fw-bold"><?= htmlspecialchars($row['name']) ?></div>
            <small class="text-muted text-truncate d-inline-block" style="max-width: 200px;"><?= htmlspecialchars($row['description']) ?></small>
        </td>
        <td><span class="text-danger fw-bold"><?= number_format($row['price']) ?>đ</span></td>
        <td><span class="badge-cat text-uppercase"><?= htmlspecialchars($row['category']) ?></span></td>
        
        <td>
            <span class="badge bg-light text-dark border text-capitalize">
                <?= htmlspecialchars($row['gender']) ?>
            </span>
        </td>

        <td>
            <div class="action-btns">
                <a href="quanlysp.php?edit_id=<?= $row['id'] ?>" class="btn btn-sm btn-edit" title="Sửa">
                    <i class="fas fa-pen-alt"></i>
                </a>
                <a href="../controller/quanlysp.php?action=delete&id=<?= $row['id'] ?>" 
                   class="btn btn-sm btn-delete" 
                   onclick="return confirm('Xóa món này khỏi menu?')" title="Xóa">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>
        </table>
    </div>

    <div class="text-center mt-5">
        <a href="../index.php" class="text-decoration-none text-muted fw-bold">
            <i class="fas fa-arrow-left"></i> QUAY LẠI BẢNG ĐIỀU KHIỂN
        </a>
    </div>
</div>

</body>
</html>