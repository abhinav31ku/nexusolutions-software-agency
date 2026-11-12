<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/pricing.php';
require_once __DIR__ . '/../includes/inquiries.php';

require_admin();

$error = '';
$total_clients = $total_inquiries = $open_inquiries = $completed_inquiries = 0;
$inquiries = [];
$clients = [];

try {
    $total_clients = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'client'")->fetchColumn();
    $total_inquiries = $pdo->query('SELECT COUNT(*) FROM inquiries')->fetchColumn();
    $open_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status IN ('Pending', 'In Progress')")->fetchColumn();
    $completed_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status = 'Completed'")->fetchColumn();

    $inquiries = $pdo->query('SELECT * FROM inquiries ORDER BY created_at DESC, id DESC')->fetchAll();
    $clients = $pdo->query("SELECT id, username, email, contact_no, created_at FROM users WHERE role = 'client' ORDER BY created_at DESC")->fetchAll();
} catch (PDOException $e) {
    $error = db_error($e);
}

$page_title = 'Admin | Nexusolutions';
include __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="admin-head">
      <div>
        <h1>Admin</h1>
        <p class="muted">Logged in as <?php echo e($_SESSION['username']); ?></p>
      </div>
      <a href="<?php echo url('public/logout.php'); ?>" class="btn btn-outline">Log out</a>
    </div>

    <?php show_flash(); ?>
    <?php echo alert('error', $error); ?>

    <dl class="stat-row">
      <div class="stat-item"><dt>Clients</dt><dd><?php echo (int) $total_clients; ?></dd></div>
      <div class="stat-item"><dt>Inquiries</dt><dd><?php echo (int) $total_inquiries; ?></dd></div>
      <div class="stat-item"><dt>Pending / In Progress</dt><dd><?php echo (int) $open_inquiries; ?></dd></div>
      <div class="stat-item"><dt>Completed</dt><dd><?php echo (int) $completed_inquiries; ?></dd></div>
    </dl>

    <h2>Inquiries</h2>
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Client</th>
            <th>Contact</th>
            <th>Service</th>
            <th>Message</th>
            <th>Status</th>
            <th>Payment</th>
            <th>Change status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($inquiries) === 0): ?>
          <tr><td colspan="8">No inquiries yet.</td></tr>
          <?php endif; ?>
          <?php foreach ($inquiries as $row): ?>
          <?php $is_paid = $row['payment_status'] === 'Paid'; ?>
          <tr>
            <td data-label="No."><?php echo (int) $row['id']; ?></td>
            <td data-label="Client"><?php echo e($row['client_name']); ?></td>
            <td data-label="Contact"><?php echo e($row['client_email']); ?><br><?php echo e($row['contact_no'] ?? '-'); ?></td>
            <td data-label="Service"><?php echo e($row['service_type']); ?></td>
            <td data-label="Message" class="message-cell"><?php echo e($row['message']); ?></td>
            <td data-label="Status"><span class="badge badge-<?php echo status_class($row['status']); ?>"><?php echo e($row['status']); ?></span></td>
            <td data-label="Payment">
              <span class="badge badge-<?php echo status_class($row['payment_status']); ?>"><?php echo e($row['payment_status']); ?></span>
              <?php echo format_price($row['amount']); ?>
            </td>
            <td data-label="Change status">
              <form method="post" action="update_status.php" class="status-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="inquiry_id" value="<?php echo (int) $row['id']; ?>">
                <label for="status-<?php echo (int) $row['id']; ?>" class="visually-hidden">Status for inquiry <?php echo (int) $row['id']; ?></label>
                <select id="status-<?php echo (int) $row['id']; ?>" name="status">
                  <?php foreach (inquiry_statuses() as $status): ?>
                  <option value="<?php echo e($status); ?>"<?php echo $status === $row['status'] ? ' selected' : ''; ?><?php echo ($status === 'Completed' && !$is_paid) ? ' disabled' : ''; ?>><?php echo e($status); ?></option>
                  <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-small btn-primary">Save</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="form-hint">An inquiry can only be marked Completed after it is paid.</p>

    <h2>Clients</h2>
    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Registered</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($clients) === 0): ?>
          <tr><td colspan="5">No clients yet.</td></tr>
          <?php endif; ?>
          <?php foreach ($clients as $client): ?>
          <tr>
            <td data-label="No."><?php echo (int) $client['id']; ?></td>
            <td data-label="Username"><?php echo e($client['username']); ?></td>
            <td data-label="Email"><?php echo e($client['email']); ?></td>
            <td data-label="Phone"><?php echo e($client['contact_no'] ?? '-'); ?></td>
            <td data-label="Registered"><?php echo e(date('d M Y', strtotime($client['created_at']))); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
