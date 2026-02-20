<?php
session_start();
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/admin_auth.php";

requireAdmin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  die("Invalid PDF ID");
}

/* Fetch existing PDF */
$stmt = $pdo->prepare("SELECT id, title FROM pdfs WHERE id = ?");
$stmt->execute([$id]);
$pdf = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pdf) {
  die("PDF not found");
}

/* Update title */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title']);

  if (!$title) {
    die("Title cannot be empty");
  }

  $pdo->prepare(
    "UPDATE pdfs SET title = ? WHERE id = ?"
  )->execute([$title, $id]);

  header("Location: dashboard.php");
  exit;
}
?>

<!doctype html>
<html>
<head>
  <title>Edit PDF</title>
  <link rel="icon" type="image/png" sizes="32x32" href="../favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
<link rel="shortcut icon" href="../favicon.png">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="header">
  <span class="name">Edit PDF Title</span>
  <nav>
    <a href="dashboard.php">Dashboard</a>
    <a href="../logout.php">Logout</a>
  </nav>
</header>

<section class="auth-container">
  <form method="post" class="auth-form">
    <label>PDF Title</label>
    <input type="text" name="title"
           value="<?= htmlspecialchars($pdf['title']) ?>" required>

    <button type="submit">Save Changes</button>
  </form>
</section>

</body>
</html>
