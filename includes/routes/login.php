<?php
global $twig;

try {
    echo $twig->render('login.html', ['title' => 'Login']);
} catch (Exception $e) {
    echo "Twig error: " . $e->getMessage();
}
