<?php
// Starts the session for EVERY page, so all pages use the same settings.
// The user stays logged in for 30 days, until they click Logout.
$sessionLifetime = 60 * 60 * 24 * 30;

if (session_status() === PHP_SESSION_NONE) {
    // Keep our own session files in backend/sessions/ so other programs
    // (and their cleanup jobs) cannot delete them after a few minutes.
    $sessionFolder = __DIR__ . '/sessions';
    if (!is_dir($sessionFolder)) { @mkdir($sessionFolder, 0777, true); }
    if (is_dir($sessionFolder) && is_writable($sessionFolder)) { session_save_path($sessionFolder); }

    ini_set('session.gc_maxlifetime', (string)$sessionLifetime);   // keep data for 30 days
    session_set_cookie_params([
        'lifetime' => $sessionLifetime,   // cookie survives closing the browser
        'path'     => '/',                // same cookie on every page
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
