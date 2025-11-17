<?php
session_start();
require_once '../config/db.php';
require_role('admin'); // chỉ admin mới vào được

if ($_POST) {
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, full_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $fullname, $email, $password, $role]);
        $success = "Tạo tài khoản thành công!";
    } catch (Exception $e) {
        $error = "Lỗi: Tài khoản đã tồn tại hoặc lỗi hệ thống!";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Tạo tài khoản - DentaCare</title>
<link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3>Tạo tài khoản nhân viên</h3></div>
                <div class="card-body">
                    <?php if (isset($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
                    <?php if (isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
                    <form method="POST">
                        <input type="text" name="username" class="form-control mb-2" placeholder="Tên đăng nhập" required>
                        <input type="text" name="fullname" class="form-control mb-2" placeholder="Họ tên" required>
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-2" placeholder="Mật khẩu" required>
                        <select name="role" class="form-control mb-3">
                            <option value="receptionist">Lễ tân</option>
                            <option value="doctor">Bác sĩ</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
                        <a href="admin_dashboard.php" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>