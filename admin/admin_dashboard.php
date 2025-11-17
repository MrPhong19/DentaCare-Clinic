<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <base href="./">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Admin Dashboard | DentaCare</title>
  <link rel="icon" href="../assets/favicon/favicon-32x32.png">
  <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'includes/sidebar.php'; ?>

  <div class="wrapper d-flex flex-column min-vh-100">
    <?php include 'includes/header.php'; ?>

    <div class="body flex-grow-1 px-4">
      <div class="container-lg">
        <h2 class="mb-4">Chào mừng, <?= htmlspecialchars($_SESSION['full_name']) ?>!</h2>
        <div class="row">
          <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-primary mb-3">
              <div class="card-body">
                <div class="text-value">12</div>
                <div>Lịch hẹn hôm nay</div>
              </div>
            </div>
          </div>
          <!-- Thêm card khác nếu cần -->
        </div>
      </div>
    </div>

    <?php include 'includes/footer.php'; ?>
  </div>

  <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
</body>
</html>