<?php
include 'session.php';

$isLoggedIn = isset($_SESSION['role']);
$isAdministrator = $isLoggedIn && ($_SESSION['role'] === 'admin');

if (!$isAdministrator) {
    header("Location: ../frontend/login.php");
    exit();
}

include 'db.php';

$successMessage = null;
$errorMessage   = null;

if (isset($_POST['update_status'])) {
    $inquiryId = $_POST['inquiry_id'];
    $newStatus = $_POST['status'];

    try {
        $updateStatusQuery = $pdo->prepare(
            "UPDATE inquiries SET status = ? WHERE id = ?"
        );
        $updateStatusQuery->execute([$newStatus, $inquiryId]);

        $successMessage = "Project status updated successfully!";
    } catch (PDOException $updateError) {
        $errorMessage = "Error updating status: " . $updateError->getMessage();
    }
}

try {
    $totalClients = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'client'")->fetchColumn();
    $totalInquiries = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
    $pendingInquiries = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status = 'Pending'")->fetchColumn();
    $completedInquiries = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status = 'Completed'")->fetchColumn();

    $inquiries = $pdo->query(
        "SELECT * FROM inquiries ORDER BY created_at DESC"
    )->fetchAll(PDO::FETCH_ASSOC);

    $clients = $pdo->query(
        "SELECT id, username, email, contact_no, created_at
         FROM users
         WHERE role = 'client'
         ORDER BY created_at DESC"
    )->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $queryError) {
    $errorMessage = "Database query error: " . $queryError->getMessage();
}
?>

<?php include '../frontend/includes/header.php'; ?>

<main class="page-content" style="max-width: 1200px; margin: 0 auto; padding: 20px;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div>
            <h2>Admin Command Center</h2>
            <p style="color: #6b7280;">
                Welcome back,
                <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>
                (Administrator)
            </p>
        </div>
        <a href="../frontend/logout.php"
           style="background: #dc2626; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">
            Logout
        </a>
    </div>

    <?php if ($successMessage !== null): ?>
        <div class="alert success" style="margin-bottom: 20px;">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage !== null): ?>
        <div class="alert error" style="margin-bottom: 20px;">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px;">

        <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 5px;">Total Registered Clients</p>
            <h3 style="font-size: 2rem; color: #1f2937; margin: 0;"><?php echo $totalClients; ?></h3>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 5px;">Total Project Inquiries</p>
            <h3 style="font-size: 2rem; color: #2563eb; margin: 0;"><?php echo $totalInquiries; ?></h3>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 5px;">Pending / In Progress</p>
            <h3 style="font-size: 2rem; color: #d97706; margin: 0;"><?php echo $pendingInquiries; ?></h3>
        </div>

        <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 5px;">Completed Projects</p>
            <h3 style="font-size: 2rem; color: #16a34a; margin: 0;"><?php echo $completedInquiries; ?></h3>
        </div>

    </div>

    <section style="margin-bottom: 50px;">

        <h3 style="margin-bottom: 15px; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
            Client Project Inquiries &amp; Status Control
        </h3>

        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
            <table class="admin-table" style="width: 100%; border-collapse: collapse; text-align: left;">

                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 12px;">ID</th>
                        <th style="padding: 12px;">Client</th>
                        <th style="padding: 12px;">Contact Info</th>
                        <th style="padding: 12px;">Service</th>
                        <th style="padding: 12px;">Message</th>
                        <th style="padding: 12px;">Status</th>
                        <th style="padding: 12px;">Payment</th>
                        <th style="padding: 12px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (count($inquiries) > 0): ?>
                    <?php foreach ($inquiries as $inquiry): ?>

                        <?php
                        $currentStatus = $inquiry['status'] ?? 'Pending';

                        if ($currentStatus === 'Completed') {
                            $badgeStyles = 'background: #dcfce7; color: #15803d;';
                        } elseif ($currentStatus === 'In Progress') {
                            $badgeStyles = 'background: #e0f2fe; color: #0369a1;';
                        } else {
                            $badgeStyles = 'background: #fef3c7; color: #b45309;';
                        }
                        ?>

                        <tr style="border-bottom: 1px solid #e5e7eb;">

                            <td style="padding: 12px;"><?php echo $inquiry['id']; ?></td>

                            <td style="padding: 12px; font-weight: 600;">
                                <?php echo htmlspecialchars($inquiry['client_name']); ?>
                            </td>

                            <td style="padding: 12px; font-size: 0.85rem; color: #4b5563;">
                                <?php echo htmlspecialchars($inquiry['client_email']); ?><br>
                                <?php echo htmlspecialchars($inquiry['contact_no'] ?? 'N/A'); ?>
                            </td>

                            <td style="padding: 12px;">
                                <?php echo htmlspecialchars($inquiry['service_type']); ?>
                            </td>

                            <td style="padding: 12px; max-width: 250px; font-size: 0.9rem;">
                                <?php echo htmlspecialchars($inquiry['message']); ?>
                            </td>

                            <td style="padding: 12px;">
                                <span style="padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; <?php echo $badgeStyles; ?>">
                                    <?php echo htmlspecialchars($currentStatus); ?>
                                </span>
                            </td>

                            <td style="padding: 12px; font-size: 0.85rem;">
                                <?php echo htmlspecialchars(($inquiry['payment_status'] ?? 'Unpaid') . ' (Rs. ' . ($inquiry['amount'] ?? 0) . ')'); ?>
                            </td>

                            <td style="padding: 12px;">
                                <form action="admin.php" method="POST" style="display: flex; gap: 5px; align-items: center;">

                                    <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">

                                    <select name="status" style="padding: 4px; font-size: 0.85rem; border-radius: 4px; border: 1px solid #d1d5db;">
                                        <option value="Pending"     <?php if ($currentStatus === 'Pending')     echo 'selected'; ?>>Pending</option>
                                        <option value="In Progress" <?php if ($currentStatus === 'In Progress') echo 'selected'; ?>>In Progress</option>
                                        <option value="Completed"   <?php if ($currentStatus === 'Completed')   echo 'selected'; ?>>Completed</option>
                                    </select>

                                    <button type="submit" name="update_status"
                                            style="background: #2563eb; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">
                                        Save
                                    </button>

                                </form>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px; color: #6b7280;">
                            No project inquiries found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </section>

    <section>

        <h3 style="margin-bottom: 15px; color: #1f2937; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
            Registered Client Directory
        </h3>

        <div style="overflow-x: auto; background: white; border-radius: 8px; border: 1px solid #e5e7eb;">
            <table class="admin-table" style="width: 100%; border-collapse: collapse; text-align: left;">

                <thead>
                    <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: 12px;">User ID</th>
                        <th style="padding: 12px;">Username</th>
                        <th style="padding: 12px;">Email Address</th>
                        <th style="padding: 12px;">Contact Phone</th>
                        <th style="padding: 12px;">Registered On</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (count($clients) > 0): ?>
                    <?php foreach ($clients as $client): ?>
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 12px;"><?php echo $client['id']; ?></td>
                            <td style="padding: 12px; font-weight: 600;"><?php echo htmlspecialchars($client['username']); ?></td>
                            <td style="padding: 12px;"><?php echo htmlspecialchars($client['email']); ?></td>
                            <td style="padding: 12px;"><?php echo htmlspecialchars($client['contact_no'] ?? 'N/A'); ?></td>
                            <td style="padding: 12px; color: #6b7280; font-size: 0.9rem;"><?php echo $client['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #6b7280;">
                            No registered clients found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </section>

</main>

<?php include '../frontend/includes/footer.php'; ?>