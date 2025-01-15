<?php

require_once '../../Entity/users.php';
require_once '../../dbCfg.php';

$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die("Cannot connect to server: " . $conn->connect_error);
}

class ViewProfileController
{
    private $conn;

    // Constructor to accept the database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getUserDetails()
    {
        $user_email = $_SESSION['email'];

        // Fetch user profile data from the database
        $sql = "SELECT name, email, company, phone FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if user data exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            echo "<p>Unable to fetch user data.</p>";
            exit();
        }
    }
}

// Instantiate the controller and fetch user details
$viewProfileController = new ViewProfileController($conn);
$userDetails = $viewProfileController->getUserDetails();
?>
