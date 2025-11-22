<?php
require_once __DIR__ . '/../admin/vendors/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../admin/vendors/PHPMailer/SMTP.php';
require_once __DIR__ . '/../admin/vendors/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Cấu hình SMTP cho Brevo (Sendinblue)
 * TODO: Sau khi tạo SMTP key trên Brevo, sửa lại các hằng số bên dưới cho đúng tài khoản của bạn.
 */
const BREVO_SMTP_HOST       = 'smtp-relay.brevo.com';
const BREVO_SMTP_PORT       = 587;          // 587 với TLS
const BREVO_SMTP_SECURE     = 'tls';        // hoặc PHPMailer::ENCRYPTION_STARTTLS nếu dùng bản chuẩn
const BREVO_SMTP_USERNAME   = 'YOUR_BREVO_SMTP_USERNAME@smtp-brevo.com';  // Thay bằng SMTP username của bạn từ Brevo
const BREVO_SMTP_PASSWORD   = 'YOUR_BREVO_SMTP_KEY';      // Thay bằng SMTP key của bạn từ Brevo (SMTP & API)
const BREVO_FROM_EMAIL      = 'YOUR_BREVO_SMTP_USERNAME@smtp-brevo.com';  // Thường trùng với BREVO_SMTP_USERNAME
const BREVO_FROM_NAME       = 'DentaCare - Nha Khoa';
const BREVO_CC_EMAIL        = '';            // Nếu không cần CC có thể để chuỗi rỗng ''

function sendEmail($to, $subject, $body, $ccReceptionist = false)
{
    // Tăng thời gian thực thi tối đa cho hàm gửi email (30 giây)
    $original_timeout = ini_get('max_execution_time');
    @set_time_limit(30);
    
    try {
        $mail = new PHPMailer();
        // Class PHPMailer đã được custom để luôn gửi qua SMTP nên không cần gọi isSMTP()
        $mail->CharSet = 'UTF-8';
        
        // Cấu hình SMTP (Brevo)
        $mail->Host       = BREVO_SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = BREVO_SMTP_USERNAME;
        $mail->Password   = BREVO_SMTP_PASSWORD;
        $mail->SMTPSecure = BREVO_SMTP_SECURE;
        $mail->Port       = BREVO_SMTP_PORT;
        $mail->Timeout    = 10; // Timeout 10 giây cho SMTP
        
        // Người gửi và người nhận
        $fromEmail = BREVO_FROM_EMAIL ?: BREVO_SMTP_USERNAME;
        $fromName  = BREVO_FROM_NAME;
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);
        if ($ccReceptionist && !empty(BREVO_CC_EMAIL)) {
            $mail->addCC(BREVO_CC_EMAIL);
        }

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $result = $mail->send();
        
        // Khôi phục timeout ban đầu
        if ($original_timeout !== false) {
            @set_time_limit($original_timeout);
        }
        
        // Ghi log kết quả để debug
        if ($result) {
            error_log("[EMAIL] (Brevo) Gửi đến $to thành công.");
        } else {
            error_log("[EMAIL] (Brevo) Gửi đến $to thất bại: " . ($mail->ErrorInfo ?? 'Unknown error'));
        }
        
        return $result;
    } catch (Exception $e) {
        if ($original_timeout !== false) {
            @set_time_limit($original_timeout);
        }
        error_log("[EMAIL] (Brevo) Exception (PHPMailer): " . $e->getMessage());
        return false;
    } catch (\Exception $e) {
        if ($original_timeout !== false) {
            @set_time_limit($original_timeout);
        }
        error_log("[EMAIL] (Brevo) Exception (Generic): " . $e->getMessage());
        return false;
    }
}
?>