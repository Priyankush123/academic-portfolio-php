<?php
session_start();

/* 1 hour = 3600 seconds */
define('SESSION_TIMEOUT', 3600);

function check_session_timeout() {
  if (isset($_SESSION['login_time'])) {
    $elapsed = time() - $_SESSION['login_time'];

    if ($elapsed > SESSION_TIMEOUT) {
      session_unset();
      session_destroy();
      header("Location: login.php?timeout=1");
      exit;
    }
  }
}

check_session_timeout();
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}  

function require_login() {
 if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
  }
}

function require_verified_user() {
  if (empty($_SESSION['is_verified'])) {
    header("Location: login.php");
    exit;
  }
}



?>


