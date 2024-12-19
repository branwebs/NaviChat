<?php

require_once '../../dbCfg.php';

class User
{
    private $conn;

    public function __construct()
    {
        global $conn; 
        $this->conn = $conn;
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createUser($name, $email, $password, $company, $phone)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (name, email, password, company, phone, access) VALUES (?, ?, ?, ?, ?, 0)"
        );
        $stmt->bind_param("sssss", $name, $email, $password, $company, $phone);
        return $stmt->execute();
    }

    public function getBot($industry)
    {
        // Query the database for chatbot configuration based on industry
        $stmt = $this->conn->prepare(
            "SELECT intent, chat_title, agent_id, language_code FROM chatbot_config WHERE industry = ?"
        );
        $stmt->bind_param("s", $industry);
        $stmt->execute();
        $result = $stmt->get_result();

        // Return the chatbot configuration as an associative array
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return [
                "error" => "No chatbot configuration found for the selected industry."
            ];
        }
    }
    public function updateAccess($email, $access) {
        $stmt = $this->conn->prepare("UPDATE users SET access = ? WHERE email = ?");
        $stmt->bind_param('is', $access, $email);
        return $stmt->execute();
    }

    public function deleteUser($email) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        return $stmt->execute();
    }

}
?>
