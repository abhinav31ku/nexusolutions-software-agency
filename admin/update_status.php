<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/inquiries.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/index.php');
}

$inquiry_id = (int) post_value('inquiry_id');
$status = post_value('status');

if (!csrf_check()) {
    set_flash('error', 'The form expired. Please try again.');
} elseif ($inquiry_id < 1 || !in_array($status, inquiry_statuses(), true)) {
    set_flash('error', 'Invalid inquiry or status.');
} else {
    try {
        $stmt = $pdo->prepare('SELECT payment_status FROM inquiries WHERE id = ?');
        $stmt->execute([$inquiry_id]);
        $row = $stmt->fetch();

        if (!$row) {
            set_flash('error', 'Inquiry not found.');
        } elseif ($status === 'Completed' && $row['payment_status'] !== 'Paid') {
            set_flash('error', 'Inquiry #' . $inquiry_id . ' is not paid yet, so it cannot be marked Completed.');
        } else {
            $stmt = $pdo->prepare('UPDATE inquiries SET status = ? WHERE id = ?');
            $stmt->execute([$status, $inquiry_id]);
            set_flash('success', 'Inquiry #' . $inquiry_id . ' is now ' . $status . '.');
        }
    } catch (PDOException $e) {
        set_flash('error', db_error($e));
    }
}

redirect('admin/index.php');
