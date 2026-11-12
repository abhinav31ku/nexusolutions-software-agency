<?php
require_once __DIR__ . '/pricing.php';

define('MAX_MESSAGE_LENGTH', 2000);
define('MAX_UNPAID', 3);

function inquiry_statuses() {
    return ['Pending', 'In Progress', 'Completed'];
}

// "In Progress" -> "in-progress", used as a css class
function status_class($text) {
    return strtolower(str_replace(' ', '-', $text));
}

function count_unpaid($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM inquiries WHERE user_id = ? AND payment_status = 'Unpaid'");
    $stmt->execute([$user_id]);
    return (int) $stmt->fetchColumn();
}

function create_inquiry($pdo, $user, $service, $message) {
    $stmt = $pdo->prepare(
        'INSERT INTO inquiries (user_id, client_name, client_email, contact_no, service_type, message, amount, payment_token)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([
        $user['id'],
        $user['username'],
        $user['email'],
        $user['contact_no'],
        $service,
        $message,
        service_price($service),
        bin2hex(random_bytes(16)),
    ]);
    return $pdo->lastInsertId();
}

function find_inquiry($pdo, $id, $user_id) {
    $stmt = $pdo->prepare('SELECT * FROM inquiries WHERE id = ? AND user_id = ?');
    $stmt->execute([$id, $user_id]);
    return $stmt->fetch();
}

function get_inquiries($pdo, $user_id) {
    $stmt = $pdo->prepare('SELECT * FROM inquiries WHERE user_id = ? ORDER BY created_at DESC, id DESC');
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}
