<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
    :root {
        --primary-color: #1a1a1a;   /* Black */
        --secondary-color: #C5A085; /* Beige/Gold */
        --text-color: #333;
        --light-bg: #f8f9fa;        /* Light Gray */
        --border-color: #e5e5e5;
    }

    body { 
        font-family: 'Poppins', sans-serif; 
        background-color: var(--light-bg); 
        color: var(--text-color);
    }

    .auth-wrapper { 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        min-height: 80vh; 
        padding: 40px 20px; 
    }

    .auth-container { 
        background: #fff; 
        padding: 40px; 
        width: 100%; 
        max-width: 600px; 
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* Tab Switcher */
    .auth-switcher { 
        display: flex; 
        margin-bottom: 40px; 
        border-bottom: 1px solid var(--border-color);
    }

    .switcher-btn { 
        flex: 1; 
        padding: 15px 0; 
        border: none; 
        background: none; 
        cursor: pointer; 
        font-size: 1rem; 
        font-weight: 500; 
        color: #999; 
        text-align: center; 
        text-decoration: none; 
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .switcher-btn.active { 
        color: var(--primary-color);
        border-bottom: 2px solid var(--primary-color);
    }

    .form-section { display: none; }
    .form-section.active { display: block; animation: fadeIn 0.5s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* Inputs */
    label { 
        font-weight: 500; 
        color: var(--primary-color); 
        margin-bottom: 8px; 
        font-size: 0.85rem; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    input[type="email"], input[type="password"], input[type="text"], input[type="date"], select { 
        width: 100%; 
        padding: 12px; 
        border: 1px solid var(--border-color); 
        border-radius: 0; /* Square borders */
        margin-bottom: 15px; 
        transition: 0.3s;
        font-size: 0.95rem;
    }

    input:focus, select:focus { 
        outline: none; 
        border-color: var(--primary-color); 
        background-color: #fff; 
    }

    /* Buttons */
    .submit-btn { 
        width: 100%; 
        padding: 15px; 
        border: 1px solid var(--primary-color); 
        background-color: var(--primary-color);
        color: #fff; 
        font-size: 0.9rem; 
        font-weight: 600; 
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer; 
        transition: 0.3s; 
        margin-top: 20px;
        border-radius: 0;
    }

    .submit-btn:hover { 
        background-color: #fff; 
        color: var(--primary-color); 
    }

    .row { display: flex; gap: 20px; }
    .col-md-6 { flex: 1; }
    .error-message { color: #dc3545; font-size: 0.8rem; display: block; margin-top: -10px; margin-bottom: 10px; }
    
    /* Checkbox & Link */
    .form-check-label { font-size: 0.9rem; color: #666; }
    .forgot-password-link { color: var(--secondary-color); text-decoration: none; font-size: 0.9rem; }
    .forgot-password-link:hover { text-decoration: underline; }
    
    a { color: var(--primary-color); text-decoration: none; }
</style>
</head>
<body>

<?php 
$activeTab = $_GET['tab'] ?? 'login';
$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';
?>

    <div class="auth-wrapper">
        <?php if ($status && $message): ?>
            <div style="position: fixed; top: 100px; z-index: 1000; width: 100%; text-align: center;">
                <p style="background: #fff; padding: 15px 30px; display: inline-block; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-left: 4px solid <?= $status == 'success' ? '#198754' : '#dc3545' ?>;">
                    <?= htmlspecialchars($message) ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="auth-container">
            <div class="auth-switcher">
                <a href="?tab=login" class="switcher-btn <?= $activeTab === 'login' ? 'active' : '' ?>">Đăng Nhập</a>
                <a href="?tab=register" class="switcher-btn <?= $activeTab === 'register' ? 'active' : '' ?>">Đăng Ký</a>
            </div>

            <div id="login-new-form" class="form-section <?= $activeTab === 'login' ? 'active' : '' ?>">
                <h2 style="margin-bottom: 30px; font-size: 1.5rem; font-weight: 400; text-align: center; text-transform: uppercase; letter-spacing: 2px;">Chào mừng trở lại</h2>
                <form id="loginForm" method="POST" action="../Controller/login.php">                    
                    <input type="hidden" name="action" value="login"> 
                    <div class="form-group">
                        <label for="login-new-email">Email</label>
                        <input type="email" id="login-new-email" name="email" placeholder="Nhập email" required />
                        <span class="error-message" id="login-email-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="login-new-password">Mật khẩu</label>
                        <input type="password" id="login-new-password" name="password" placeholder="Nhập mật khẩu" required />
                        <span class="error-message" id="login-password-error"></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                            <label class="form-check-label ms-2" for="remember-me">Ghi nhớ</label>
                        </div>
                        <a href="forgot-password-view.php" class="forgot-password-link">Quên mật khẩu?</a>
                    </div>
                    <button type="submit" class="submit-btn">Đăng Nhập</button>
                </form>
            </div>

            <div id="register-new-form" class="form-section <?= $activeTab === 'register' ? 'active' : '' ?>">
                <h2 style="margin-bottom: 10px; font-size: 1.5rem; font-weight: 400; text-align: center; text-transform: uppercase; letter-spacing: 2px;">Tạo tài khoản</h2>
                <p style="font-size: 0.9rem; margin-bottom: 30px; color: #777; text-align: center;">Trở thành thành viên của Luxury Store.</p>

                <form id="registerForm" method="POST" action="../Controller/registration.php">                    
                    <input type="hidden" name="action" value="register"> 
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" name="email" required />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Xác nhận Email</label>
                            <input type="email" name="confirm_email" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Danh xưng</label>
                            <select class="form-control" name="title" required>
                                <option value="" disabled selected>Chọn...</option>
                                <option value="mr">Ông (Mr.)</option>
                                <option value="mrs">Bà (Mrs.)</option>
                                <option value="ms">Cô (Ms.)</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Họ và Tên</label>
                            <input type="text" name="full_name" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" required />
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ngày sinh</label>
                            <input type="date" name="dob" />
                        </div>
                    </div>

                    <div class="form-check text-start mb-4 mt-2">
                        <input class="form-check-input" type="checkbox" id="privacy-policy" name="privacy_policy" required>
                        <label class="form-check-label ms-2" for="privacy-policy">
                            Tôi đồng ý với <a href="#">Chính sách bảo mật</a>
                        </label>
                    </div>

                    <button type="submit" class="submit-btn">Đăng Ký</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>

<?php include 'footer.php'; ?>