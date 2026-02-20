<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo->prepare(
    "INSERT INTO blogs (title, summary, content)
     VALUES (?, ?, ?)"
  )->execute([
    $_POST['title'],
    $_POST['summary'],
    $_POST['content']
  ]);
}

$blogs = $pdo->query(
  "SELECT * FROM blogs ORDER BY created_at DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
<title>Blog Admin</title>
<link rel="icon" href="../images/logo.webp" />
<link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>

<header class="header">
  <span class="name">Blog Admin</span>
  <nav class="header-right">
  <a href="dashboard.php">Dashboard</a>
  <a href="../logout.php" class="auth-link">Logout</a>
</nav>

</header>

<section class="blog-admin-container">
  <h1>Create New Blog</h1>

  <form method="post" onsubmit="copyContent()" class="blog-form">
    <div class="form-group">
      <label>Blog Title</label>
      <input name="title" placeholder="Enter blog title" required>
    </div>

    <div class="form-group">
      <label>Short Summary</label>
      <textarea name="summary" placeholder="Brief description (shown on homepage)"></textarea>
    </div>

    <div class="form-group">
      <label>Blog Content</label>
      <div id="editor"></div>
      <input type="hidden" name="content" id="content">
    </div>

    <button class="btn-primary">Publish Blog</button>
  </form>
</section>


<section class="blog-admin-list-container">
  <h2>Existing Blogs</h2>

  <?php if (count($blogs) === 0): ?>
    <p class="empty-text">No blogs published yet.</p>
  <?php endif; ?>

  <?php foreach ($blogs as $b): ?>
    <div class="blog-admin-item">

      <div class="blog-admin-info">
        <h4><?= htmlspecialchars($b['title']) ?></h4>
        <span><?= date("d M Y, H:i", strtotime($b['created_at'])) ?></span>
      </div>

      <div class="action-buttons">
        <a href="edit_blog.php?id=<?= $b['id'] ?>" class="btn btn-edit">
          ✏ Edit
        </a>

        <a href="delete_blog.php?id=<?= $b['id'] ?>"
           class="btn btn-delete"
           onclick="return confirm('Delete this blog permanently?')">
          🗑 Delete
        </a>
      </div>

    </div>
  <?php endforeach; ?>
</section>


<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
const quill = new Quill('#editor', { theme: 'snow' });
function copyContent(){
  document.getElementById('content').value = quill.root.innerHTML;
}
</script>

</body>
</html>
