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
    $industry = $_POST['industry'];

    // Update user details using the controller
    $editProfileController = new EditProfileController($conn);
    $isUpdated = $editProfileController->updateProfile($userEmail, $name, $phone, $company, $industry);

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
    
    <div id="edit-profile" class = "section active" >
        <div class="container">
            <div class="editprofile-box">
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

                    <label for="industry">Industry:</label>
                    <select name="industry" id="industry" required>
                        <option value="F&B" <?php echo $user['industry'] === "F&B" ? "selected" : ""; ?>>F&B</option>
                        <option value="Retail" <?php echo $user['industry'] === "Retail" ? "selected" : ""; ?>>Retail</option>
                    </select>

                    <div class="btn">
                        <button type="submit" class="save">Save </button>
                        <button type="button" class="cancel" onclick="window.location.href='viewProfile.php'">Cancel</button>
                    </div>
                </form>
                
            </div>


        </div>
    </div>

</body>
</html>