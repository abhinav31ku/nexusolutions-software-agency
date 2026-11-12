<?php
require_once __DIR__ . '/../config/config.php';

define('IDLE_LIMIT', 2 * 60 * 60);
define('REMEMBER_TIME', 30 * 24 * 60 * 60);

function is_https() {
    return !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
}

// PHP only gives a session cookie, so for "remember me" we set a longer one ourselves.
function remember_cookie() {
    if (headers_sent()) {
        return;
    }
    setcookie(session_name(), session_id(), [
        'expires' => time() + REMEMBER_TIME,
        'path' => '/',
        'secure' => is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

if (session_status() === PHP_SESSION_NONE) {
    // own folder so the server's temp cleanup does not delete our sessions
    $session_dir = __DIR__ . '/../sessions';
    if (!is_dir($session_dir)) {
        mkdir($session_dir, 0700, true);
        file_put_contents($session_dir . '/.htaccess', "Require all denied\n");
    }
    if (is_writable($session_dir)) {
        session_save_path($session_dir);
    }

    ini_set('session.gc_maxlifetime', (string) REMEMBER_TIME);
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Normal logins end after 2 hours without activity, "remember me" ones keep going.
if (isset($_SESSION['user_id'])) {
    $remember = !empty($_SESSION['remember']);
    if (!$remember && time() - ($_SESSION['last_seen'] ?? time()) > IDLE_LIMIT) {
        $_SESSION = [];
    } else {
        $_SESSION['last_seen'] = time();
        if ($remember) {
            remember_cookie();
        }
    }
}

// Web path of a file in the project, built from BASE_URL (not from the request).
function url($path) {
    $base_path = parse_url(BASE_URL, PHP_URL_PATH) ?: '';
    return rtrim($base_path, '/') . '/' . ltrim($path, '/');
}

function e($text) {
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

// Read a text field from POST. Passwords are read with $trim = false.
function post_value($name, $trim = true) {
    $value = $_POST[$name] ?? '';
    if (!is_string($value)) {
        return '';
    }
    return $trim ? trim($value) : $value;
}

function alert($type, $message) {
    if ($message === '' || $message === null) {
        return '';
    }
    return '<div class="alert alert-' . e($type) . '" role="alert">' . e($message) . '</div>';
}

function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function show_flash() {
    if (!empty($_SESSION['flash'])) {
        echo alert($_SESSION['flash']['type'], $_SESSION['flash']['message']);
        unset($_SESSION['flash']);
    }
}
