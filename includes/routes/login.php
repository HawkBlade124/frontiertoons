<?php
global $twig;
$error = $_GET['error'] ?? null;

try {
    echo $twig->render('login.html', ['error' => $error]);
} catch (Exception $e) {
    echo "Twig error: " . $e->getMessage();
}
