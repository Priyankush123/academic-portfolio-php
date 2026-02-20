<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$pdo->prepare("DELETE FROM blogs WHERE id=?")->execute([$id]);

header("Location: blog.php");
exit;
