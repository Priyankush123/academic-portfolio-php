<?php
require "../includes/db.php";

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$otp   = trim($_POST['otp'] ?? '');

$stmt = $pdo->prepare(
  "SELECT * FROM email_otps
   WHERE email=? AND otp=? AND expires_at > NOW()"
);
$stmt->execute([$email, $otp]);

if (!$stmt->fetch()) {
  echo json_encode(["status" => "invalid"]);
  exit;
}

/* Create user */
$stmt = $pdo->prepare(
  "INSERT INTO users (name, email, is_verified)
   VALUES (?, ?, 1)"
);
$stmt->execute([$name, $email]);

/* Cleanup OTP */
$pdo->prepare("DELETE FROM email_otps WHERE email=?")->execute([$email]);

echo json_encode(["status" => "verified"]);
