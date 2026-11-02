<?php
// Shows the QR code and waits until the phone pays.
include '../backend/session.php';
include '../backend/db.php';
include 'includes/pricing.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.html"); exit(); }

$inquiryId = (int)($_GET['id'] ?? 0);
$find = $pdo->prepare("SELECT * FROM inquiries WHERE id = ? AND client_email = ?");
$find->execute([$inquiryId, $_SESSION['email']]);
$inquiry = $find->fetch(PDO::FETCH_ASSOC);
if (!$inquiry) { http_response_code(404); die("Inquiry not found."); }

$isPaid = ($inquiry['payment_status'] === 'Paid');
$scanUrl = build_scan_url($inquiry['payment_token']);
include 'includes/header.php';
?>
<div class="page-content">
  <div class="booking-container" style="text-align:center">
    <h2>Pay for your inquiry</h2>
    <p class="subtitle"><?php echo htmlspecialchars($inquiry['service_type']); ?> &middot; Inquiry #<?php echo $inquiry['id']; ?></p>
    <p style="font-size:1.8rem;font-weight:bold;color:#12263f;margin:10px 0">&#8377;<?php echo number_format($inquiry['amount'], 2); ?></p>
    <span class="demo-label">DEMO PAYMENT - no real money</span>

    <?php if ($isPaid): ?>
      <div class="alert success">Payment received. Your project is now In Progress.</div>
      <a href="index.php" class="btn-primary">Back to home</a>
    <?php else: ?>
      <div id="pay-area">
        <p style="margin:16px 0 8px">Scan this QR code with your phone camera.<br>Your phone must be on the same Wi-Fi as this computer.</p>
        <div id="qr-box" class="qr-box" data-url="<?php echo htmlspecialchars($scanUrl); ?>" data-id="<?php echo $inquiry['id']; ?>"></div>
        <p id="pay-state" class="subtitle">Waiting for payment...</p>
        <p class="small-text">No phone? <a href="<?php echo htmlspecialchars($scanUrl); ?>" target="_blank">Open the pay page here</a></p>
      </div>
      <div id="paid-area" style="display:none">
        <div class="alert success">Payment received! Your project is now In Progress.</div>
        <a href="index.php" class="btn-primary">Back to home</a>
      </div>
      <script src="js/qrcode.js"></script>
      <script src="js/payment.js"></script>
    <?php endif; ?>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
