<?php
require_once '../admin/vendors/PHPMailer/PHPMailer.php';
require_once '../admin/vendors/PHPMailer/SMTP.php';
require_once '../admin/vendors/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

function sendEmail($to, $subject, $body, $ccReceptionist = false)
{
    $mail = new PHPMailer();
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('no-reply@dentacare.vn', 'DentaCare - Nha Khoa');
    $mail->addAddress($to);
    if ($ccReceptionist) $mail->addCC('nguyenkieuphong05@gmail.com');

    $mail->isHTML(true);        // <-- ĐÃ CÓ METHOD NÀY
    $mail->Subject = $subject;
    $mail->Body    = $body;

    return $mail->send();       // true = thành công
}
?>