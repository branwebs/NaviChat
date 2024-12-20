<?php

require_once '../../Entity/users.php';

class UserLoginController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Process login and return errors if any.
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function processLogin($email, $password)
    {
        $errors = [];

        // Input validation
        if (empty($email) || empty($password)) {
            $errors[] = "Please fill in all fields.";
            return $errors;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
            return $errors;
        }

        // Fetch user
        $user = $this->userModel->getUserByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = "Invalid email or password.";
            return $errors;
        }

        // Handle access level
        switch ($user['access']) {
            case 0:
                $errors[] = "Account under approval.";
                break;
            case 1:
                header('Location: ../../Boundary/RegisteredUser/user_dashboard.php');
                exit;
            case 4:
                header('Location: ../../Boundary/Admin/admin_dashboard.php');
                exit;
            default:
                $errors[] = "Unexpected access level. Please contact support.";
        }

        return $errors;
    }
}

?>

