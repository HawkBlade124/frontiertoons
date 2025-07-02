<?php
// ─────────────────────────────────────────────────────────────
// Dependencies and Configuration
// ─────────────────────────────────────────────────────────────
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once dirname(__DIR__, 2) . '/includes/controllers/UserController.php';
require_once dirname(__DIR__, 2) . '/twig/vendor/autoload.php';

// ─────────────────────────────────────────────────────────────
// Session & Database Setup
// ─────────────────────────────────────────────────────────────
$userID     = $_SESSION['userID']     ?? null;
$username   = $_SESSION['username']   ?? null;
$loggedIn   = $_SESSION['logged_in']  ?? false;

if (!$userID) {
    die('User not logged in.');
}

$pdo = getDbConnection(); // returns PDO instance

// ─────────────────────────────────────────────────────────────
// Query User + Avatar
// ─────────────────────────────────────────────────────────────
$query = "
    SELECT users.*, profile.avatar 
    FROM users 
    LEFT JOIN profile ON users.userID = profile.profileID 
    WHERE users.userID = :userID
";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':userID', $userID);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ─────────────────────────────────────────────────────────────
// Setup Twig if not already available
// ─────────────────────────────────────────────────────────────
if (!isset($twig)) {
    $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 2) . '/templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => dirname(__DIR__, 2) . '/twig/cache',
        'debug' => true
    ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

// ─────────────────────────────────────────────────────────────
// Pass data to Twig template
// ─────────────────────────────────────────────────────────────
echo $twig->render('dashboard.html', [
    'title'     => 'Dashboard',
    'users'     => $user,
    'userID'    => $userID,
    'username'  => $username,
    'logged_in' => $loggedIn,
]);
