<?php

require_once '../../dbCfg.php';

class EditProfileController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function updateProfile($email, $name, $phone, $company, $industry)
    {
        $sql = "UPDATE users SET name = ?, phone = ?, company = ? , industry = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $phone, $company, $industry, $email);

        if ($stmt->execute()) {
            return true; // Profile updated successfully
        }
        return false; // Profile update failed
    }
}
?>