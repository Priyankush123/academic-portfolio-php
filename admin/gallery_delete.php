<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die("Invalid ID");

/* Delete files */
$stmt = $pdo->prepare(
  "SELECT filename FROM gallery_images WHERE event_id=?"
);
$stmt->execute([$id]);
foreach ($stmt as $img) {
  $path = "../uploads/gallery/" . $img['filename'];
  if (file_exists($path)) unlink($path);
}

/* Delete DB (cascade removes images) */
$pdo->prepare("DELETE FROM gallery_events WHERE id=?")
    ->execute([$id]);

header("Location: gallery.php");
exit;
