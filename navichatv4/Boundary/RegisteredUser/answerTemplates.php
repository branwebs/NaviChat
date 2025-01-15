<?php
session_start();
require_once '../../dbCfg.php';


// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../Users/userLogin.php');
    exit;
}

$message = '';
$userEmail = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Answer Templates</title>
    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/userDashboard.css">
    <link rel="stylesheet" href="../../css/Templates.css">
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
                    <div class="templates-container">
                        <h1>Add Answer Templates</h1>
                        <div class="button-group mb-4">
                            <button type="button" class="submit-btn" onclick="window.location.href=''">View Templates</button>
                        </div>
                        
                        <?php if (!empty($message)): ?>
                            <div class="alert <?= strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success' ?>">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="templates-form">
                            <div class="form-group">
                                <label for="subject">Questions:</label>
                                <input type="text" id="subject" name="subject" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Answer:</label>
                                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            
                            <div class="button-group">
                                <button type="submit" class="submit-btn">Submit</button>
                                <button type="button" class="cancel-btn" onclick="window.location.href='user_dashboard.php'">Cancel</button>
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