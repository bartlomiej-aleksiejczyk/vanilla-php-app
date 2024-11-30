<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config/db.php';

use BartlomiejAleksiejczyk\PestJs\Shared\Database\MigrationManager;
use BartlomiejAleksiejczyk\PestJs\Shared\Database\EntityGenerator;

$pdo = require 'config/db.php';
$migrationManager = new MigrationManager($pdo, __DIR__ . '/src/Resources/Migrations');
$entityGenerator = new EntityGenerator($pdo, __DIR__ . '/src/Resources/entities');

$options = getopt('', ['migrate', 'create-migration:', 'generate-entities']);

if (isset($options['migrate'])) {
    $migrationManager->runMigrations();
} elseif (isset($options['create-migration'])) {
    $name = $options['create-migration'];
    $migrationManager->createMigration($name);
} elseif (isset($options['generate-entities'])) {
    $entityGenerator->generateEntities();
} else {
    echo "Usage:\n";
    echo "  --migrate                Run migrations\n";
    echo "  --create-migration=name  Create a new migration\n";
    echo "  --generate-entities      Generate entity classes from database tables\n";
}
