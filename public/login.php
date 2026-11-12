<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

$next = safe_next($_POST['next'] ?? $_GET['next'] ?? '');

if (is_logged_in()) {
    redirect(is_admin() ? 'admin/index.php' : 'public/' . $next);
}

$error = '';
$username = post_value('username');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = post_value('password', false);

    if (!csrf_check()) {
        $error = 'The form expired. Please try again.';
    } elseif ($username === '' || $password === '') {
        $error = 'Please fill in both fields.';
    } else {
        try {
            if (login_locked($pdo, $username)) {
                $error = 'Too many failed attempts. Please try again in ' . LOCK_MINUTES . ' minutes.';
            } else {
                $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
                $stmt->execute([$username, $username]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    clear_failed_logins($pdo, $username);
                    log_in($user, !empty($_POST['remember']));
                    redirect($user['role'] === 'admin' ? 'admin/index.php' : 'public/' . $next);
                }

                record_failed_login($pdo, $username);
                $error = 'Wrong username or password.';
            }
        } catch (PDOException $e) {
            $error = db_error($e);
        }
    }
}

$page_title = 'Log in | Nexusolutions';
include __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="form-card">
      <h1>Log in</h1>
      <?php show_flash(); ?>
      <?php echo alert('error', $error); ?>

      <form method="post" action="login.php" id="login-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="next" value="<?php echo e($next); ?>">

        <div class="form-row">
          <label for="username">Username or email</label>
          <input type="text" id="username" name="username" value="<?php echo e($username); ?>" autocomplete="username" required>
          <p class="form-error" id="username-error"></p>
        </div>

        <div class="form-row">
          <label for="password">Password</label>
          <div class="password-field">
            <input type="password" id="password" name="password" autocomplete="current-password" required>
            <button type="button" class="show-password" data-target="password" hidden>Show</button>
          </div>
          <p class="form-error" id="password-error"></p>
        </div>

        <div class="form-check">
          <input type="checkbox" id="remember" name="remember" value="1">
          <label for="remember">Keep me logged in for 30 days</label>
        </div>

        <button type="submit" class="btn btn-primary">Log in</button>
      </form>

      <p class="form-footer">No account yet? <a href="register.php" class="text-link">Create one</a></p>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
