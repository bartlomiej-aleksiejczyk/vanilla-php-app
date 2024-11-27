<?php
class AddAuthorToPosts
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function up()
    {
        $this->pdo->exec("
            ALTER TABLE posts ADD COLUMN author TEXT DEFAULT 'Anonymous'
        ");
        echo "Column 'author' added to 'posts'.\n";
    }
}
