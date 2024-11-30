<?php

$rootDir = dirname(__DIR__, 1);
$databaseFile = $rootDir . '/db/simple_blog.db';

$dsn = "sqlite:$databaseFile";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

return $pdo;
