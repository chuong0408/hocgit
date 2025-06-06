<?php

// namespace MailService;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

require 'vendor/autoload.php';
require './config.php';
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';
class MailService
{
    public static function send($to, $from, $subject, $content) {
    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = USERNAME_EMAIL;
        $mail->Password = PASSWORD_EMAIL;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Thiết lập thông tin người gửi & người nhận
        $mail->setFrom($from, 'tomnysontech shop');
        $mail->addAddress($to);

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $content;

        if ($mail->send()) {
            return true;
        } else {
            throw new Exception("Gửi email thất bại: " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        error_log("Mailer Error: " . $e->getMessage()); // Ghi log lỗi vào file
        return false;
    }
}

}
