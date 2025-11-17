<?php
session_start();
require_once '../config/db.php';
require_once '../functions/auth_functions.php';
require_once '../functions/email_functions.php';
require_role('receptionist');

$receptionist_id = $_SESSION['user_id'];

if ($_POST['action'] === 'assign') {
    $id = (int)$_POST['id'];
    $doctor_id = (int)$_POST['doctor_id'];
    
    // Update appointment: assign to doctor, set status to 'waiting_for_approval', track which receptionist assigned it
    $stmt = $pdo->prepare("UPDATE appointments SET assigned_doctor_id = ?, assigned_receptionist_id = ?, status = 'waiting_for_approval' WHERE id = ? AND status = 'pending'");
    $stmt->execute([$doctor_id, $receptionist_id, $id]);
    
    $_SESSION['success'] = 'Đã chuyển lịch hẹn cho bác sĩ!';
} elseif ($_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    
    // Get appointment details before deleting
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->execute([$id]);
    $appointment = $stmt->fetch();
    
    if ($appointment) {
        // Send email to patient
        $subject = "Thông báo hủy lịch hẹn - DentaCare";
        $message = "<h3>Xin chào {$appointment['patient_name']}!</h3>
                   <p>Rất tiếc, lịch hẹn của bạn không thể được thực hiện.</p>
                   <p>Thông tin lịch hẹn:</p>
                   <ul>
                     <li>Thời gian: " . date('d/m/Y H:i', strtotime($appointment['appointment_date'])) . "</li>
                     <li>Dịch vụ: " . htmlspecialchars($appointment['note'] ?? 'N/A') . "</li>
                   </ul>
                   <p>Vui lòng liên hệ với chúng tôi để đặt lịch hẹn mới.</p>
                   <p>Cảm ơn bạn đã tin tưởng DentaCare!</p>";
        
        sendEmail($appointment['patient_email'], $subject, $message);
        
        // Delete appointment
        $pdo->prepare("DELETE FROM appointments WHERE id = ?")->execute([$id]);
        $_SESSION['success'] = 'Đã xóa lịch hẹn và gửi thông báo cho bệnh nhân!';
    }
}

header('Location: ../admin/receptionist_dashboard.php');
exit;