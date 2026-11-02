<?php
// Ends the session completely and goes back to the home page.
include '../backend/session.php';

$_SESSION = [];                                   // empty the session data
if (ini_get('session.use_cookies')) {             // delete the session cookie in the browser
    $cookie = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);
}
session_destroy();                                // delete the session on the server
header("Location: index.php");
exit();
?>
