<?php
session_start();
require "../includes/db.php";

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

$stmt = $pdo->prepare(
  "SELECT * FROM users WHERE email=? AND name=? AND is_verified=1"
);
$stmt->execute([$email, $name]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  echo json_encode(["status" => "failed"]);
  exit;
}

/* Login success */
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['is_admin'] = (int)$user['is_admin'];
$_SESSION['login_time'] = time();

echo json_encode(["status" => "logged_in"]);
