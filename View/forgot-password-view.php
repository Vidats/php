<?php include 'header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0" style="background-color: var(--bg-light);">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 text-uppercase fw-light" style="letter-spacing: 2px; color: var(--primary-color);">Khôi phục mật khẩu</h3>
                    <p class="text-muted text-center small mb-4">Nhập email đã đăng ký, chúng tôi sẽ gửi mã OTP xác thực cho bạn.</p>
                    
                    <form action="../Controller/forgot-password.php" method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase small" style="letter-spacing: 1px;">Email của bạn</label>
                            <input type="email" name="email" class="form-control rounded-0 border-top-0 border-start-0 border-end-0 bg-transparent shadow-none ps-0" 
                                   style="border-bottom: 1px solid #ccc;"
                                   placeholder="Nhập email..." required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" name="send_otp" class="btn btn-dark rounded-0 py-3 text-uppercase" 
                                    style="letter-spacing: 2px;">
                                Gửi mã OTP
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="form.php" class="text-decoration-none small text-uppercase" style="letter-spacing: 1px; color: var(--text-light);">Quay lại Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>