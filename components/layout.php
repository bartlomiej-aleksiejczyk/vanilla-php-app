<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Simple Blog'; ?></title>
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>
    <main>
        <?= $content ?? ''; ?>
    </main>
    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
