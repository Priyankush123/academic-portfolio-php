<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer.php';
require __DIR__ . '/SMTP.php';
require __DIR__ . '/Exception.php';

function sendMail($to, $subject, $body) {
  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'drambapandeportfolio@ambapande.in'; // SAME as mailbox
    $mail->Password   = 'et7UzQ?r:1B|';               // email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom(
      'drambapandeportfolio@ambapande.in',
      'Dr. Amba Pande – Academic Portfolio'
    );

    $mail->addAddress($to);

    $mail->isHTML(false); // plain text (better for OTP)
    $mail->Subject = $subject;
    $mail->Body    = $body;

    return $mail->send();
  } catch (Exception $e) {
    return false;
  }
}
