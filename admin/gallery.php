<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

/* Add new gallery event */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $title = trim($_POST['title'] ?? '');
  $year  = (int)($_POST['year'] ?? 0);

  if ($title === '' || $year === 0) {
    die("Title and year required");
  }

  if (empty($_FILES['images']['name'][0])) {
    die("No images selected");
  }

  // Insert event with year
  $pdo->prepare(
    "INSERT INTO gallery_events (title, year)
     VALUES (?, ?)"
  )->execute([$title, $year]);

  $eventId = $pdo->lastInsertId();

  $uploadDir = __DIR__ . "/../uploads/gallery/";
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
  }

  foreach ($_FILES['images']['tmp_name'] as $i => $tmp) {

    if ($_FILES['images']['error'][$i] !== UPLOAD_ERR_OK) {
      continue;
    }

    $original = $_FILES['images']['name'][$i];
    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
      continue;
    }

    $safeName = time() . "_" . uniqid() . "." . $ext;
    $targetPath = $uploadDir . $safeName;

    if (move_uploaded_file($tmp, $targetPath)) {
      $pdo->prepare(
        "INSERT INTO gallery_images (event_id, filename)
         VALUES (?, ?)"
      )->execute([$eventId, $safeName]);
    }
  }

  header("Location: gallery.php");
  exit;
}

/* Fetch events ORDER BY YEAR DESC */
$events = $pdo->query(
  "SELECT * FROM gallery_events
   ORDER BY year DESC, id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>
<head>
<title>Gallery Admin</title>
<link rel="icon" type="image/png" sizes="32x32" href="../favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
<link rel="shortcut icon" href="../favicon.png">
<link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
</head>
<body>

<header class="header admin-header">
  <span class="name">Gallery Admin</span>
  <nav class="header-right">
    <a href="dashboard.php">Dashboard</a>
    <a href="../logout.php" class="auth-link">Logout</a>
  </nav>
</header>

<section class="admin-card">
<h2>Add Gallery Event</h2>
<form method="post" enctype="multipart/form-data" class="auth-form">
  <input name="title" placeholder="Event title" required>

  <input type="number" name="year" placeholder="Year (e.g. 2024)" required>

  <input type="file" name="images[]" multiple accept="image/*" required>

  <button>Add Event</button>
</form>

</section>

<section class="admin-card">
<h2>Existing Events</h2>

<?php foreach ($events as $e): ?>
  <div class="admin-event">
    <strong>
        <?= htmlspecialchars($e['title']) ?>
        (<?= htmlspecialchars($e['year']) ?>)
    </strong>
    <div class="admin-event-actions">
    <a href="gallery_edit.php?id=<?= $e['id'] ?>" 
        class="btn btn-edit">
        Edit
    </a>
    </div>
    <div class="admin-event-actions">
      <a href="gallery_delete.php?id=<?= $e['id'] ?>"
         class="btn btn-delete"
         onclick="return confirm('Delete event and all images?')">
         Delete
      </a>
    </div>

    <div class="admin-thumb-grid">
      <?php
      $imgs = $pdo->prepare(
        "SELECT filename FROM gallery_images WHERE event_id=?"
      );
      $imgs->execute([$e['id']]);
      foreach ($imgs as $img):
      ?>
        <img src="/uploads/gallery/<?= htmlspecialchars($img['filename']) ?>">
      <?php endforeach; ?>
    </div>
  </div>
<?php endforeach; ?>

</section>

</body>
</html>
