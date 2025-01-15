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
        $message = "<p class='success-message'>Profile updated successfully.</p>";
        // Refresh user details
        $user = $getUserDetails->getUserDetails();
    } else {
        $message = "<p class='error-message'>Error updating profile. Please try again later.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile </title>
    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/userDashboard.css">
    <link rel="stylesheet" href="../../css/Profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap scripts-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="header">
        <h1>NaviChat</h1>
        <a class="logout" href="../RegisteredUser/logoutConfirmation.php">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
        </a>
    </div>
    
    <div class="row">
        <div class="col-sm-2">
            <div class="sidebar">
                <ul>
                    <li><a href="#">Manage Tickets</a></li>
                    <li>
                        <a href="#">Configure Chatbot &#9662;</a>
                        <ul class="dropdown">
                            <li><a href="answerTemplates.php">Manage Answer Templates</a></li>
                            <li><a href="#">Installation Guide</a></li>
                            <li><a href="#">Select Industry</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Live Chat</a></li>
                    <li><a href="#">Trends</a></li>
                    <li><a href="#">Analytics</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="viewProfile.php">Profile</a></li>
                    <li><a href="subscription.php">Subscription</a></li>
                </ul>
            </div>
        </div>
        
        <div class="col-sm-9">
            <div class="row">
                <div class='col-sm-2'></div>
                <div class='col-sm-9'>
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
                            
                            <?php if (isset($message)) { echo $message; } ?>

                            <div class="btn">
                            <button type="submit" class="save">Save </button>
                            <button type="button" class="cancel" onclick="window.location.href='viewProfile.php'">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class='col-sm-1'></div>
            </div>
        </div>
    </div>
</body>
</html> 