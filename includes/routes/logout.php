<?php
// logout.php
session_start();
session_unset();
session_destroy();
header("Location: /login?message=logged_out");
exit;
?>