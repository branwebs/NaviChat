<?php
require_once '../../dbCfg.php';
require_once '../../Controller/Users/userLoginController.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if fields are filled
    if (empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields.";
    } else {
        // Query the database
        $stmt = $conn->prepare("SELECT email, password, access FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user exists
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $row['password'])) {
                if ($row['access'] == 0) {
                    $errors[] = "Account under approval.";
                } elseif ($row['access'] == 1) {
                    header('Location: ../../Boundary/RegisteredUser/user_dashboard.php');
                    exit; // Stop script execution after redirect
                } else {
                    $errors[] = "Unexpected access level. Please contact support.";
                }
            } else {
                $errors[] = "Invalid email or password.";
            }
        } else {
            $errors[] = "Invalid email or password.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
</head>

<body>
    <section>
        <div class="form-box">
            <h2 class="login-title">NaviChat</h2>
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
