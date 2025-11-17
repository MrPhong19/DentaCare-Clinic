<?php
session_start();
require_once '../config/db.php';
require_once '../functions/auth_functions.php';
require_role('doctor');

$doctor_id = $_SESSION['user_id'];

// Lấy lịch chờ bác sĩ (status = 'waiting_for_approval')
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE status = 'waiting_for_approval' AND assigned_doctor_id = ? ORDER BY appointment_date");
$stmt->execute([$doctor_id]);
$pending_appts = $stmt->fetchAll();

// Lấy lịch đã xử lý (confirmed)
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE assigned_doctor_id = ? AND status = 'confirmed' ORDER BY appointment_date DESC");
$stmt->execute([$doctor_id]);
$my_appointments = $stmt->fetchAll();

// Check for duplicate appointments on same day for each pending appointment
$duplicate_warnings = [];
foreach ($pending_appts as $apt) {
    $appointment_date = date('Y-m-d', strtotime($apt['appointment_date']));
    $stmt = $pdo->prepare("SELECT id FROM appointments 
        WHERE assigned_doctor_id = ? 
        AND DATE(appointment_date) = ? 
        AND status = 'confirmed' 
        AND id != ?");
    $stmt->execute([$doctor_id, $appointment_date, $apt['id']]);
    if ($stmt->fetch()) {
        $duplicate_warnings[$apt['id']] = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bác sĩ | DentaCare</title>
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="sidebar-fixed">
  <?php include 'includes/sidebar.php'; ?>

  <div class="wrapper d-flex flex-column min-vh-100">
    <?php include 'includes/header.php'; ?>

    <div class="body flex-grow-1 px-4">
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
      
      <?php if (isset($_SESSION['duplicate_warning_id'])): ?>
        <div class="alert alert-warning alert-dismissible fade show">
          <strong>⚠ Cảnh báo trùng lịch!</strong> Bạn đã có lịch hẹn khác trong ngày <?= date('d/m/Y', strtotime($_SESSION['duplicate_warning_date'])) ?>. 
          Bạn có chắc chắn muốn nhận lịch này?
          <form method="POST" action="../handle/doctor_process.php" style="display:inline-block; margin-left:10px;">
            <input type="hidden" name="action" value="accept">
            <input type="hidden" name="appt_id" value="<?= $_SESSION['duplicate_warning_id'] ?>">
            <input type="hidden" name="confirm_duplicate" value="1">
            <button type="submit" class="btn btn-warning btn-sm">Có, nhận lịch</button>
          </form>
          <a href="doctor_dashboard.php" class="btn btn-secondary btn-sm">Hủy</a>
        </div>
        <?php 
        unset($_SESSION['duplicate_warning_id']);
        unset($_SESSION['duplicate_warning_date']);
        ?>
      <?php endif; ?>
      
      <div class="row">
        <div class="col-12">
          <h2 class="mb-4">Xin chào, <strong><?= htmlspecialchars($_SESSION['full_name']) ?></strong></h2>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-primary text-white">Lịch mới cần nhận (<?= count($pending_appts) ?>)</div>
            <div class="card-body">
              <?php if (empty($pending_appts)): ?>
                <p class="text-muted">Không có lịch hẹn mới.</p>
              <?php else: ?>
                <?php foreach ($pending_appts as $a): ?>
                <div class="border-bottom pb-3 mb-3">
                  <?php if (isset($duplicate_warnings[$a['id']])): ?>
                    <div class="alert alert-warning alert-sm mb-2">
                      <strong>⚠ Cảnh báo:</strong> Bạn đã có lịch hẹn khác trong ngày này!
                    </div>
                  <?php endif; ?>
                  <strong><?= htmlspecialchars($a['patient_name']) ?></strong> - <?= htmlspecialchars($a['patient_phone']) ?><br>
                  <small><?= htmlspecialchars($a['note'] ?? 'N/A') ?></small><br>
                  Thời gian: <strong><?= date('d/m/Y H:i', strtotime($a['appointment_date'])) ?></strong>
                  <div class="mt-2">
                    <?php if (isset($duplicate_warnings[$a['id']])): ?>
                      <form method="POST" action="../handle/doctor_process.php" style="display:inline;" onsubmit="return confirm('⚠ Cảnh báo: Bạn đã có lịch hẹn khác trong ngày này. Bạn có chắc chắn muốn nhận lịch này?');">
                        <input type="hidden" name="action" value="accept">
                        <input type="hidden" name="appt_id" value="<?= $a['id'] ?>">
                        <button type="submit" class="btn btn-warning btn-sm">Nhận lịch (Trùng ngày)</button>
                      </form>
                    <?php else: ?>
                      <form method="POST" action="../handle/doctor_process.php" style="display:inline;">
                        <input type="hidden" name="action" value="accept">
                        <input type="hidden" name="appt_id" value="<?= $a['id'] ?>">
                        <button type="submit" class="btn btn-success btn-sm">Nhận lịch</button>
                      </form>
                    <?php endif; ?>
                    <form method="POST" action="../handle/doctor_process.php" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn từ chối lịch hẹn này? Lịch hẹn sẽ được chuyển lại cho lễ tân.');">
                      <input type="hidden" name="action" value="reject">
                      <input type="hidden" name="appt_id" value="<?= $a['id'] ?>">
                      <button type="submit" class="btn btn-danger btn-sm">Từ chối</button>
                    </form>
                  </div>
                </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-header bg-info text-white">Lịch đã xử lý</div>
            <div class="card-body">
              <?php foreach ($my_appointments as $a): ?>
              <div class="border-bottom pb-2 mb-2">
                <strong><?= $a['patient_name'] ?></strong> - 
                <span class="<?= $a['status']=='confirmed'?'text-success':'text-danger' ?>">
                  <?= $a['status']=='confirmed'?'Đã nhận':'Đã từ chối' ?>
                </span><br>
                <small><?= date('d/m/Y H:i', strtotime($a['appointment_date'])) ?></small>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
</body>
</html>