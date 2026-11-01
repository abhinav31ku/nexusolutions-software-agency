<?php
session_start();
include '../backend/db.php';
include 'includes/pricing.php';

$successMessage = "";
$errorMessage   = "";

if (isset($_POST['submit_inquiry'])) {
    if (!isset($_SESSION['user_id'])) {
        $errorMessage = "You must be logged in to submit an inquiry.";
    } else {
        $clientName = $_SESSION['username'];
        $clientEmail = $_SESSION['email'];
        $clientContact = $_SESSION['contact_no'];
        $serviceType = trim($_POST['service_type']);
        $projectMessage = trim($_POST['message']);

        if (!empty($serviceType) && !empty($projectMessage)) {
            try {
                $insertInquiryQuery = $pdo->prepare(
                    "INSERT INTO inquiries (client_name, client_email, contact_no, service_type, message, amount, payment_token)
                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                $insertInquiryQuery->execute([
                    $clientName,
                    $clientEmail,
                    $clientContact,
                    $serviceType,
                    $projectMessage,
                    service_price($serviceType),
                    bin2hex(random_bytes(16))
                ]);

                // Go to the payment page (QR code)
                header("Location: payment.php?id=" . $pdo->lastInsertId());
                exit();
            } catch (PDOException $insertError) {
                $errorMessage = "Database error: " . $insertError->getMessage();
            }
        } else {
            $errorMessage = "Please fill in all required fields.";
        }
    }
}

$page_css = "contact.css";
include 'includes/header.php';
?>

<main class="page-content">
    <div class="contact-header">
        <h1>General Service Inquiry</h1>
        <p class="subtitle">Have a custom project in mind? Submit your requirements below.</p>
    </div>

    <?php if (!empty($successMessage)): ?>
        <div class="alert success"><?php echo $successMessage; ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="alert error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <div class="contact-container">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-badge">
                Logged in as: <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>
            </div>

            <form action="contact.php" method="POST" class="contact-form">
                <label>Select Service:</label>
                <select name="service_type" required>
                    <option value="Logo Design">Logo Design</option>
                    <option value="Web Development">Web Development</option>
                    <option value="Video Editing">Video Editing</option>
                    <option value="General Consultation">General Consultation</option>
                </select>

                <label>Project Details / Message:</label>
                <textarea name="message" rows="5" placeholder="Describe your project requirements..." required></textarea>

                <button type="submit" name="submit_inquiry" class="btn-primary">Submit Inquiry</button>
            </form>
        <?php else: ?>
            <div class="auth-prompt">
                <p>You must be logged in to submit a project inquiry.</p>
                <a href="login.php" class="btn-primary">Login to Continue</a>
                <a href="register.php" class="link-secondary">Create an Account</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>