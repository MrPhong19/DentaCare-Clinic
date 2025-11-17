<?php
session_start();
require_once '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($username) || empty($fullname) || empty($email) || empty($password) || empty($role)) {
        $error = 'Vui lòng điền đầy đủ thông tin!';
    } elseif ($password !== $confirm_password) {
        $error = 'Mật khẩu xác nhận không khớp!';
    } elseif (strlen($password) < 6) {
        $error = 'Mật khẩu phải có ít nhất 6 ký tự!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ!';
    } elseif ($role !== 'receptionist' && $role !== 'doctor') {
        $error = 'Vai trò không hợp lệ!';
    } else {
        try {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = 'Tên đăng nhập đã tồn tại!';
            } else {
                // Check if email already exists
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = 'Email đã được sử dụng!';
                } else {
                    // Insert new user
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (username, full_name, email, password, role, status) VALUES (?, ?, ?, ?, ?, 'active')");
                    $stmt->execute([$username, $fullname, $email, $hashed_password, $role]);
                    $success = 'Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.';
                    // Clear form
                    $_POST = [];
                }
            }
        } catch (PDOException $e) {
            $error = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Đăng ký | DentaCare</title>
  <link rel="icon" href="assets/favicon/favicon-32x32.png">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0">
          <div class="card-body p-5">
            <div class="text-center mb-5">
              <h1 class="fw-bold text-primary">DentaCare</h1>
              <p class="text-muted">Đăng ký tài khoản nhân viên</p>
            </div>

            <?php if ($error): ?>
              <div class="alert alert-danger alert-dismissible fade show">
                <strong>Lỗi:</strong> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <?php if ($success): ?>
              <div class="alert alert-success alert-dismissible fade show">
                <strong>Thành công:</strong> <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <form method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <label class="form-label fw-semibold">Tên đăng nhập <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                       placeholder="Tên đăng nhập" required autofocus>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" name="fullname" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>"
                       placeholder="Họ và tên đầy đủ" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control form-control-lg" 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="email@example.com" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Mật khẩu <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control form-control-lg" 
                       placeholder="Tối thiểu 6 ký tự" required minlength="6">
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                <input type="password" name="confirm_password" class="form-control form-control-lg" 
                       placeholder="Nhập lại mật khẩu" required>
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">Vai trò <span class="text-danger">*</span></label>
                <select name="role" class="form-select form-select-lg" required>
                  <option value="">-- Chọn vai trò --</option>
                  <option value="receptionist" <?= ($_POST['role'] ?? '') === 'receptionist' ? 'selected' : '' ?>>Lễ tân</option>
                  <option value="doctor" <?= ($_POST['role'] ?? '') === 'doctor' ? 'selected' : '' ?>>Bác sĩ</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                ĐĂNG KÝ
              </button>
            </form>

            <div class="text-center mt-4">
              <p class="text-muted">
                Đã có tài khoản? 
                <a href="login.php" class="text-primary fw-bold">Đăng nhập ngay</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
</body>
</html>


