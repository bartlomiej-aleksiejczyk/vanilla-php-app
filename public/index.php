<?php
$pdo = require __DIR__ . '/../config/db.php';

$stmt = $pdo->query("SELECT id, title FROM posts");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$title = "Home";
ob_start();
?>
<h1>All Posts</h1>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <a href="post.php?id=<?= htmlspecialchars($post['id']) ?>">
                <?= htmlspecialchars($post['title']) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
<?php
$content = ob_get_clean();
require __DIR__ . '/../components/layout.php';
