<?php
function requireAdmin() {
  if (
    !isset($_SESSION['user_id']) ||
    empty($_SESSION['is_admin'])
  ) {
    header("Location: /login.php");
    exit;
  }
}
