<?php
global $twig;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
$userID = $_SESSION['UserID'] ?? null;
$username = $_SESSION['Username'] ?? null;
$loggedIn = $_SESSION['logged_in'] ?? false;
$profileID = $userID;
// Setup Twig
if (!isset($twig)) {
    $loader = new FilesystemLoader(dirname(__DIR__, 2) . '/templates');
    $twig = new Environment($loader, [
        'cache' => dirname(__DIR__, 2) . '/twig/cache',
        'debug' => true,
    ]);
}
$twig->addExtension(new DebugExtension());

// Get DB connection
$pdo = getDbConnection();

// Adjust parameter name to your routing
$userName = $_GET['Username'] ?? null; // or 'niceName' or 'Username'

// Validate parameter
if (!$userName) {
    echo "Invalid profile URL.";
    exit;
}

// Prepare SQL
$query = "
    SELECT users.UserID, users.FirstName, users.Email, users.NiceName, users.Username,            
           profile.Avatar, profile.Bio, profile.Gender, profile.RatingPref, 
           profile.Subscriptions, profile.Website, profile.LastMod, profile.CoverPhoto
    FROM users 
    LEFT JOIN profile ON users.UserID = profile.ProfileID 
    WHERE users.Username = :username
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $userName);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$query2 = "
SELECT usersocials.Platform, userSocials.ProfileURL, usersocials.Handle 
FROM users 
LEFT JOIN usersocials ON users.UserID = usersocials.UserID 
WHERE users.Username = :username
";
$stmt2 = $pdo->prepare($query);
$stmt2->bindParam(':username', $userName);
$stmt2->execute();
$socials = $stmt2->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit;
}


// Render Twig
echo $twig->render('profile-view.html', [
    'users'     => $user,
    'userID'    => $userID,
    'username'  => $username,
    'logged_in' => $loggedIn,
    'profileID' => $profileID,
    'csrfToken' => $_SESSION['csrf_token'],
    'session'   => $session
]);