<?php
session_start();
require_once '../config/db.php';
require_once '../functions/auth_functions.php';
require_role('admin');

// Handle delete action
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    
    // Prevent deleting admin users
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    if ($user && $user['role'] !== 'admin') {
        // Delete user (cascade will handle related appointments)
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$user_id]);
        $_SESSION['success'] = 'Đã xóa người dùng thành công!';
    } else {
        $_SESSION['error'] = 'Không thể xóa tài khoản admin!';
    }
    header('Location: manage_users.php');
    exit;
}

// Get all receptionists and doctors
$receptionists = $pdo->query("SELECT * FROM users WHERE role = 'receptionist' AND status = 'active' ORDER BY created_at DESC")->fetchAll();
$doctors = $pdo->query("SELECT * FROM users WHERE role = 'doctor' AND status = 'active' ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <base href="./">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Quản lý người dùng | DentaCare</title>
  <link rel="icon" href="assets/favicon/favicon-32x32.png">
  <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php 
  // Set active page for sidebar
  $active_page = 'manage_users';
  include 'includes/sidebar.php'; 
  ?>

  <div class="wrapper d-flex flex-column min-vh-100">
    <?php include 'includes/header.php'; ?>

    <div class="body flex-grow-1 px-4">
      <div class="container-lg">
        <h2 class="mb-4">Quản lý người dùng</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row">
          <!-- Receptionists -->
          <div class="col-lg-6 mb-4">
            <div class="card">
              <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Lễ tân (<?= count($receptionists) ?>)</h5>
              </div>
              <div class="card-body">
                <?php if (empty($receptionists)): ?>
                  <p class="text-muted">Chưa có lễ tân nào.</p>
                <?php else: ?>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Tên đăng nhập</th>
                          <th>Họ tên</th>
                          <th>Email</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($receptionists as $user): ?>
                        <tr>
                          <td><?= htmlspecialchars($user['username']) ?></td>
                          <td><?= htmlspecialchars($user['full_name']) ?></td>
                          <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
                          <td>
                            <a href="manage_users.php?delete=1&id=<?= $user['id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa <?= htmlspecialchars(addslashes($user['full_name'])) ?>? Hành động này sẽ xóa tất cả thông tin liên quan và không thể hoàn tác!');">
                              Xóa
                            </a>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Doctors -->
          <div class="col-lg-6 mb-4">
            <div class="card">
              <div class="card-header bg-info text-white">
                <h5 class="mb-0">Bác sĩ (<?= count($doctors) ?>)</h5>
              </div>
              <div class="card-body">
                <?php if (empty($doctors)): ?>
                  <p class="text-muted">Chưa có bác sĩ nào.</p>
                <?php else: ?>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Tên đăng nhập</th>
                          <th>Họ tên</th>
                          <th>Email</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($doctors as $user): ?>
                        <tr>
                          <td><?= htmlspecialchars($user['username']) ?></td>
                          <td><?= htmlspecialchars($user['full_name']) ?></td>
                          <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
                          <td>
                            <a href="manage_users.php?delete=1&id=<?= $user['id'] ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa <?= htmlspecialchars(addslashes($user['full_name'])) ?>? Hành động này sẽ xóa tất cả thông tin liên quan và không thể hoàn tác!');">
                              Xóa
                            </a>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include 'includes/footer.php'; ?>
  </div>

  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
</body>
</html>

