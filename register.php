<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register | Dr. Amba Pande</title>

  <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon.png">
<link rel="shortcut icon" href="/favicon.png">

  <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
</head>

<body class="auth-page">
<header class="header auth-header">
  <div class="header-left">
    <div class="dot"></div>
    <span class="name">Dr. Amba Pande</span>
  </div>
</header>

<section class="auth-container">
  <h2>Register</h2>
  <p class="auth-text">
    Register to access academic publications and books.
  </p>

  <form class="auth-form" id="registerForm">
    <label for="name">Name</label>
    <input type="text" id="name" placeholder="Your full name" required>

    <label for="email">Email</label>
    <input type="email" id="email" placeholder="Your institutional or personal email" required>

    <button type="button" id="sendOtpBtn" class="primary-btn">
      Verify Email
    </button>

    <div id="otpSection" class="otp-section" style="display:none;">
      <label for="otp">Enter OTP</label>
      <input type="text" id="otp" placeholder="6-digit OTP">

      <button type="button" id="registerBtn" class="primary-btn">
        Complete Registration
      </button>
    </div>
  </form>

  <p class="auth-switch">
    Already registered?
    <a href="login.php">Login here</a>
  </p>
</section>

<script src="../js/script.js?v=<?= time() ?>"></script>
</body>
</html>
