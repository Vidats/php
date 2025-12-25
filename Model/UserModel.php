<?php
require_once 'db.php';

// Lưu mã OTP và thời gian hết hạn
function saveOTP($conn, $email, $otp, $expiry) {
    $email = mysqli_real_escape_string($conn, $email);
    $sql = "UPDATE users SET otp_code = '$otp', otp_expiry = '$expiry' WHERE email = '$email'";
    return $conn->query($sql);
}

// Kiểm tra mã OTP
function checkOTP($conn, $email, $otp) {
    $email = mysqli_real_escape_string($conn, $email);
    $otp = mysqli_real_escape_string($conn, $otp);
    $sql = "SELECT * FROM users WHERE email='$email' AND otp_code='$otp'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Cập nhật mật khẩu mới
function updatePassword($conn, $email, $new_pass) {
    $email = mysqli_real_escape_string($conn, $email);
    $sql = "UPDATE users SET password='$new_pass', otp_code=NULL, otp_expiry=NULL WHERE email='$email'";
    return $conn->query($sql);
}

// Kiểm tra email tồn tại
function checkEmailExists($conn, $email) {
    $email = mysqli_real_escape_string($conn, $email);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = $conn->query($sql);
    return ($res->num_rows > 0);
}
?>