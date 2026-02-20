<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

/* Fetch access logs (simple version) */
$logs = $pdo->query(
  "SELECT u.email, p.title, l.accessed_at
   FROM pdf_access_logs l
   JOIN users u ON l.user_id = u.id
   JOIN pdfs p ON l.pdf_id = p.id
   ORDER BY l.accessed_at DESC
   LIMIT 20"
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
<link rel="icon" type="image/png" sizes="32x32" href="../favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
<link rel="shortcut icon" href="../favicon.png">

</head>
<body>

<header class="header admin-header">
  <div class="header-left">
    <span class="name">Admin Dashboard</span>
  </div>
  <nav class="header-right">
    <a href="../index.php">View Site</a>
    <a href="../logout.php" class="auth-link">Logout</a>
  </nav>
</header>

<main class="admin-container">

  <!-- QUICK ACTIONS -->
  <section class="admin-card">
    <h2>Quick Management</h2>

    <div class="action-buttons">
      <a href="upload_pdf.php" class="btn btn-edit"> Manage PDFs</a>
      <a href="gallery.php" class="btn btn-edit"> Manage Gallery</a>
      <a href="blog.php" class="btn btn-edit"> Manage Blogs</a>
      <a href="achievements.php" class="btn btn-edit"> Manage Achievements</a>

    </div>
  </section>

  <!-- ACCESS LOGS -->
  <section class="admin-card">
    <h2>Recent PDF Access</h2>

    <table class="data-table">
      <thead>
        <tr>
          <th>User Email</th>
          <th>PDF</th>
          <th>Accessed</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($logs)): ?>
          <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= htmlspecialchars($log['email']) ?></td>
              <td><?= htmlspecialchars($log['title']) ?></td>
              <td><?= date("d M Y, H:i", strtotime($log['accessed_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="3">No access yet</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </section>

</main>

</body>
</html>
