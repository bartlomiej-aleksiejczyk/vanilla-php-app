<?php

namespace BartlomiejAleksiejczyk\PestJs\Shared\Database;

use PDO;

class EntityGenerator
{
    private $pdo;
    private $entitiesDir;

    public function __construct($pdo, $entitiesDir)
    {
        $this->pdo = $pdo;
        $this->entitiesDir = $entitiesDir;
    }

    public function generateEntities()
    {
        $tables = $this->getTables();

        foreach ($tables as $table) {
            $columns = $this->getColumns($table);
            $this->generateEntity($table, $columns);
        }
    }

    private function getTables()
    {
        return $this->pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")
            ->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getColumns($table)
    {
        return $this->pdo->query("PRAGMA table_info($table)")->fetchAll(PDO::FETCH_ASSOC);
    }

    private function generateEntity($table, $columns)
    {
        $className = ucfirst($table);
        $properties = '';

        foreach ($columns as $column) {
            $properties .= "    public \${$column['name']};\n";
        }

        $template = <<<PHP
<?php

namespace Entities;

class {$className} {
$properties
}
PHP;

        file_put_contents("{$this->entitiesDir}/{$className}.php", $template);
        echo "Entity generated: {$className}.php\n";
    }
}
