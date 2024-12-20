<?php
session_start();
require_once '../../dbCfg.php';
require_once '../../Entity/users.php';
require_once '../../Controller/RegisteredUsers/SubscriptionController.php';

// Database connection
$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die("Cannot connect to server: " . $conn->connect_error);
}

// Subscription class instance
$subscription = new Subscription($conn);

// Retrieve the logged-in user's email
$userEmail = $_SESSION['email'];
$message = "";
$currentSubscription = $subscription->getUserSubscription($userEmail);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'subscribe') {
            $subscriptionType = $_POST['subscription_type'];
            $selectedPrice = $subscriptionType === 'Starter' ? 29 : 59;

            // Billing and subscription update
            $billingSuccessful = true; // Simulated success
            if ($billingSuccessful) {
                $response = $subscription->updateSubscription($userEmail, $subscriptionType);

                if ($response['success']) {
                    $message = "Thank you for subscribing to <strong>$subscriptionType</strong>!<br>Price: $$selectedPrice.";
                    $currentSubscription = $subscription->getUserSubscription($userEmail);
                } else {
                    $message = "Subscription failed: " . implode("<br>", $response['errors']);
                }
            } else {
                $message = "Billing process failed. Please try again.";
            }
        } elseif ($action === 'cancel') {
            // Cancel subscription
            if ($subscription->cancelSubscription($userEmail)) {
                $message = "Your subscription has been canceled successfully.";
                $currentSubscription = null;
            } else {
                $message = "Failed to cancel subscription. Please try again.";
            }
        } elseif ($action === 'change') {
            $subscriptionType = $_POST['subscription_type'];
            $selectedPrice = $subscriptionType === 'Starter' ? 29 : 59;

            // Change subscription plan
            $response = $subscription->updateSubscription($userEmail, $subscriptionType);

            if ($response['success']) {
                $message = "Your subscription has been updated to <strong>$subscriptionType</strong>!<br>Price: $$selectedPrice.";
                $currentSubscription = $subscription->getUserSubscription($userEmail);
            } else {
                $message = "Failed to change subscription: " . implode("<br>", $response['errors']);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Your Subscription</title>
    <link rel="stylesheet" href="../../css/subscription.css">
</head>
<body>
<div class="container">
    <h1>Manage Your Subscription</h1>

    <?php if ($currentSubscription): ?>
        <div class="message">
            <strong>Current Subscription Details:</strong>
            <br>Type: <strong><?= $currentSubscription['subscription'] ?></strong>
            <br>Start Date: <strong><?= $currentSubscription['startDate'] ?></strong>
            <br>Expire Date: <strong><?= $currentSubscription['expireDate'] ?></strong>
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="subscription_type">Subscription Plan</label>
                <select id="subscription_type" name="subscription_type">
                    <option value="Starter" <?= $currentSubscription['subscription'] === 'Starter' ? 'selected' : '' ?>>Starter ($29)</option>
                    <option value="Premium" <?= $currentSubscription['subscription'] === 'Premium' ? 'selected' : '' ?>>Premium ($59)</option>
                </select>
            </div>
            <button type="submit" name="action" value="change">Subscribe or Change Plan</button>
            <button type="submit" name="action" value="cancel" style="background-color: #DC3545;">Cancel Subscription</button>
            <button type="button" onclick="window.location.href='user_dashboard.php'" value="back" style="background-color:rgb(133, 133, 133);">Back to homepage </button>
        </form>
    <?php else: ?>
        <form method="POST">
            <div class="form-group">
                <label for="subscription_type">Choose a Subscription Plan</label>
                <select id="subscription_type" name="subscription_type">
                    <option value="Starter">Starter ($29)</option>
                    <option value="Premium">Premium ($59)</option>
                </select>
            </div>
            <button type="submit" name="action" value="subscribe">Subscribe Now</button>
            <button type="button" onclick="window.location.href='user_dashboard.php'" value="back" style="background-color:rgb(133, 133, 133);">Back to homepage </button>
        </form>
    <?php endif; ?>

    <!-- Display success or error message -->
    <?php if (!empty($message)) : ?>
        <div class="message <?= strpos($message, 'failed') !== false ? 'error' : '' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
