<?php
session_start();
require_once '../config/db.php';
require_once '../functions/auth_functions.php';
require_once '../functions/email_functions.php';
require_role('doctor');

$doctor_id = $_SESSION['user_id'];

if ($_POST['action'] === 'accept') {
    $id = (int)$_POST['appt_id'];
    
    // Get appointment details
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ? AND status = 'waiting_for_approval'");
    $stmt->execute([$id]);
    $appointment = $stmt->fetch();
    
    if (!$appointment) {
        $_SESSION['error'] = 'Lịch hẹn không tồn tại hoặc đã được xử lý!';
        header('Location: ../admin/doctor_dashboard.php');
        exit;
    }
    
    // Accept appointment (duplicate check is done in dashboard, but we still allow acceptance)
    $stmt = $pdo->prepare("UPDATE appointments SET status = 'confirmed', assigned_doctor_id = ? WHERE id = ?");
    $stmt->execute([$doctor_id, $id]);
    
    // Send email to patient
    $formatted_date = date('d/m/Y H:i', strtotime($appointment['appointment_date']));
    $subject = "Xác nhận đặt lịch khám - DentaCare";
    $message = "<h3>Xin chào {$appointment['patient_name']}!</h3>
               <p>Bạn đã đặt lịch hẹn thành công!</p>
               <p>Thông tin lịch hẹn:</p>
               <ul>
                 <li>Thời gian: <strong>$formatted_date</strong></li>
                 <li>Bác sĩ: <strong>{$_SESSION['full_name']}</strong></li>
                 <li>Ghi chú: " . htmlspecialchars($appointment['note'] ?? 'N/A') . "</li>
               </ul>
               <p>Vui lòng đến đúng giờ hẹn. Cảm ơn bạn đã tin tưởng DentaCare!</p>";
    
    sendEmail($appointment['patient_email'], $subject, $message);
    
    $_SESSION['success'] = 'Đã chấp nhận lịch hẹn và gửi email cho bệnh nhân!';
    
} elseif ($_POST['action'] === 'reject') {
    $id = (int)$_POST['appt_id'];
    
    // Get appointment details
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ? AND status = 'waiting_for_approval'");
    $stmt->execute([$id]);
    $appointment = $stmt->fetch();
    
    if (!$appointment) {
        $_SESSION['error'] = 'Lịch hẹn không tồn tại hoặc đã được xử lý!';
        header('Location: ../admin/doctor_dashboard.php');
        exit;
    }
    
    // Reject appointment - set status to 'rejected' so it goes back to the receptionist who assigned it
    $stmt = $pdo->prepare("UPDATE appointments SET status = 'rejected', assigned_doctor_id = NULL WHERE id = ?");
    $stmt->execute([$id]);
    
    $_SESSION['success'] = 'Đã từ chối lịch hẹn. Lịch hẹn sẽ được chuyển lại cho lễ tân.';
}

header('Location: ../admin/doctor_dashboard.php');
exit;

