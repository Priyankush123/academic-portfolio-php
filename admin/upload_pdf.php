<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . "/../includes/db.php";
require_once __DIR__ . "/../includes/admin_auth.php";

requireAdmin();
$pdfs = $pdo->query(
  "SELECT id, title, filename, uploaded_at
   FROM pdfs
   ORDER BY uploaded_at DESC"
)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');

  if (!$title || empty($_FILES['pdf']['name'])) {
    die("Missing title or PDF");
  }

  $file = $_FILES['pdf'];

  if ($file['type'] !== 'application/pdf') {
    die("Only PDF files allowed");
  }

  $safeName = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $file['name']);
  $targetDir = __DIR__ . "/../uploads/pdfs/";
  $targetPath = $targetDir . $safeName;

  if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    die("Failed to upload PDF");
  }

  $stmt = $pdo->prepare(
    "INSERT INTO pdfs (title, filename, uploaded_at)
     VALUES (?, ?, NOW())"
  );
  $stmt->execute([$title, $safeName]);

  header("Location: dashboard.php");
  exit;
}
?>

<!doctype html>
<html>
<head>
  <title>Upload PDF</title>
  <link rel="icon" type="image/png" sizes="32x32" href="../favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
<link rel="shortcut icon" href="../favicon.png">
  <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
</head>
<body>

<header class="header">
  <span class="name">Upload PDF</span>
  <nav class="header-right">
  <a href="dashboard.php">Dashboard</a>
  <a href="../logout.php" class="auth-link">Logout</a>
</nav>

</header>

<section class="auth-container">
  <form method="post" enctype="multipart/form-data" class="auth-form">
    <label>PDF Title</label>
    <input type="text" name="title" required>

    <label>Select PDF</label>
    <input type="file" name="pdf" accept="application/pdf" required>

    <button type="submit">Upload PDF</button>
  </form>
</section>

<section class="admin-card">
  <h2>Existing PDFs</h2>

  <?php if (!$pdfs): ?>
    <p style="opacity:.6;">No PDFs uploaded yet.</p>
  <?php else: ?>
    <table class="data-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Uploaded</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

      <?php foreach ($pdfs as $pdf): ?>
        <tr>
          <td><?= htmlspecialchars($pdf['title']) ?></td>
          <td><?= date("d M Y", strtotime($pdf['uploaded_at'])) ?></td>
          <td class="action-buttons">
            <a href="../pdf.php?id=<?= $pdf['id'] ?>"
               class="btn btn-view"
               target="_blank">
              View PDF
            </a>

            <a href="edit_pdf.php?id=<?= $pdf['id'] ?>"
               class="btn btn-edit">Edit</a>

            <a href="delete_pdf.php?id=<?= $pdf['id'] ?>"
               class="btn btn-delete"
               onclick="return confirm('Delete this PDF permanently?')">
               Delete
            </a>

          </td>
        </tr>
      <?php endforeach; ?>

      </tbody>
    </table>
  <?php endif; ?>
</section>


</body>
</html>
