<?php
require_once '../../dbCfg.php';
require_once '../../Controller/Users/userLoginController.php';

$errors = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $loginController = new UserLoginController();
    $errors = $loginController->processLogin($email, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="../../css/userLogin.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <title>Login</title>
</head>

<body>
    <section>
    <a href="../../index.php" class="navi-chat">NaviChat</a>
        <div class="form-box">
            <h2 class="login-title">Welcome</h2>
            <form class="user-input" method="POST">
                <label for="email">Business Email:</label>
                <input type="email" name="email" id="email" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <!-- Display errors if any -->
                <?php if (!empty($errors)) : ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error) : ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <input type="submit" name="login" class="submit-btn" value="Login">
            </form>

            <!-- Register Button -->
            <form action="register.php" method="get">
                <input type="submit" class="register-btn" value="Register"></input>
            </form>
        </div>
    </section>
</body>

</html>

