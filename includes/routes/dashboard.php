<?php
require_once dirname(__DIR__, 1) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/controllers/UserController.php';
require_once dirname(__DIR__, 2) . '/twig/vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;

$userID = $_SESSION['UserID'] ?? null;
$username = $_SESSION['Username'] ?? null;
$loggedIn = $_SESSION['logged_in'] ?? false;
$profileID = $userID;

if (!$userID) {
    die('User not logged in.');
}

$pdo = getDbConnection();
$query = "
 SELECT users.UserID, users.FirstName, users.Email, users.NiceName, users.Username,            
           profile.Avatar, profile.Bio, profile.Gender, profile.RatingPref, 
           profile.Subscriptions, profile.Website, profile.LastMod, profile.CoverPhoto
    FROM users 
    LEFT JOIN profile ON users.UserID = profile.ProfileID 
    WHERE users.UserID = :user_id
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

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
echo $twig->render('dashboard.html', [
    'title'     => 'Dashboard',
    'users'     => $user,
    'userID'    => $userID,
    'username'  => $username,
    'logged_in' => $loggedIn,
    'profileID' => $profileID,
    'csrfToken' => $_SESSION['csrf_token'],
    'session' => $session
]);