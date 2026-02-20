<?php
session_start();
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/admin_auth.php";

requireAdmin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  die("Invalid request");
}

/* Fetch filename */
$stmt = $pdo->prepare("SELECT filename FROM pdfs WHERE id = ?");
$stmt->execute([$id]);
$pdf = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pdf) {
  die("PDF not found");
}

/* Delete file */
$filePath = "/home/u978836557/secure_uploads/pdfs/" . $pdf['filename'];
if (file_exists($filePath)) {
  unlink($filePath);
}

/* Delete DB record */
$pdo->prepare("DELETE FROM pdfs WHERE id = ?")->execute([$id]);

header("Location: dashboard.php");
exit;
