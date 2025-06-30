<?php
global $twig;

try {
    echo $twig->render('404.html', ['title' => '404']);
} catch (Exception $e) {
    echo "Twig error: " . $e->getMessage();
}
