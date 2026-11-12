<?php
// Opened on the phone after scanning the QR code. Demo only: the button marks the inquiry as paid.
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/pricing.php';

$token = isset($_GET['token']) && is_string($_GET['token']) ? $_GET['token'] : '';
$inquiry = false;
$done = false;
$error = '';

try {
    if ($token !== '') {
        $stmt = $pdo->prepare('SELECT id, service_type, amount, payment_status FROM inquiries WHERE payment_token = ?');
        $stmt->execute([$token]);
        $inquiry = $stmt->fetch();
    }

    if ($inquiry && $inquiry['payment_status'] === 'Paid') {
        $done = true;
    } elseif ($inquiry && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!csrf_check()) {
            $error = 'The page expired. Please reload and try again.';
        } else {
            $stmt = $pdo->prepare(
                "UPDATE inquiries SET payment_status = 'Paid', paid_at = NOW(), status = 'In Progress'
                 WHERE payment_token = ? AND payment_status = 'Unpaid'"
            );
            $stmt->execute([$token]);
            $done = true;
        }
    }
} catch (PDOException $e) {
    $error = db_error($e);
}

$page_title = 'Pay | Nexusolutions';
include __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="form-card pay-box">
      <?php if (!$inquiry): ?>
        <h1>Link not valid</h1>
        <p class="muted">This payment link is wrong or has expired.</p>
        <?php echo alert('error', $error); ?>
      <?php elseif ($done): ?>
        <h1>Payment received</h1>
        <?php echo alert('success', 'Thank you. Your payment for ' . $inquiry['service_type'] . ' was received. You can close this page.'); ?>
      <?php else: ?>
        <h1>Confirm payment</h1>
        <p class="muted"><?php echo e($inquiry['service_type']); ?>, inquiry #<?php echo (int) $inquiry['id']; ?></p>
        <p class="price"><?php echo format_price($inquiry['amount']); ?></p>
        <p class="demo-note">Demo payment. No real money is used.</p>
        <?php echo alert('error', $error); ?>
        <form method="post" action="pay_scan.php?token=<?php echo urlencode($token); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn btn-primary">Pay now</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
