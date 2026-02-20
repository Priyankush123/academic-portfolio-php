<?php
require "../includes/db.php";
require "../includes/mailer/send_mail.php";

$email = trim($_POST['email'] ?? '');

if (!$email) {
  echo json_encode(["status" => "error"]);
  exit;
}

/* Check if already registered */
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
  echo json_encode(["status" => "already_registered"]);
  exit;
}

/* Generate OTP */
$otp = random_int(100000, 999999);

/* Remove old OTPs */
$pdo->prepare("DELETE FROM email_otps WHERE email = ?")->execute([$email]);

/* Save OTP */
$stmt = $pdo->prepare(
  "INSERT INTO email_otps (email, otp, expires_at)
   VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 10 MINUTE))"
);
$stmt->execute([$email, $otp]);

/* Email content */
$subject = "Email Verification Code – Dr. Amba Pande";

$message =
"Dear Researcher,\n\n"
."Thank you for visiting the academic portfolio of Dr. Amba Pande,\n"
."Professor, School of International Studies, Jawaharlal Nehru University.\n\n"
."To proceed with your registration, please verify your email address "
."using the One-Time Password (OTP) provided below:\n\n"
."--------------------------------------------------\n"
."Your Email Verification Code:  $otp\n"
."--------------------------------------------------\n\n"
."This OTP is valid for 10 minutes. Please do not share this code.\n\n"
."Warm regards,\n"
."Academic Portfolio Team\n"
."Dr. Amba Pande\n"
."Jawaharlal Nehru University, New Delhi";

/* Send OTP via SMTP */
$mailSent = sendMail($email, $subject, $message);

if ($mailSent) {
  echo json_encode(["status" => "otp_sent"]);
} else {
  echo json_encode(["status" => "mail_failed"]);
}
