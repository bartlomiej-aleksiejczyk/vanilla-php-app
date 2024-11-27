<?php
include 'db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die('Post not found!');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= htmlspecialchars($post['title']) ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    <a href="index.php">Back to Home</a>
</body>

</html>