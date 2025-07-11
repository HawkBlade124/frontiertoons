<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("Session CSRF: " . ($_SESSION['csrf_token'] ?? 'none'));
error_log("POST CSRF: " . ($_POST['csrf_token'] ?? 'none'));

require_once __DIR__ . '/twig/vendor/autoload.php';
require_once __DIR__ . '/includes/config.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/twig/cache',
    'debug' => true,
]);

$basePath = ''; // Update to '/myapp' if needed

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($basePath && strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
$uri = rtrim($uri, '/');
$uri = $uri === '' ? '' : '/' . ltrim($uri, '/');

$routes = [
    '' => 'homepage.php',
    '/home' => 'homepage.php',
    '/login' => 'login.php',
    '/dashboard' => 'dashboard.php',
    '/logout' => 'logout.php',
    '/catalog' => 'catalog.php',
    '/profile-view' => 'profile-view.php',
    '/register' => 'registration.php',
    '/recommended' => 'recommended.php',
    '/forgot-password' => 'forgot-password.php',
    '/blog' => 'blog.php',
];

$routeFile = $routes[$uri] ?? '404.php';

require_once __DIR__ . "/includes/routes/$routeFile";