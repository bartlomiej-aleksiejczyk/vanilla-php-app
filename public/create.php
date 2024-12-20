<?php
$pdo = require __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
    $stmt->execute(['title' => $title, 'content' => $content]);

    header('Location: index.php');
    exit;
}

$title = "Create Post";
ob_start();
?>
<h1>Create New Post</h1>
<form method="POST" action="create.php">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>
    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="5" cols="40" required></textarea><br><br>
    <button type="submit">Submit</button>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../components/layout.php';
