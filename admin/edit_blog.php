<?php
session_start();
require_once "../includes/db.php";
require_once "../includes/admin_auth.php";
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die("Invalid blog");

$stmt = $pdo->prepare("SELECT * FROM blogs WHERE id=?");
$stmt->execute([$id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$blog) die("Blog not found");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo->prepare(
    "UPDATE blogs SET title=?, summary=?, content=? WHERE id=?"
  )->execute([
    $_POST['title'],
    $_POST['summary'],
    $_POST['content'],
    $id
  ]);
  header("Location: blog.php");
  exit;
}
?>
<!doctype html>
<html>
<head>
<title>Edit Blog</title>
<link rel="icon" type="image/png" sizes="32x32" href="../favicon.png">
<link rel="icon" type="image/png" sizes="16x16" href="../favicon.png">
<link rel="shortcut icon" href="../favicon.png">

<link rel="stylesheet" href="../css/style.css">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>
<body>

<section class="admin-card">
<h2>Edit Blog</h2>
<form method="post" onsubmit="sync()">
  <input name="title" value="<?= htmlspecialchars($blog['title']) ?>" required>
  <textarea name="summary"><?= htmlspecialchars($blog['summary']) ?></textarea>

  <div id="editor" style="height:200px;"></div>
  <input type="hidden" name="content" id="content">

  <button>Save</button>
</form>
</section>

<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
const quill = new Quill('#editor',{theme:'snow'});
quill.root.innerHTML = <?= json_encode($blog['content']) ?>;
function sync(){
  document.getElementById('content').value = quill.root.innerHTML;
}
</script>

</body>
</html>
