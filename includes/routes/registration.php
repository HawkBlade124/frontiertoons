<?php
global $twig;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
$error = $_GET['error'] ?? null;

if (!isset($twig)) {
    $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 2) . '/templates');
    $twig = new \Twig\Environment($loader, [
        'cache' => dirname(__DIR__, 2) . '/twig/cache',
        'debug' => true,
    ]);
    $twig->addExtension(new \Twig\Extension\DebugExtension());
}

try {
    echo $twig->render('registration.html', [
        'error' => $error,
        'csrf_token' => $_SESSION['csrf_token']
    ]);
} catch (Exception $e) {
    echo "Twig error: " . $e->getMessage();
}
