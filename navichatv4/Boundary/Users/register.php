<?php
require_once '../../dbCfg.php';
require_once '../../Controller/Users/userRegisterController.php';

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $company = $_POST["company"];
    $phone = $_POST["phone"];

    $registerController = new UserRegisterController();
    $result = $registerController->register($name, $email, $password, $confirmPassword, $company, $phone);

    if ($result['success']) {
        $successMessage = "Registration successful. Your account is under approval.";
    } else {
        $errors = $result['errors'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="../../css/login-register.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <title>Register</title>
</head>

<body>
    <a href="../../index.php" class="navi-chat">NaviChat</a>
    <section>
        <div class="form-box">
            <h2 class="register-title">Registration</h2>
            <form class="user-input" method="POST">
                <label for="name">Full Name:</label>
                <input type="text" name="name" id="name" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <br>
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" name="confirmPassword" id="confirmPassword" required>
                <br>
                <label for="company">Company:</label>
                <input type="text" name="company" id="company" required>
                <br>
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" required>
                <br>
                <!-- Display success or errors -->
                <?php if (!empty($successMessage)) : ?>
                    <div class="success-message">
                        <p><?php echo htmlspecialchars($successMessage); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)) : ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error) : ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <input type="submit" class="submit-btn" value="Register">
            </form>
            
            <!-- Login -->
            <div class="links">
                    Already have an account? <a href="userLogin.php">Login Now</a>
            </div>
        </div>
    </section>
</body>

</html>