<?php
// Answers {"status":"Paid"} or {"status":"Unpaid"} for the owner of the inquiry.
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/inquiries.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    echo json_encode(['status' => 'Unknown']);
    exit;
}

try {
    $inquiry = find_inquiry($pdo, (int) ($_GET['id'] ?? 0), $_SESSION['user_id']);
} catch (PDOException $e) {
    db_error($e);
    $inquiry = false;
}

echo json_encode(['status' => $inquiry ? $inquiry['payment_status'] : 'Unknown']);
