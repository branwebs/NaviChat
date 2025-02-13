<?php
session_start();
require_once '../../dbCfg.php';
require_once '../../Entity/users.php';
require_once '../../Controller/RegisteredUsers/SubscriptionController.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../Users/userLogin.php');
    exit;
}

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
            $cardNumber = $_POST['card_number'];
            $expiry = $_POST['expiry'];
            $cvv = $_POST['cvv'];

            $response = $subscription->updateSubscription($userEmail, $cardNumber, $expiry, $cvv);

            if ($response['success']) {
                $message = "Thank you for subscribing! Your subscription price is $59.";
                $currentSubscription = $subscription->getUserSubscription($userEmail);
            } else {
                $message = "Subscription failed: " . implode("<br>", $response['errors']);
            }
        } elseif ($action === 'cancel') {
            if ($subscription->cancelSubscription($userEmail)) {
                $message = "Your subscription has been canceled successfully.";
                $currentSubscription = null;
            } else {
                $message = "Failed to cancel subscription. Please try again.";
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

    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/subscription.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap scripts-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
</head>
<body>
    <div class="sidebar">
        <a href="user_dashboard.php" class="menu-item">Analytics</a>
        <a href="installationGuide.php" class="menu-item" >Installation Guide</a>
        <a href="viewProfile.php" class="menu-item">Profile</a>
        <a href="#" class="menu-item active" data-section="subscription">Subscription</a>
        <a href="../../index.php" class="logout-btn">Logout</a>
    </div>

    <div id="subscription" class="section active">
        <div class="container">
            <h1>Manage Your Subscription</h1>

            <?php if ($currentSubscription && $currentSubscription['subscription']): ?>
                <div class="message">
                    <strong>Current Subscription:</strong> $<?= $currentSubscription['subscription'] ?><br>
                    <strong>Start Date:</strong> <?= $currentSubscription['startDate'] ?><br>
                    <strong>Expire Date:</strong> <?= $currentSubscription['expireDate'] ?>
                </div>

                <form method="POST">
                    <button type="submit" name="action" value="cancel" style="background-color: #DC3545;">Cancel Subscription</button>
                </form>

            <?php else: ?>
                <p>You do not have an active subscription.</p>
                <form method="POST" id="subscriptionForm">
                    <p>Your subscription price is $59.</p>
                    <button type="button" onclick="showPaymentForm()" style="background-color: #007BFF;">Subscribe Now</button>
                </form>

                <!-- Payment Form (Hidden by default) -->
                <div id="paymentForm" style="display: none;" class="payment-form">
                    <h3>Payment Details</h3>
                    <form method="POST" onsubmit="return validatePaymentForm()">
                        <input type="hidden" name="action" value="subscribe">
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" name="card_number" maxlength="16" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Expiry Date</label>
                                <input type="text" name="expiry" placeholder="MM/YY" maxlength="5" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>CVV</label>
                                <input type="text" name="cvv" maxlength="3" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" style="background-color: #28a745;">Process Payment</button>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Display success or error message -->
            <?php if (!empty($message)) : ?>
                <div class="message <?= strpos($message, 'failed') !== false ? 'error' : '' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showPaymentForm() {
            document.getElementById('subscriptionForm').style.display = 'none';
            document.getElementById('paymentForm').style.display = 'block';
        }

        function validatePaymentForm() {
            const cardNumber = document.querySelector('input[name="card_number"]').value;
            const expiry = document.querySelector('input[name="expiry"]').value;
            const cvv = document.querySelector('input[name="cvv"]').value;

            if (!/^\d{16}$/.test(cardNumber)) {
                alert('Please enter a valid 16-digit card number');
                return false;
            }

            if (!/^\d{2}\/\d{2}$/.test(expiry)) {
                alert('Please enter expiry date in MM/YY format');
                return false;
            }

            if (!/^\d{3}$/.test(cvv)) {
                alert('Please enter a valid 3-digit CVV');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
