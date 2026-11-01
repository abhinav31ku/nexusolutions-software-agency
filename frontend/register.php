<?php
session_start();
include '../backend/db.php';

$successMessage = "";
$errorMessage   = "";

if (isset($_POST['register_btn'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $contactNo = trim($_POST['contact_no']);
    $password = trim($_POST['password']);
    $role = 'client';

    if (!empty($username) && !empty($email) && !empty($contactNo) && !empty($password)) {
        try {
            $findExistingQuery = $pdo->prepare(
                "SELECT id FROM users WHERE username = ? OR email = ?"
            );
            $findExistingQuery->execute([$username, $email]);

            if ($findExistingQuery->rowCount() > 0) {
                $errorMessage = "Username or Email is already registered.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insertUserQuery = $pdo->prepare(
                    "INSERT INTO users (username, email, contact_no, password, role)
                     VALUES (?, ?, ?, ?, ?)"
                );
                $insertUserQuery->execute([
                    $username,
                    $email,
                    $contactNo,
                    $hashedPassword,
                    $role
                ]);

                $successMessage = "Registration successful! You can now <a href='login.php'>Login here</a>.";
            }
        } catch (PDOException $registerError) {
            $errorMessage = "Database Error: " . $registerError->getMessage();
        }
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}

$page_css = "register.css";
include 'includes/header.php';
?>

<main class="page-content">
    <div class="auth-card">
        <h2>Create Client Account</h2>
        <p class="subtitle">Sign up once to access all agency services.</p>

        <?php if (!empty($successMessage)): ?>
            <div class="alert success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST" class="auth-form">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email Address:</label>
            <input type="email" name="email" required>

            <label>Contact Phone Number:</label>
            <input type="tel" name="contact_no" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit" name="register_btn" class="btn-primary full-width">Register</button>
        </form>

        <p class="auth-footer-text">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </div>
</main>

<?php include 'includes/footer.php'; ?>