<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/includes/config.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/cache',
    'debug' => true,
]);

try {
    $stmt = $pdo->query('SELECT * FROM users ORDER BY userID DESC LIMIT 10');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo $twig->render('base.index.html', ['users' => $users]);
} catch (Exception $e) {
    echo 'Twig Render Error: ' . $e->getMessage();
}