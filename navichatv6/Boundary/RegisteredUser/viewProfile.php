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

   <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/Profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap scripts-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>
    <div class="sidebar">
        <a href="user_dashboard.php" class="menu-item" >Analytics</a>
        <a href="installationGuide.php" class="menu-item" >Installation Guide</a>
        <a href="#" class="menu-item active" data-section="view-profile">Profile</a>
        <a href="subscription.php"class="menu-item"  >Subscription</a>
        <a href="../../index.php" class="logout-btn">Logout</a>
    </div>

    <div id="view-profile" class = "section active" >
        <div class="container">
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
                <tr>
                    <th>Industry:</th>
                    <td><?php echo htmlspecialchars($user['industry']); ?></td>
                </tr>
            </table>

            <div class="btn">
                <button type="button" class="edit" onclick="window.location.href='editProfile.php'">Edit Profile</button>
            </div>
        </div>
    </div>
</body>

</html>
