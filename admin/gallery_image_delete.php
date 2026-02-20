<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

$id = (int)$_GET['id'];
$event = (int)$_GET['event'];

$stmt = $pdo->prepare("SELECT filename FROM gallery_images WHERE id=?");
$stmt->execute([$id]);
$image = $stmt->fetch();

if ($image) {

  $file = __DIR__ . "/../uploads/gallery/" . $image['filename'];

  if (file_exists($file)) {
    unlink($file);
  }

  $pdo->prepare("DELETE FROM gallery_images WHERE id=?")
      ->execute([$id]);
}

header("Location: gallery_edit.php?id=" . $event);
exit;
