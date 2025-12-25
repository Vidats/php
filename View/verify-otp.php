<?php include 'header.php'; ?>

<div class="container py-5">
    <div class="card mx-auto border-0" style="max-width: 400px; background-color: var(--bg-light);">
        <div class="card-body p-5 text-center">
            <h3 class="mb-4 text-uppercase fw-light" style="color: var(--primary-color); letter-spacing: 2px;">Xác thực mã OTP</h3>
            
            <form action="../Controller/forgot-password.php" method="POST">
                <input type="email" name="email" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 bg-transparent shadow-none mb-4 ps-0" 
                       style="border-bottom: 1px solid #ccc;"
                       value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" 
                       placeholder="Nhập lại Email" required>
                
                <input type="text" name="otp" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 bg-transparent shadow-none mb-4 text-center fw-bold ps-0" 
                       style="border-bottom: 1px solid #ccc; letter-spacing: 5px; font-size: 1.2rem;"
                       placeholder="MÃ OTP" required maxlength="6">
                
                <input type="password" name="new_password" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 bg-transparent shadow-none mb-5 ps-0" 
                       style="border-bottom: 1px solid #ccc;"
                       placeholder="Mật khẩu mới" required>
                
                <button type="submit" name="verify" class="btn btn-dark w-100 rounded-0 py-3 text-uppercase" 
                        style="letter-spacing: 2px;">
                    Đổi mật khẩu
                </button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>