<?php
session_start();
require_once '../config/db.php';
require_once '../functions/email_functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid method']);
    exit;
}

$name       = trim($_POST['name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$phone      = trim($_POST['phone'] ?? '');
$date       = $_POST['date'] ?? '';
$time       = $_POST['time'] ?? '';
$department = $_POST['department'] ?? ''; // Keep for form compatibility
$reason     = trim($_POST['reason'] ?? '');

if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time)) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ thông tin']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Email không hợp lệ']);
    exit;
}

// Trong handle/appointment_process.php
if (!preg_match('#^(\d{2})\/(\d{2})\/(\d{4})$#', $date, $m)) {
    echo json_encode(['status' => 'error', 'message' => 'Ngày không đúng định dạng']);
    exit;
}
// $m[1] = ngày, $m[2] = tháng, $m[3] = năm
$appointment_datetime = $m[3] . '-' . sprintf('%02d', $m[2]) . '-' . sprintf('%02d', $m[1]) . ' ' . $time . ':00';

if (strtotime($appointment_datetime) < time()) {
    echo json_encode(['status' => 'error', 'message' => 'Không thể đặt lịch quá khứ']);
    exit;
}
// Kiểm tra trùng
$stmt = $pdo->prepare("SELECT id FROM appointments WHERE appointment_date = ?");
$stmt->execute([$appointment_datetime]);
if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Khung giờ này đã có người đặt!']);
    exit;
}

try {
    // Combine department and reason into note field
    $note = trim($department . ($reason ? ' - ' . $reason : ''));
    
    $stmt = $pdo->prepare("INSERT INTO appointments 
        (patient_name, patient_email, patient_phone, appointment_date, note, status, created_at) 
        VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([$name, $email, $phone, $appointment_datetime, $note]);

    $formatted = date('d/m/Y lúc H:i', strtotime($appointment_datetime));
    $subject = "Xác nhận đặt lịch khám - DentaCare";
    $message = "<h3>Xin chào $name!</h3><p>Lịch hẹn của bạn đã được tiếp nhận:</p>
                <ul>" . ($department ? "<li>Dịch vụ: <strong>$department</strong></li>" : "") . "
                <li>Thời gian: <strong>$formatted</strong></li></ul>
                <p>Cảm ơn bạn đã tin tưởng DentaCare!</p>";

    sendEmail($email, $subject, $message);

    echo json_encode(['status' => 'success', 'message' => 'Đặt lịch thành công! Vui lòng kiểm tra email.']);

} catch (Exception $e) {
    error_log("Lỗi đặt lịch: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại!']);
}
?>