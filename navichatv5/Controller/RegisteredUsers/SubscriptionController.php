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
     *
     * @param string $email User's email address.
     * @param string $type Subscription type (Starter or Premium).
     * @return array Response with success status and message.
     */
    public function updateSubscription($email, $type)
    {
        $errors = [];

        // Validate subscription type
        if (!in_array($type, ['Starter', 'Premium'])) {
            $errors[] = "Invalid subscription type. Choose 'Starter' or 'Premium'.";
        }

        // Validate user existence
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $errors[] = "User not found.";
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
     *
     * @param string $email User's email address.
     * @return array|null Subscription details or null if not found.
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
     *
     * @param string $email User's email address.
     * @return bool True if subscription canceled successfully, false otherwise.
     */
    public function cancelSubscription($email)
    {
        $stmt = $this->conn->prepare(
            "UPDATE users SET subscription = NULL, startDate = NULL, expireDate = NULL WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        return $stmt->execute();
    }
}

?>
