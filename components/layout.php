<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Simple Blog') ?></title>
</head>
<body>
    <header>
        <h1>Simple Blog</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="create.php">Create Post</a>
        </nav>
    </header>
    <main>
        <?= $content ?? '<p>No content available.</p>'; ?>
    </main>
    <footer>
        <p>&copy; <?= date('Y'); ?> Simple Blog</p>
    </footer>
</body>
</html>
