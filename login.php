<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Dr. Amba Pande</title>

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
  <h2>Login</h2>
  <p class="auth-text">
    Please enter your name and registered email to continue.
  </p>

  <form class="auth-form" id="loginForm">
    <label for="name">Name</label>
    <input type="text" id="name" placeholder="Your full name" required>

    <label for="email">Email</label>
    <input type="email" id="email" placeholder="Your registered email" required>

    <button type="button" id="loginBtn">Login</button>
  </form>

  <p class="auth-switch">
    Not registered?
    <a href="register.php">Register here</a>
  </p>
</section>

<script src="../js/script.js?v=<?= time() ?>"></script>
</body>
</html>
