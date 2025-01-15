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
            $subscriptionType = $_POST['subscription_type'];
            $cardNumber = $_POST['card_number'];
            $expiry = $_POST['expiry'];
            $cvv = $_POST['cvv'];
            $selectedPrice = $subscriptionType === 'Starter' ? 29 : 59;

            $response = $subscription->updateSubscription($userEmail, $subscriptionType, $cardNumber, $expiry, $cvv);

            if ($response['success']) {
                $message = "Thank you for subscribing to <strong>$subscriptionType</strong>!<br>Price: $$selectedPrice.";
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
        } elseif ($action === 'renew') {
            $cardNumber = $_POST['card_number'];
            $expiry = $_POST['expiry'];
            $cvv = $_POST['cvv'];

            $response = $subscription->renewSubscription($userEmail, $cardNumber, $expiry, $cvv);

            if ($response['success']) {
                $message = "Your subscription has been renewed successfully!";
                $currentSubscription = $subscription->getUserSubscription($userEmail);
            } else {
                $message = "Failed to renew subscription: " . implode("<br>", $response['errors']);
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

    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/userDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&family=Ubuntu:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <!-- CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e3ffb3fff0.js" crossorigin="anonymous"></script>

    <!-- Bootstrap scripts-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>
<div class="header">
            <h1>NaviChat</h1>
            <a class="logout" href="../RegisteredUser/logoutConfirmation.php" >
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </a>
            
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="sidebar">
                <ul>
                    <li><a href="#">Manage Tickets</a></li>
                    <li>
                        <a href="#">Configure Chatbot &#9662;</a>
                        <ul class="dropdown">
                            <li><a href="answerTemplates.php">Manage Answer Templates</a></li>
                            <li><a href="#">Installation Guide</a></li>
                            <li><a href="#">Select Industry</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Live Chat</a></li>
                    <li><a href="#">Trends</a></li>
                    <li><a href="#">Analytics</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="viewProfile.php" >Profile</a></li>
                    <li><a href="subscription.php">Subscription</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-9"> 
            <div class="row">
                <div class='col-sm-2'> </div>
                <div class='col-sm-9'>
                    <div class="container">
                        <h1>Manage Your Subscription</h1>

                        <?php if ($currentSubscription && $currentSubscription['subscription']): ?>
                            <div class="message">
                                <strong>Current Subscription Details:</strong>
                                <br>Type: <strong><?= $currentSubscription['subscription'] ?></strong>
                                <br>Start Date: <strong><?= $currentSubscription['startDate'] ?></strong>
                                <br>Expire Date: <strong><?= $currentSubscription['expireDate'] ?></strong>
                            </div>

                            <form method="POST">
                                <div class="form-group">
                                    <label for="subscription_type">Current Plan</label>
                                    <select id="subscription_type" name="subscription_type" disabled>
                                        <option value="Starter" <?= $currentSubscription['subscription'] === 'Starter' ? 'selected' : '' ?>>Starter ($29)</option>
                                        <option value="Premium" <?= $currentSubscription['subscription'] === 'Premium' ? 'selected' : '' ?>>Premium ($59)</option>
                                    </select>
                                </div>
                                <button type="submit" name="action" value="cancel" style="background-color: #DC3545;">Cancel Subscription</button>
                                
                                <?php if (strtotime($currentSubscription['expireDate']) <= strtotime('+7 days')): ?>
                                    <button type="button" onclick="showRenewalForm()" style="background-color: #28a745;">Renew Subscription</button>
                                <?php endif; ?>
                            </form>

                            <!-- Renewal Payment Form (Hidden by default) -->
                            <div id="renewalForm" style="display: none;" class="payment-form">
                                <h3>Renewal Payment Details</h3>
                                <form method="POST" onsubmit="return validatePaymentForm()">
                                    <input type="hidden" name="action" value="renew">
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
                                    <button type="submit" style="background-color: #28a745;">Process Renewal</button>
                                </form>
                            </div>

                        <?php else: ?>
                            <form method="POST" id="subscriptionForm">
                                <div class="form-group">
                                    <label for="subscription_type">Choose a Subscription Plan</label>
                                    <select id="subscription_type" name="subscription_type">
                                        <option value="Starter">Starter ($29)</option>
                                        <option value="Premium">Premium ($59)</option>
                                    </select>
                                </div>
                                <button type="button" onclick="showPaymentForm()" style="background-color: #007BFF;">Subscribe Now</button>
                            </form>

                            <!-- Payment Form (Hidden by default) -->
                            <div id="paymentForm" style="display: none;" class="payment-form">
                                <h3>Payment Details</h3>
                                <form method="POST" onsubmit="return validatePaymentForm()">
                                    <input type="hidden" name="action" value="subscribe">
                                    <input type="hidden" name="subscription_type" id="selected_plan">
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
               
                <div class='col-sm-1'> </div>
            </div>          
               
        </div>
    </div>

    <script>
        function showPaymentForm() {
            const selectedPlan = document.getElementById('subscription_type').value;
            document.getElementById('selected_plan').value = selectedPlan;
            document.getElementById('subscriptionForm').style.display = 'none';
            document.getElementById('paymentForm').style.display = 'block';
        }

        function showRenewalForm() {
            document.getElementById('renewalForm').style.display = 'block';
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
