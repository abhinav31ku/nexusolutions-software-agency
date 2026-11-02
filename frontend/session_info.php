<?php
// Tells the HTML pages if someone is logged in, so the menu can show the Profile button.
include __DIR__ . '/../backend/session.php';
header('Content-Type: application/json');
header('Cache-Control: no-store');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['loggedIn' => false]);
    exit();
}
echo json_encode([
    'loggedIn' => true,
    'username' => $_SESSION['username'] ?? '',
    'email'    => $_SESSION['email'] ?? '',
    'role'     => $_SESSION['role'] ?? 'client'
]);
