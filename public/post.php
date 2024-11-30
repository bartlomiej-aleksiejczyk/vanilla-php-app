<?php
$pdo = require __DIR__ . '/../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die('Invalid post ID!');
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die('Post not found!');
}

$title = $post['title'];
ob_start();
?>
<h1><?= htmlspecialchars($post['title']) ?></h1>
<p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
<a href="index.php">Back to Home</a>
<?php
$content = ob_get_clean();
require __DIR__ . '/../components/layout.php';
