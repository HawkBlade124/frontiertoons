<?php
global $twig;
$error = $_GET['error'] ?? null;


try {
    echo $twig->render('login.html', [
        'error' => $error,
        'csrf_token' => $_SESSION['csrf_token']
    ]);
} catch (Exception $e) {
    echo "Twig error: " . $e->getMessage();
}
