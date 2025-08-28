<?php
global $twig;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
$userID = $_SESSION['UserID'] ?? null;
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
    SELECT users.UserID, users.FirstName, users.Email, users.Username,            
           profile.Avatar, profile.Bio, profile.Gender, profile.RatingPref, 
           profile.Subscriptions, profile.Website, profile.LastMod, 
           profile.CoverPhoto, profile.patreon, profile.NiceName, profile.Uploads
    FROM users 
    LEFT JOIN profile ON users.UserID = profile.ProfileID 
    WHERE users.Username = :username
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $userName);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$socialQuery = "
  SELECT Platform, ProfileURL
  FROM usersocials
  WHERE UserID = :uid
  ORDER BY LastMod DESC
";
$stmt3 = $pdo->prepare($socialQuery);
$stmt3->execute([':uid' => $user['UserID']]);
$rows = $stmt3->fetchAll(PDO::FETCH_ASSOC);


if (!$user) {
    echo "User not found.";
    exit;
}
$twig->addFilter(new \Twig\TwigFilter('hash', function ($value, $namespace = 'user-images-v1') {
    return hash('sha256', $namespace . '-' . $value);
}));
$socialsByPlatform = [];
foreach ($rows as $r) {
    $key = strtolower(trim($r['Platform'])); // e.g., 'facebook', 'twitter', 'instagram', 'youtube'
    if (!isset($socialsByPlatform[$key]) && !empty($r['ProfileURL'])) {
        $socialsByPlatform[$key] = $r['ProfileURL'];
    }
}

// Render Twig
echo $twig->render('profile-view.html', [
    'session'    => $session,
    'users'      => $user,
    'userID'     => $user['UserID'],
    'username'   => $user['Username'],
    'logged_in'  => $loggedIn,
    'profileID'  => $user['UserID'],
    'socials'    => $socialsByPlatform,   // << pass the map
]);