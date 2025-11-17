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
                    <button class="btn btn-success btn-sm" onclick="acceptAppointment(<?= $a['id'] ?>, <?= isset($duplicate_warnings[$a['id']]) ? 'true' : 'false' ?>)">Nhận lịch</button>
                    <button class="btn btn-danger btn-sm" onclick="rejectAppointment(<?= $a['id'] ?>)">Từ chối</button>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function acceptAppointment(id, hasDuplicate) {
      if (hasDuplicate) {
        Swal.fire({
          title: 'Cảnh báo trùng lịch!',
          text: 'Bạn đã có lịch hẹn khác trong ngày này. Bạn có chắc chắn muốn nhận lịch này?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Có, nhận lịch',
          cancelButtonText: 'Hủy'
        }).then((result) => {
          if (result.isConfirmed) {
            submitAccept(id);
          }
        });
      } else {
        submitAccept(id);
      }
    }

    function submitAccept(id) {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '../handle/doctor_process.php';
      
      const input1 = document.createElement('input');
      input1.type = 'hidden';
      input1.name = 'action';
      input1.value = 'accept';
      form.appendChild(input1);
      
      const input2 = document.createElement('input');
      input2.type = 'hidden';
      input2.name = 'appt_id';
      input2.value = id;
      form.appendChild(input2);
      
      document.body.appendChild(form);
      form.submit();
    }

    function rejectAppointment(id) {
      Swal.fire({
        title: 'Từ chối lịch hẹn?',
        text: 'Lịch hẹn sẽ được chuyển lại cho lễ tân.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Từ chối',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '../handle/doctor_process.php';
          
          const input1 = document.createElement('input');
          input1.type = 'hidden';
          input1.name = 'action';
          input1.value = 'reject';
          form.appendChild(input1);
          
          const input2 = document.createElement('input');
          input2.type = 'hidden';
          input2.name = 'appt_id';
          input2.value = id;
          form.appendChild(input2);
          
          document.body.appendChild(form);
          form.submit();
        }
      });
    }
  </script>
</body>
</html>