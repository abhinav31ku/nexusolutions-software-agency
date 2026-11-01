<?php
// Returns {"status":"Paid"} or {"status":"Unpaid"} for the logged-in owner of the inquiry.
session_start();
include '../backend/db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['email'])) { echo json_encode(['status' => 'Unknown']); exit(); }

$find = $pdo->prepare("SELECT payment_status FROM inquiries WHERE id = ? AND client_email = ?");
$find->execute([(int)($_GET['id'] ?? 0), $_SESSION['email']]);
$row = $find->fetch(PDO::FETCH_ASSOC);
echo json_encode(['status' => $row ? $row['payment_status'] : 'Unknown']);
