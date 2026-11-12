<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/pricing.php';
require_once __DIR__ . '/../includes/inquiries.php';

require_login('my_inquiries.php');

$error = '';
$inquiries = [];
try {
    $inquiries = get_inquiries($pdo, $_SESSION['user_id']);
} catch (PDOException $e) {
    $error = db_error($e);
}

$page_title = 'My inquiries | Nexusolutions';
include __DIR__ . '/../includes/header.php';
?>
<section class="page-title">
  <div class="container">
    <h1>My inquiries</h1>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php show_flash(); ?>
    <?php echo alert('error', $error); ?>

    <?php if (count($inquiries) === 0): ?>
      <p>You have not sent any inquiries yet. <a href="contact.php" class="text-link">Send one now</a>.</p>
    <?php else: ?>
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Service</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Sent on</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($inquiries as $row): ?>
          <tr>
            <td data-label="No."><?php echo (int) $row['id']; ?></td>
            <td data-label="Service"><?php echo e($row['service_type']); ?></td>
            <td data-label="Amount"><?php echo format_price($row['amount']); ?></td>
            <td data-label="Status"><span class="badge badge-<?php echo status_class($row['status']); ?>"><?php echo e($row['status']); ?></span></td>
            <td data-label="Payment"><span class="badge badge-<?php echo status_class($row['payment_status']); ?>"><?php echo e($row['payment_status']); ?></span></td>
            <td data-label="Sent on"><?php echo e(date('d M Y', strtotime($row['created_at']))); ?></td>
            <td data-label="">
              <?php if ($row['payment_status'] === 'Unpaid'): ?>
                <a href="payment.php?id=<?php echo (int) $row['id']; ?>" class="btn btn-small btn-primary">Pay now</a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
