<?php
require_once __DIR__ . '/../includes/session.php';

$_SESSION = [];
setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => '/',
    'secure' => is_https(),
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_destroy();
redirect('public/index.php');
