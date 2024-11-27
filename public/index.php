<?php
include 'db.php';

$query = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Blog</title>
</head>
<body>
    <h1>Simple Blog</h1>
    <a href="create.php">Create New Post</a>
    <?php foreach ($posts as $post): ?>
        <h2><a href="post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
        <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 100))) ?>...</p>
    <?php endforeach; ?>
</body>
</html>
