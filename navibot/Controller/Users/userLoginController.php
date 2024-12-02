<?php

require_once '../../Entity/users.php';

class UserLoginController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User(); // Instance of the User entity class
    }

    /**
     * Validate login credentials.
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login($email, $password)
    {
        $errors = [];
        if (empty($email) || empty($password)) {
            $errors[] = "Please fill in all fields.";
            return $errors;
        }

        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            $errors[] = "Invalid email or password.";
        } elseif (!password_verify($password, $user['password'])) {
            $errors[] = "Invalid email or password.";
        } else {
            if ($user['access'] == 0) {
                $errors[] = "Account under approval.";
            } elseif ($user['access'] == 1) {
                header('Location: ../../Boundary/RegisteredUser/user_dashboard.php');
                exit;
            } else {
                $errors[] = "Unexpected access level. Please contact support.";
            }
        }

        return $errors;
    }
}

?>
