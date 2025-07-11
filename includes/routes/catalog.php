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
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

$sessionVars =[
        'username' => $_SESSION['username'] ?? null,
    'logged_in' => $_SESSION['logged_in'] ?? false,
];
echo $twig->render('catalog.html', $sessionVars);
