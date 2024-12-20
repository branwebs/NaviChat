<?php
session_start(); // Start the session to access session variables

// Include necessary files
require_once '../../dbCfg.php';
require_once '../../Controller/RegisteredUsers/viewProfileController.php';
require_once '../../Controller/RegisteredUsers/editProfileController.php';

// Fetch the logged-in user's profile
$userEmail = $_SESSION['email'];
$getUserDetails = new viewProfileController($conn);
$user = $getUserDetails->getUserDetails();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $company = $_POST['company'];

    // Update user details using the controller
    $editProfileController = new EditProfileController($conn);
    $isUpdated = $editProfileController->updateProfile($userEmail, $name, $phone, $company);

    if ($isUpdated) {
        echo "<p>Profile updated successfully.</p>";
        // Refresh user details
        $user = $getUserDetails->getUserDetails();
    } else {
        echo "<p>Error updating profile. Please try again later.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../../css/Profile.css">

</head>

<body>
    <section class="profile-section">
        <div class="profile-box">
            <h1 class="profile-title">Edit Profile</h1>
            <form method="POST" class="edit-profile-form">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                

                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                

                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                

                <label for="company">Company:</label>
                <input type="text" name="company" id="company" value="<?php echo htmlspecialchars($user['company']); ?>" required>
                
                <div class="btn">
                <button type="submit" class="save">Save </button>
                <button type="button" class="cancel" onclick="window.location.href='viewProfile.php'">Cancel</button>
                </div>
            </form>
        </div>
    </section>

</body>

</html>
