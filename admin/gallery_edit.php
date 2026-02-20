<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM gallery_events WHERE id=?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
  die("Event not found");
}

/* Update title + year */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $title = trim($_POST['title']);
  $year  = (int)$_POST['year'];

  $pdo->prepare(
    "UPDATE gallery_events SET title=?, year=? WHERE id=?"
  )->execute([$title, $year, $id]);

  /* Handle new images */
  if (!empty($_FILES['images']['name'][0])) {

    $uploadDir = __DIR__ . "/../uploads/gallery/";

    foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {

      if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) continue;

      $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));

      if (!in_array($ext, ['jpg','jpeg','png','webp'])) continue;

      $safe = time() . "_" . uniqid() . "." . $ext;

      if (move_uploaded_file($tmp, $uploadDir . $safe)) {
        $pdo->prepare(
          "INSERT INTO gallery_images (event_id, filename)
           VALUES (?, ?)"
        )->execute([$id, $safe]);
      }
    }
  }

  header("Location: gallery_edit.php?id=" . $id);
  exit;
}

/* Get images */
$images = $pdo->prepare(
  "SELECT * FROM gallery_images WHERE event_id=?"
);
$images->execute([$id]);
?>
<!doctype html>
<html>
<head>
<title>Edit Gallery</title>
<link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
</head>
<body>

<header class="header admin-header">
  <span class="name">Edit Gallery Event</span>
  <nav class="header-right">
    <a href="gallery.php">Back</a>
    <a href="../logout.php" class="auth-link">Logout</a>
  </nav>
</header>

<section class="admin-card">
<h2>Edit Event</h2>

<form method="post" enctype="multipart/form-data" class="auth-form">
  <input name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
  <input type="number" name="year" value="<?= htmlspecialchars($event['year']) ?>" required>

  <label>Add More Images</label>
  <input type="file" name="images[]" multiple accept="image/*">

  <button>Update Event</button>
</form>
</section>

<section class="admin-card">
<h2>Existing Images</h2>

<div class="admin-thumb-grid">
<?php foreach ($images as $img): ?>
  <div style="position:relative;">
    <img src="/uploads/gallery/<?= htmlspecialchars($img['filename']) ?>" width="120">
    <a href="gallery_image_delete.php?id=<?= $img['id'] ?>&event=<?= $id ?>"
       class="btn btn-delete"
       style="position:absolute;top:5px;right:5px;padding:4px 8px;font-size:12px;">
       ✖
    </a>
  </div>
<?php endforeach; ?>
</div>

</section>

</body>
</html>
