<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/pricing.php';
require_once __DIR__ . '/../includes/inquiries.php';

$error = '';
$service = post_value('service_type');
if ($service === '' && isset($_GET['service']) && is_string($_GET['service'])) {
    $service = $_GET['service'];
}
$message = post_value('message');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_logged_in()) {
        $error = 'Please log in to send an inquiry.';
    } elseif (!csrf_check()) {
        $error = 'The form expired. Please try again.';
    } elseif (!in_array($service, service_names(), true)) {
        $error = 'Please choose one of the listed services.';
    } elseif ($message === '') {
        $error = 'Please write a few lines about your project.';
    } elseif (mb_strlen($message) > MAX_MESSAGE_LENGTH) {
        $error = 'The message is too long. Please keep it under ' . MAX_MESSAGE_LENGTH . ' characters.';
    } else {
        try {
            if (count_unpaid($pdo, $_SESSION['user_id']) >= MAX_UNPAID) {
                $error = 'You already have ' . MAX_UNPAID . ' unpaid inquiries. Please pay for one before sending another.';
            } else {
                $id = create_inquiry($pdo, current_user(), $service, $message);
                redirect('public/payment.php?id=' . $id);
            }
        } catch (PDOException $e) {
            $error = db_error($e);
        }
    }
}

$page_title = 'Contact | Nexusolutions';
$page_desc = 'Send us an inquiry about your project.';
$active = 'contact';
include __DIR__ . '/../includes/header.php';
?>
<section class="page-title">
  <div class="container">
    <h1>Send an inquiry</h1>
    <p class="muted">Tell us what you need. You pay the demo amount right after sending.</p>
  </div>
</section>

<section class="section">
  <div class="container two-column">
    <div>
      <?php echo alert('error', $error); ?>

      <?php if (is_logged_in()): ?>
      <form method="post" action="contact.php" class="form-card">
        <?php echo csrf_field(); ?>
        <div class="form-row">
          <label for="service_type">Service</label>
          <select id="service_type" name="service_type" required>
            <?php foreach (service_prices() as $name => $price): ?>
            <option value="<?php echo e($name); ?>"<?php echo $name === $service ? ' selected' : ''; ?>>
              <?php echo e($name) . ' (' . format_price($price) . ')'; ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-row">
          <label for="message">Project details</label>
          <textarea id="message" name="message" rows="6" maxlength="<?php echo MAX_MESSAGE_LENGTH; ?>" required><?php echo e($message); ?></textarea>
          <p class="form-hint">Up to <?php echo MAX_MESSAGE_LENGTH; ?> characters.</p>
        </div>
        <button type="submit" class="btn btn-primary">Send inquiry</button>
      </form>
      <?php else: ?>
      <div class="form-card">
        <p>You need an account to send an inquiry, so we can show you its status later.</p>
        <p>
          <a href="login.php?next=contact.php" class="btn btn-primary">Log in</a>
          <a href="register.php" class="text-link">Create an account</a>
        </p>
      </div>
      <?php endif; ?>
    </div>

    <aside class="side-note">
      <h2>What happens next</h2>
      <p>After you send the form, a QR code appears. Scan it with a phone on the same Wi-Fi to pay the demo amount.</p>
      <p>Once it is paid the status changes to In Progress. You can follow it under My inquiries.</p>
      <p>You can have up to <?php echo MAX_UNPAID; ?> unpaid inquiries at a time.</p>
    </aside>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
