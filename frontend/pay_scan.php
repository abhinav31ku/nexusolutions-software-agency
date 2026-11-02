<?php
// Opened on the PHONE after scanning the QR code. Demo only: pressing the button marks the inquiry as Paid.
include '../backend/db.php';

$token = $_GET['token'] ?? '';
$done = false;

$find = $pdo->prepare("SELECT id, service_type, amount, payment_status FROM inquiries WHERE payment_token = ?");
$find->execute([$token]);
$inquiry = ($token !== '') ? $find->fetch(PDO::FETCH_ASSOC) : false;

if ($inquiry && $inquiry['payment_status'] === 'Paid') { $done = true; }

if ($inquiry && isset($_POST['pay_now']) && !$done) {
    // Mark as paid and move the project forward to In Progress
    $pay = $pdo->prepare("UPDATE inquiries SET payment_status = 'Paid', paid_at = NOW(), status = 'In Progress'
                          WHERE payment_token = ? AND payment_status = 'Unpaid'");
    $pay->execute([$token]);
    $done = true;
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pay | Nexusolutions</title><link rel="stylesheet" href="css/style.css?v=4"></head>
<body><main class="login-page">
  <a href="index.php" class="logo">Nexu<span>solutions</span></a>
  <div class="login-box" style="text-align:center">
  <?php if (!$inquiry): ?>
    <h2>Link not valid</h2><p class="subtitle">This payment link is wrong or has expired.</p>
  <?php elseif ($done): ?>
    <h2>Payment successful</h2>
    <div class="alert success">Thank you! Your payment for <?php echo htmlspecialchars($inquiry['service_type']); ?> was received. You can close this page.</div>
  <?php else: ?>
    <h2>Confirm payment</h2>
    <p class="subtitle"><?php echo htmlspecialchars($inquiry['service_type']); ?> &middot; Inquiry #<?php echo $inquiry['id']; ?></p>
    <p style="font-size:1.8rem;font-weight:bold;color:#12263f;margin:10px 0">&#8377;<?php echo number_format($inquiry['amount'], 2); ?></p>
    <span class="demo-label">DEMO PAYMENT - no real money</span>
    <form method="POST"><button type="submit" name="pay_now" class="btn-primary">Pay now</button></form>
  <?php endif; ?>
  </div>
</main></body></html>
