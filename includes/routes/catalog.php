<?php
global $twig;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
$userID = $_SESSION['userID'] ?? null;
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
    SELECT users.UserID, users.FirstName, users.Email, users.Username            
    FROM users 
    LEFT JOIN series ON users.UserID = series.Author 
    WHERE users.userID = :userID
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sessionVars =[
    'users'     => $user,
    'userID'    => $userID,
    'username'  => $username,
    'logged_in' => $loggedIn,
    'csrfToken' => $_SESSION['csrf_token']
];
echo $twig->render('catalog.html', $sessionVars);
