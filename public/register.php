<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

if (is_logged_in()) {
    redirect('public/index.php');
}

$error = '';
$username = post_value('username');
$email = post_value('email');
$contact_no = post_value('contact_no');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = post_value('password', false);
    $phone_digits = preg_replace('/[\s-]/', '', $contact_no);

    if (!csrf_check()) {
        $error = 'The form expired. Please try again.';
    } elseif ($username === '' || $email === '' || $contact_no === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } elseif (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $username)) {
        $error = 'Username must be 3 to 50 characters: letters, numbers, dot, dash or underscore.';
    } elseif (strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($contact_no) > 20 || !preg_match('/^\+?[0-9]{8,15}$/', $phone_digits)) {
        $error = 'Please enter a valid phone number (8 to 15 digits, a leading + is fine).';
    } elseif (mb_strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif (strlen($password) > 72) {
        $error = 'Password can be at most 72 bytes long.';
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users (username, email, contact_no, password, role) VALUES (?, ?, ?, ?, 'client')"
            );
            $stmt->execute([$username, $email, $contact_no, password_hash($password, PASSWORD_DEFAULT)]);

            set_flash('success', 'Account created. You can log in now.');
            redirect('public/login.php');
        } catch (PDOException $e) {
            // 1062 = duplicate username or email
            if (($e->errorInfo[1] ?? 0) == 1062) {
                $error = 'That username or email is already registered.';
            } else {
                $error = db_error($e);
            }
        }
    }
}

$page_title = 'Create account | Nexusolutions';
include __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="form-card">
      <h1>Create account</h1>
      <?php echo alert('error', $error); ?>

      <form method="post" action="register.php" id="register-form">
        <?php echo csrf_field(); ?>

        <div class="form-row">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" value="<?php echo e($username); ?>" autocomplete="username" maxlength="50" required>
        </div>

        <div class="form-row">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?php echo e($email); ?>" autocomplete="email" maxlength="100" required>
        </div>

        <div class="form-row">
          <label for="contact_no">Phone number</label>
          <input type="tel" id="contact_no" name="contact_no" value="<?php echo e($contact_no); ?>" autocomplete="tel" maxlength="20" required>
        </div>

        <div class="form-row">
          <label for="password">Password</label>
          <div class="password-field">
            <input type="password" id="password" name="password" autocomplete="new-password" minlength="8" required>
            <button type="button" class="show-password" data-target="password" hidden>Show</button>
          </div>
          <p class="form-hint">At least 8 characters.</p>
        </div>

        <button type="submit" class="btn btn-primary">Create account</button>
      </form>

      <p class="form-footer">Already have an account? <a href="login.php" class="text-link">Log in</a></p>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
