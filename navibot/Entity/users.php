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
        $stmt = $this->conn->prepare("SELECT email, password, access FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return null; // No user found
    }

   
    public function createUser($email, $password, $name, $phone_number, $company)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (email, password, name, phone_number, company, access) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("sssss", $email, $hashedPassword, $name, $phone_number, $company);

        return $stmt->execute();
    }
}

?>
