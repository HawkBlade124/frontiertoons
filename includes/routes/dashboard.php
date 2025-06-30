<?php
ob_start();
session_start();
require_once dirname(__DIR__, 2) . '/includes/controllers/UserController.php';
require_once dirname(__DIR__, 2) . '/includes/config.php'; // Ensure $pdo and getDbConnection()
require_once dirname(__DIR__, 2) . '/twig/vendor/autoload.php'; // Ensure $twig is available

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: /login?error=unauthorized');
    exit;
}

// Debug session
error_log("Session data in dashboard.php: " . print_r($_SESSION, true));

// Fetch user info
$userID = $_SESSION['userID'] ?? null;
$profileID = $_SESSION['profileID'] ?? null;
$pdo = getDbConnection(); // Ensure this returns a valid PDO instance
$user = $userID ? getUserInfo($pdo, $userID) : null;
$userProfile = $profileID ? getProfileInfo($pdo, $profileID) : null;
// Set up Twig if not already set
global $twig;
if (!isset($twig)) {
    $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 2) . '/templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => dirname(__DIR__, 2) . '/twig/cache',
        'debug' => true,
    ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

// Pass variables to Twig
$templateVars = [
    'title' => 'Dashboard',
    'username' => $_SESSION['username'] ?? null,
    'userID' => $userID,
    'logged_in' => $_SESSION['logged_in'] ?? false,
    'users' => $user,
];

echo $twig->render('dashboard.html', $templateVars);
