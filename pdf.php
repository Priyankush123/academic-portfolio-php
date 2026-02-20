<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/includes/db.php";

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$pdfId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($pdfId <= 0) {
    http_response_code(400);
    exit;
}

$stmt = $pdo->prepare("SELECT id, filename FROM pdfs WHERE id = ?");
$stmt->execute([$pdfId]);
$pdf = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pdf) {
    http_response_code(404);
    exit;
}

// Log access
$pdo->prepare(
    "INSERT INTO pdf_access_logs (user_id, pdf_id) VALUES (?, ?)"
)->execute([$_SESSION['user_id'], $pdf['id']]);

$filePath = __DIR__ . "/uploads/pdfs/" . $pdf['filename'];

if (!file_exists($filePath) || !is_readable($filePath)) {
    http_response_code(404);
    exit;
}

// Absolutely clean output
while (ob_get_level()) {
    ob_end_clean();
}

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=\"" . basename($pdf['filename']) . "\"");
header("Content-Length: " . filesize($filePath));
header("Cache-Control: private");
header("X-Content-Type-Options: nosniff");

readfile($filePath);
exit;
