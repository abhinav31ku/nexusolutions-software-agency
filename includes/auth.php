<?php
require_once __DIR__ . '/session.php';

define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCK_MINUTES', 10);

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return is_logged_in() && ($_SESSION['role'] ?? '') === 'admin';
}

function current_user() {
    if (!is_logged_in()) {
        return null;
    }
    return [
        'id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'email' => $_SESSION['email'],
        'contact_no' => $_SESSION['contact_no'],
        'role' => $_SESSION['role'],
    ];
}

// Only these pages can be used in ?next= after login.
function safe_next($page) {
    $allowed = ['index.php', 'services.php', 'about.php', 'projects.php', 'contact.php', 'my_inquiries.php'];
    return in_array($page, $allowed, true) ? $page : 'index.php';
}

function require_login($next = 'index.php') {
    if (!is_logged_in()) {
        redirect('public/login.php?next=' . urlencode(safe_next($next)));
    }
}

function require_admin() {
    if (!is_admin()) {
        redirect('public/login.php');
    }
}

function log_in($user, $remember) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['contact_no'] = $user['contact_no'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['remember'] = $remember;
    $_SESSION['last_seen'] = time();
    unset($_SESSION['csrf_token']);
    if ($remember) {
        remember_cookie();
    }
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_check() {
    $sent = $_POST['csrf_token'] ?? '';
    return is_string($sent)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $sent);
}

// Failed logins are counted per username in the login_attempts table.
function attempt_name($username) {
    return substr(strtolower($username), 0, 100);
}

function login_locked($pdo, $username) {
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM login_attempts
         WHERE username = ? AND attempted_at > NOW() - INTERVAL ' . LOCK_MINUTES . ' MINUTE'
    );
    $stmt->execute([attempt_name($username)]);
    return $stmt->fetchColumn() >= MAX_LOGIN_ATTEMPTS;
}

function record_failed_login($pdo, $username) {
    $stmt = $pdo->prepare('INSERT INTO login_attempts (username, ip_address) VALUES (?, ?)');
    $stmt->execute([attempt_name($username), $_SERVER['REMOTE_ADDR'] ?? '']);
    $pdo->exec('DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 1 DAY');
}

function clear_failed_logins($pdo, $username) {
    $stmt = $pdo->prepare('DELETE FROM login_attempts WHERE username = ?');
    $stmt->execute([attempt_name($username)]);
}
