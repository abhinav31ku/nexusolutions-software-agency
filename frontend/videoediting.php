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
        $serviceType = "Video Editing";
        $projectMessage = trim($_POST['message']);

        if (!empty($projectMessage)) {
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
            $errorMessage = "Please enter your video project details.";
        }
    }
}

$page_css = "videoediting.css";
include 'includes/header.php';
?>

<main class="page-content">
    <div class="service-header">
        <h1>Professional Video Editing</h1>
        <p class="subtitle">Engaging promotional clips, dynamic YouTube content, and cinematic cuts.</p>
    </div>

    <div class="service-details">
        <h3>What's Included:</h3>
        <ul class="feature-list">
            <li>Cuts, Transitions, & Color Grading</li>
            <li>Dynamic Subtitles & Motion Graphics</li>
            <li>Background Audio Mixing & Sound Effects</li>
            <li>Optimized Formats for YouTube, Reels, or TikTok</li>
        </ul>
    </div>

    <div class="booking-container">
        <h3>Book Video Editing Service</h3>

        <?php if (!empty($successMessage)): ?>
            <div class="alert success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-badge">
                Booking as: <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>
            </div>

            <form action="videoediting.php" method="POST" class="service-form">
                <label>Project Details / Video Length:</label>
                <textarea name="message" rows="4" placeholder="Describe raw footage length, style references, final format..." required></textarea>
                <button type="submit" name="submit_inquiry" class="btn-primary">Request Video Editing</button>
            </form>
        <?php else: ?>
            <div class="auth-prompt">
                <p>You must be logged in to book this service.</p>
                <a href="login.php" class="btn-primary">Login to Book</a>
                <a href="register.php" class="link-secondary">Create Account</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>