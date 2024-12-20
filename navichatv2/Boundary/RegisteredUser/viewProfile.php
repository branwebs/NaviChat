<?php
session_start(); // Start the session to access session variables

// Include necessary files
require_once '../../dbCfg.php';
require_once '../../Entity/users.php';
require_once '../../Controller/RegisteredUsers/viewProfileController.php';


// Fetch the logged-in user's profile
$userEmail = $_SESSION['email'];
$getUserDetails = new viewProfileController($conn);
$user = $getUserDetails->getUserDetails();


// Check if the user data exists
if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../../css/Profile.css">

</head>

<body>
    <section class="profile-section">
        <div class="profile-box">
            <h1 class="profile-title">Profile</h1>
            <table class="profile-table">
                <tr>
                    <th>Name:</th>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <th>Phone Number:</th>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                </tr>
                <tr>
                    <th>Company:</th>
                    <td><?php echo htmlspecialchars($user['company']); ?></td>
                </tr>
            </table>
            <div class="btn">
            <button type="button" class="edit" onclick="window.location.href='editProfile.php'">Edit Profile</button>
            <button type="button" class="cancel" onclick="window.location.href='user_dashboard.php'">Cancel</button>
            </div>
        </div>
    </section>
</body>

</html>
