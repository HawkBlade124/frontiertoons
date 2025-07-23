<?php
global $twig;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
$userID = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
$loggedIn = $_SESSION['logged_in'] ?? false;

if (!isset($twig)) {
    $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 2) . '/templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => dirname(__DIR__, 2) . '/twig/cache',
        'debug' => true,
    ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}
$pdo = getDbConnection();
$query = "
    SELECT users.user_id, users.first_name, users.email, users.nice_name, users.username,            
           profile.avatar, profile.bio, profile.gender, profile.rating_pref, 
           profile.subscriptions, profile.website, profile.last_mod
    FROM users 
    LEFT JOIN profile ON users.user_id = profile.profile_id 
    WHERE users.user_id = :user_id
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sessionVars =[
    'users'     => $user,
    'user_id'    => $userID,
    'username'  => $username,
    'logged_in' => $loggedIn,
    'csrfToken' => $_SESSION['csrf_token']
];
echo $twig->render('homepage.html', $sessionVars);
