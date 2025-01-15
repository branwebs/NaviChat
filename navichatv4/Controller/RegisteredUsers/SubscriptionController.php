<?php

require_once '../../Entity/users.php';
require_once '../../dbCfg.php';

$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die("Cannot connect to server: " . $conn->connect_error);
}

class Subscription
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    /**
     * Updates a user's subscription in the database.
     */
    public function updateSubscription($email, $type, $cardNumber = null, $expiry = null, $cvv = null)
    {
        $errors = [];

        // Validate subscription type
        if (!in_array($type, ['Starter', 'Premium'])) {
            $errors[] = "Invalid subscription type. Choose 'Starter' or 'Premium'.";
        }

        // Validate payment info if provided
        if ($cardNumber !== null) {
            if (!$this->validatePayment($cardNumber, $expiry, $cvv)) {
                $errors[] = "Invalid payment information.";
            }
        }

        // Validate user existence and current subscription
        $stmt = $this->conn->prepare("SELECT subscription FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $errors[] = "User not found.";
        } else {
            $user = $result->fetch_assoc();
            if ($user['subscription'] && $cardNumber === null) {
                $errors[] = "You already have an active subscription. Please cancel it first.";
            }
        }

        // Return errors if any
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // Calculate start and end dates
        $startDate = date("Y-m-d");
        $expireDate = date("Y-m-d", strtotime("+1 month", strtotime($startDate)));

        // Update subscription in the database
        $stmt = $this->conn->prepare(
            "UPDATE users SET subscription = ?, startDate = ?, expireDate = ? WHERE email = ?"
        );
        $stmt->bind_param("ssss", $type, $startDate, $expireDate, $email);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => "Subscription updated successfully."];
        } else {
            return ['success' => false, 'errors' => ["Failed to update subscription. Please try again."]];
        }
    }

    /**
     * Retrieves a user's subscription details.
     */
    public function getUserSubscription($email)
    {
        $stmt = $this->conn->prepare("SELECT subscription, startDate, expireDate FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Cancels a user's subscription.
     */
    public function cancelSubscription($email)
    {
        $stmt = $this->conn->prepare(
            "UPDATE users SET subscription = NULL, startDate = NULL, expireDate = NULL WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        return $stmt->execute();
    }

    /**
     * Renews a user's subscription.
     */
    public function renewSubscription($email, $cardNumber, $expiry, $cvv)
    {
        $errors = [];

        // Validate payment information
        if (!$this->validatePayment($cardNumber, $expiry, $cvv)) {
            $errors[] = "Invalid payment information.";
        }

        // Get current subscription
        $currentSub = $this->getUserSubscription($email);
        if (!$currentSub || !$currentSub['subscription']) {
            $errors[] = "No active subscription found.";
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        // Calculate new dates
        $startDate = $currentSub['expireDate']; // Start from when current subscription ends
        $expireDate = date("Y-m-d", strtotime("+1 month", strtotime($startDate)));

        // Update subscription dates
        $stmt = $this->conn->prepare(
            "UPDATE users SET startDate = ?, expireDate = ? WHERE email = ?"
        );
        $stmt->bind_param("sss", $startDate, $expireDate, $email);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => "Subscription renewed successfully."];
        } else {
            return ['success' => false, 'errors' => ["Failed to renew subscription. Please try again."]];
        }
    }

    /**
     * Validates payment information.
     */
    private function validatePayment($cardNumber, $expiry, $cvv)
    {
        // Validate card number (16 digits)
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            return false;
        }

        // Validate expiry date (MM/YY format)
        if (!preg_match('/^\d{2}\/\d{2}$/', $expiry)) {
            return false;
        }

        // Validate CVV (3 digits)
        if (!preg_match('/^\d{3}$/', $cvv)) {
            return false;
        }

        return true;
    }
}

?>
