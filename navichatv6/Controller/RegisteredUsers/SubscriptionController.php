<?php
require_once '../../dbCfg.php';
require_once '../../Entity/users.php';

class Subscription
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    /**
     * Updates a user's subscription in the database (fixed to $59).
     */
    public function updateSubscription($email, $cardNumber, $expiry, $cvv)
    {
        $price = 59;  // Fixed price for subscription
        $startDate = date('Y-m-d'); // Set start date to the current date
        $expireDate = date('Y-m-d', strtotime('+1 month')); // Set expiration to 1 month from now

        // Check if the payment info is valid (basic validation)
        if (!$this->validatePayment($cardNumber, $expiry, $cvv)) {
            return ['success' => false, 'errors' => ["Invalid payment details."]];
        }

        // Update subscription in the database
        $stmt = $this->conn->prepare("UPDATE users SET subscription = ?, startDate = ?, expireDate = ? WHERE email = ?");
        $stmt->bind_param("dsss", $price, $startDate, $expireDate, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => ["Failed to update subscription."]];
        }
    }

    /**
     * Cancels a user's subscription.
     */
    public function cancelSubscription($email)
    {
        $stmt = $this->conn->prepare("UPDATE users SET subscription = NULL, startDate = NULL, expireDate = NULL WHERE email = ?");
        $stmt->bind_param("s", $email);
        return $stmt->execute();
    }

    /**
     * Retrieves a user's current subscription details.
     */
    public function getUserSubscription($email)
    {
        $stmt = $this->conn->prepare("SELECT subscription, startDate, expireDate FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Validates payment information.
     */
    private function validatePayment($cardNumber, $expiry, $cvv)
    {
        // Basic payment validation logic (card number, expiry date, and CVV)
        if (!preg_match('/^\d{16}$/', $cardNumber)) {
            return false;
        }
        if (!preg_match('/^\d{2}\/\d{2}$/', $expiry)) {
            return false;
        }
        if (!preg_match('/^\d{3}$/', $cvv)) {
            return false;
        }
        return true;
    }
}

?>
