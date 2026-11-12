<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/pricing.php';
require_once __DIR__ . '/../includes/inquiries.php';

require_login('my_inquiries.php');

try {
    $inquiry = find_inquiry($pdo, (int) ($_GET['id'] ?? 0), $_SESSION['user_id']);
} catch (PDOException $e) {
    db_error($e);
    exit('Something went wrong. Please try again.');
}

if (!$inquiry) {
    http_response_code(404);
    exit('Inquiry not found.');
}

$is_paid = $inquiry['payment_status'] === 'Paid';
$scan_url = build_scan_url($inquiry['payment_token']);

$page_title = 'Payment | Nexusolutions';
include __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="form-card pay-box">
      <h1>Pay for your inquiry</h1>
      <p class="muted"><?php echo e($inquiry['service_type']); ?>, inquiry #<?php echo (int) $inquiry['id']; ?></p>
      <p class="price"><?php echo format_price($inquiry['amount']); ?></p>
      <p class="demo-note">Demo payment. No real money is used.</p>

      <?php if ($is_paid): ?>
        <?php echo alert('success', 'Payment received. Your inquiry is now In Progress.'); ?>
        <p><a href="my_inquiries.php" class="btn btn-primary">My inquiries</a></p>
      <?php else: ?>
        <div id="pay-area">
          <p>Scan this code with your phone camera. The phone must be on the same Wi-Fi as this computer.</p>
          <div id="qr-box" class="qr-box" data-url="<?php echo e($scan_url); ?>" data-id="<?php echo (int) $inquiry['id']; ?>"></div>
          <p id="pay-state" class="muted">Waiting for payment...</p>
          <p class="form-hint">No phone? <a href="<?php echo e($scan_url); ?>" target="_blank" rel="noopener" class="text-link">Open the pay page here</a>.</p>
        </div>
        <div id="paid-area" hidden>
          <?php echo alert('success', 'Payment received. Your inquiry is now In Progress.'); ?>
          <p><a href="my_inquiries.php" class="btn btn-primary">My inquiries</a></p>
        </div>
        <script src="<?php echo url('assets/js/qrcode.js'); ?>?v=<?php echo $asset_version; ?>"></script>
        <script src="<?php echo url('assets/js/payment.js'); ?>?v=<?php echo $asset_version; ?>"></script>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
