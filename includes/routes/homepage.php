<?php
global $twig;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;

if (!isset($twig)) {
    $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 2) . '/templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => dirname(__DIR__, 2) . '/twig/cache',
        'debug' => true,
    ]);
}
    $twig->addExtension(new \Twig\Extension\DebugExtension());
$pdo = getDbConnection();
$query = "
 SELECT users.UserID, users.FirstName, users.Email, users.Username, profile.NiceName
    FROM users 
    LEFT JOIN profile ON users.UserID = profile.ProfileID 
    WHERE users.Username = :username
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $userID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$query2 = "
 SELECT series.SeriesID, series.Title, series.Author, series.Credits, series.MaturityRating, series.UserID
    FROM series 
    LEFT JOIN users ON series.UserID = users.UserID
    WHERE series.Author = :author
";
$stmt2 = $pdo->prepare($query2);
$stmt2->bindParam(':author', $userID, PDO::PARAM_INT);
$stmt2->execute();
$series = $stmt2->fetch(PDO::FETCH_ASSOC);

echo $twig->render('homepage.html',
[
    'session' => $session,
    'series' => $series
]);
