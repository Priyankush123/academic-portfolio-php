<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

/* =========================
   ADD NEW ACHIEVEMENT
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {

  $title = trim($_POST['title'] ?? '');
  $year  = trim($_POST['year'] ?? '');
  $type  = $_POST['type'] ?? '';

  if (!$title || !$type) {
    die("Title and Type required");
  }

  $stmt = $pdo->prepare(
    "INSERT INTO achievements (title, year, type, created_at)
     VALUES (?, ?, ?, NOW())"
  );

  $stmt->execute([$title, $year, $type]);

  header("Location: achievements.php");
  exit;
}

/* =========================
   DELETE
========================= */
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];

  $pdo->prepare("DELETE FROM achievements WHERE id=?")
      ->execute([$id]);

  header("Location: achievements.php");
  exit;
}

/* =========================
   FETCH ALL
========================= */
$items = $pdo->query(
  "SELECT * FROM achievements
   ORDER BY year DESC, created_at DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>
<head>
<title>Achievements Admin</title>
<link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
<link rel="shortcut icon" href="../favicon.png">

</head>
<body>

<header class="header">
  <span class="name">Achievements Admin</span>
  <nav class="header-right">
    <a href="dashboard.php">Dashboard</a>
    <a href="../logout.php" class="auth-link">Logout</a>
  </nav>
</header>

<section class="admin-card">

<h2>Add New Achievement</h2>

<form method="post" class="auth-form">
  <input type="hidden" name="add" value="1">

  <label>Type</label>
  <select name="type" required>
    <option value="">Select</option>
    <option value="fellowship">Fellowship</option>
    <option value="conference">Conference</option>
    <option value="award">Award</option>
  </select>

  <label>Title</label>
  <input type="text" name="title" required>

  <label>Year</label>
  <input type="text" name="year" placeholder="2024">

  <button type="submit">Add Achievement</button>
</form>

</section>

<section class="admin-card">
<h2>Existing Achievements</h2>

<?php foreach ($items as $item): ?>
  <div class="achievement-item">
    <strong>
      <?= htmlspecialchars($item['title']) ?>
      <?php if (!empty($item['year'])): ?>
        (<?= htmlspecialchars($item['year']) ?>)
      <?php endif; ?>
    </strong>
    <br>
    <small>Type: <?= htmlspecialchars($item['type']) ?></small>

    <div style="margin-top:10px;">
      <a href="?delete=<?= $item['id'] ?>"
         class="btn btn-delete"
         onclick="return confirm('Delete this achievement?')">
         Delete
      </a>
    </div>
  </div>
<?php endforeach; ?>

</section>

</body>
</html>
