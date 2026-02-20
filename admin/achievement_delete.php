<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

$id = (int)($_GET['id'] ?? 0);

if ($id) {
  $pdo->prepare("DELETE FROM achievements WHERE id=?")->execute([$id]);
}

header("Location: achievements.php");
exit;
