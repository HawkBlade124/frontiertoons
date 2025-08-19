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

$userID = $_SESSION['UserID'] ?? null;
$username = $_SESSION['Username'] ?? null;
$loggedIn = $_SESSION['logged_in'] ?? false;

// Gather session info
$session = [
    'UserID'   => $_SESSION['UserID'] ?? null,
    'Username' => $_SESSION['Username'] ?? null,
    'logged_in'  => $_SESSION['logged_in'] ?? false,
    
];

// Register these as Twig globals
foreach ($session as $key => $value) {
    $twig->addGlobal($key, $value);
}


$basePath = '';

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
    '/profile-view' => 'profile-view.php',
    '/upload' => 'upload-series.php'
];

$routeFile = $routes[$uri] ?? null;

// Handle dynamic profile-view/{niceName}
if (!$routeFile && preg_match('#^/profile-view/([^/]+)$#', $uri, $matches)) {
    $_GET['Username'] = $matches[1]; // Pass username into PHP
    $routeFile = 'profile-view.php';
}

// Fallback to 404
if (!$routeFile) {
    $routeFile = '404.php';
}

require_once __DIR__ . "/includes/routes/$routeFile";