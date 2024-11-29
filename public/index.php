<?php
$title = "Home";
ob_start();
?>
<h2>Welcome to the Simple Blog</h2>
<p>This is the homepage of our blog.</p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../components/layout.php';
