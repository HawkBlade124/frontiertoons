<?php
require_once dirname(__DIR__, 1) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/controllers/UserController.php';
require_once dirname(__DIR__, 2) . '/twig/vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;

$profileID = $userID;

if (!$userID) {
    die('User not logged in.');
}

// Setup Twig
$loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates');
$twig = new Environment($loader, [
    'cache' => false,
    'debug' => true
]);
$twig->addExtension(new DebugExtension());
$twig->addFilter(new \Twig\TwigFilter('hash', function ($value, $namespace = 'user-images-v1') {
    return hash('sha256', $namespace . '-' . $value);
}));

// Render Template
echo $twig->render('upload.html', [
    'title'     => 'Dashboard',
    'users'     => $user,
    'userID'    => $userID,
    'username'  => $username,
    'logged_in' => $loggedIn,
    'profileID' => $profileID,
    'session' => $session    
]);