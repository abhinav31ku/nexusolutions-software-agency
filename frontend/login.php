<?php
include '../backend/session.php';
include '../backend/db.php';

$errorMessage = "";

if (isset($_POST['login_btn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            $findUserQuery = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $findUserQuery->execute([$username, $username]);
            $foundUser = $findUserQuery->fetch(PDO::FETCH_ASSOC);

            $passwordMatches = $foundUser && (
                password_verify($password, $foundUser['password']) ||
                $password === $foundUser['password']
            );

            if ($passwordMatches) {
                session_regenerate_id(true);   // fresh session id after login
                $_SESSION['user_id'] = $foundUser['id'];
                $_SESSION['username'] = $foundUser['username'];
                $_SESSION['email'] = $foundUser['email'];
                $_SESSION['contact_no'] = $foundUser['contact_no'];
                $_SESSION['role'] = $foundUser['role'];

                if ($foundUser['role'] === 'admin') {
                    header("Location: ../backend/admin.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            } else {
                $errorMessage = "Invalid username or password!";
            }
        } catch (PDOException $loginError) {
            $errorMessage = "Database Error: " . $loginError->getMessage();
        }
    } else {
        $errorMessage = "Please fill in all fields.";
    }
}

$page_css = "login.css";
include 'includes/header.php';
?>

<main class="page-content">
    <div class="auth-card">
        <h2>User & Admin Login</h2>
        <p class="subtitle">Access your account or administrative dashboard.</p>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="auth-form">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit" name="login_btn" class="btn-primary full-width">Login</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>