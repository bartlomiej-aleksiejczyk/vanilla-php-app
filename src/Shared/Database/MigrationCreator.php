<?php

namespace Shared\Database;

class MigrationManager
{
    private $pdo;
    private $migrationsTable = 'migrations';
    private $migrationsDir;

    public function __construct($pdo, $migrationsDir)
    {
        $this->pdo = $pdo;
        $this->migrationsDir = $migrationsDir;
        $this->ensureMigrationsTableExists();
    }

    /**
     * Ensure the migrations table exists in the database.
     */
    private function ensureMigrationsTableExists()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS {$this->migrationsTable} (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                migration TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    /**
     * Get a list of executed migrations from the database.
     *
     * @return array
     */
    private function getExecutedMigrations()
    {
        $stmt = $this->pdo->query("SELECT migration FROM {$this->migrationsTable}");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Save a migration to the migrations table.
     *
     * @param string $migration
     */
    private function saveMigration($migration)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->migrationsTable} (migration) VALUES (:migration)");
        $stmt->execute(['migration' => $migration]);
    }

    /**
     * Run all pending migrations.
     */
    public function runMigrations()
    {
        $executedMigrations = $this->getExecutedMigrations();
        $migrationFiles = array_diff(scandir($this->migrationsDir), ['.', '..']);

        foreach ($migrationFiles as $file) {
            if (in_array($file, $executedMigrations)) {
                continue; // Skip already executed migrations
            }

            require_once "{$this->migrationsDir}/$file";
            $className = pathinfo($file, PATHINFO_FILENAME);

            if (class_exists($className)) {
                echo "Running migration: $file\n";
                (new $className($this->pdo))->up();
                $this->saveMigration($file);
            } else {
                echo "Skipping $file: Migration class not found.\n";
            }
        }
    }

    /**
     * Create a new migration file with a specified name.
     *
     * @param string $name
     */
    public function createMigration($name)
    {
        $timestamp = date('YmdHis');
        $filename = "{$timestamp}_{$name}.php";
        $filepath = "{$this->migrationsDir}/$filename";

        $className = ucfirst($name);

        $template = <<<PHP
<?php

class {$className} {
    private \$pdo;

    public function __construct(\$pdo) {
        \$this->pdo = \$pdo;
    }

    public function up() {
        // Add migration logic here
    }
}
PHP;

        file_put_contents($filepath, $template);
        echo "Migration created: $filename\n";
    }
}
