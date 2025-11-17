<?php
session_start();
require_once '../functions/auth_functions.php';
require_role('receptionist');
require_once '../config/db.php';

// Lấy danh sách bác sĩ
$doctors = $pdo->query("SELECT id, full_name FROM users WHERE role = 'doctor'")->fetchAll();

$receptionist_id = $_SESSION['user_id'];

// Lấy lịch chờ duyệt: chỉ những lịch chưa được gán (pending) 
// HOẶC những lịch mà bác sĩ từ chối và do chính lễ tân này gán (rejected)
$stmt = $pdo->prepare("SELECT * FROM appointments 
    WHERE (status = 'pending' AND assigned_receptionist_id IS NULL) 
    OR (status = 'rejected' AND assigned_receptionist_id = ?)
    ORDER BY created_at DESC");
$stmt->execute([$receptionist_id]);
$pending = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lễ tân | DentaCare</title>
  <link href="css/style.css" rel="stylesheet">
  <link href="vendors/simplebar/css/simplebar.css" rel="stylesheet">
</head>
<body>
  <!-- SIDEBAR -->
  <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom p-3">
      <h5 class="mb-0 text-white">Lễ tân</h5>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
      <li class="nav-item"><a class="nav-link active" href="receptionist_dashboard.php">
        <svg class="nav-icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-calendar-check"></use></svg> Lịch chờ duyệt</a></li>
      <li class="nav-item"><a class="nav-link" href="receptionist_all.php">
        <svg class="nav-icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-list"></use></svg> Tất cả lịch hẹn</a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">
        <svg class="nav-icon"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use></svg> Đăng xuất</a></li>
    </ul>
  </div>

  <div class="wrapper d-flex flex-column min-vh-100">
    <header class="header header-sticky p-0 mb-4">
      <div class="container-fluid border-bottom px-4 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
          <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg"><use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use></svg>
          </button>
        </div>
        <div>
          <strong><?= htmlspecialchars($_SESSION['full_name']) ?></strong>
        </div>
      </div>
    </header>

    <div class="body flex-grow-1 px-4">
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
          <?= htmlspecialchars($_SESSION['success']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>
      <h3>Lịch hẹn chờ duyệt (<?= count($pending) ?>)</h3>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Bệnh nhân</th>
              <th>Dịch vụ</th>
              <th>Thời gian</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pending as $apt): ?>
            <tr>
              <td><?= htmlspecialchars($apt['patient_name']) ?><br><small><?= $apt['patient_phone'] ?></small></td>
              <td><?= htmlspecialchars($apt['note'] ?? 'N/A') ?></td>
              <td><?= date('d/m/Y H:i', strtotime($apt['appointment_date'])) ?></td>
              <td>
                <button class="btn btn-primary btn-sm" onclick="assignDoc(<?= $apt['id'] ?>)">Chuyển BS</button>
                <form method="POST" action="../handle/receptionist_process.php" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này? Bệnh nhân sẽ nhận được email thông báo hủy lịch hẹn.');">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $apt['id'] ?>">
                  <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Chuyển BS -->
  <div class="modal fade" id="assignModal">
    <div class="modal-dialog">
      <form method="POST" action="../handle/receptionist_process.php">
        <input type="hidden" name="action" value="assign">
        <input type="hidden" name="id" id="assign_id">
        <div class="modal-content">
          <div class="modal-header">
            <h5>Chuyển cho bác sĩ</h5>
          </div>
          <div class="modal-body">
            <select name="doctor_id" class="form-select" required>
              <option value="">-- Chọn bác sĩ --</option>
              <?php foreach ($doctors as $doc): ?>
                <option value="<?= $doc['id'] ?>"><?= $doc['full_name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Chuyển</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
  <script>
    function assignDoc(id) {
      document.getElementById('assign_id').value = id;
      new coreui.Modal(document.getElementById('assignModal')).show();
    }
  </script>
</body>
</html>