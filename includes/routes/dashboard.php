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
           profile.Subscriptions, profile.Website, profile.LastMod, profile.CoverPhoto, profile.Uploads, profile.Patreon
    FROM users 
    LEFT JOIN profile ON users.UserID = profile.ProfileID 
    WHERE users.UserID = :user_id
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$query2 = "
    SELECT series.SeriesID, series.Title, series.Author, series.Credits, series.MaturityRating, series.UserID
    FROM series
    LEFT JOIN users ON series.UserID = users.UserID
    WHERE series.UserID = :userID
";
$stmt2 = $pdo->prepare($query2);
$stmt2->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt2->execute();
$series = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$socialQuery = "
    SELECT usersocials.UserID, usersocials.platform, usersocials.ProfileURL
    FROM usersocials
    LEFT JOIN users ON usersocials.UserID = users.UserID
    WHERE usersocials.UserID = :socuserID
";
$stmt3 = $pdo->prepare($socialQuery);
$stmt3->bindParam(':socuserID', $userID, PDO::PARAM_INT);
$stmt3->execute();
$socials = $stmt3->fetchAll(PDO::FETCH_ASSOC);
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
    'session' => $session,
    'hideHeaderFooter' => true,
    'series' => $series,
    'socials' => $socials
]);