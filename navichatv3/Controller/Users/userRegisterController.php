<?php

require_once '../../Entity/users.php';

class UserRegisterController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Handles user registration.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $confirmPassword
     * @param string $company
     * @param string $phone
     * @return array
     */
    public function register($name, $email, $password, $confirmPassword, $company, $phone)
    {
        $errors = [];
        $success = false;

        // Validate inputs
        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($company) || empty($phone)) {
            $errors[] = "All fields are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if (!preg_match('/^[0-9]{8,10}$/', $phone)) {
            $errors[] = "Phone number must be 10-15 digits.";
        }

        // Check if the email already exists
        if ($this->userModel->getUserByEmail($email)) {
            $errors[] = "Email is already registered.";
        }

        // If no errors, create the account
        if (empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $created = $this->userModel->createUser($name, $email, $hashedPassword, $company, $phone);

            if ($created) {
                $success = true;
            } else {
                $errors[] = "Failed to create the account. Please try again.";
            }
        }

        return ['success' => $success, 'errors' => $errors];
    }
}

?>

