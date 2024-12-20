
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User_dashboard</title>
    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/userDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
<div class="header">
        <h1>NaviChat</h1>
        <a class="logout" href="../RegisteredUser/logoutConfirmation.php" >
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
        </a>
    </div>
    <div class="sidebar">
        <ul>
            <li><a href="#">Manage Tickets</a></li>
            <li>
                <a href="#">Configure Chatbot &#9662;</a>
                <ul class="dropdown">
                    <li><a href="#">Manage Answer Templates</a></li>
                    <li><a href="#">Installation Guide</a></li>
                    <li><a href="selectIndustry.php">Select Industry</a></li>
                </ul>
            </li>
            <li><a href="#">Live Chat</a></li>
            <li><a href="#">Trends</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Feedback</a></li>
            <li><a href="viewProfile.php" >Profile</a></li>
            <li><a href="subscription.php">Subscription</a></li>
        </ul>
    </div>

    <div id="viewProfile" class="section active">
        <!-- Content goes here -->
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
            <button type="button" class="cancel" onclick="window.location.href='../../Controller/RegisteredUser/user_dashboard.php'">Cancel</button>
            </div>
    </div>


</body>
</html>

