<?php
session_start();
require_once '../../dbCfg.php';
require_once '../../Controller/RegisteredUsers/FeedbackController.php';

// Check if user is admin
if (!isset($_SESSION['email']) || !isset($_SESSION['access']) || $_SESSION['access'] != 4) {
    header('Location: ../Users/userLogin.php');
    exit;
}

$message = '';
$feedbackController = new FeedbackController($conn);

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_id']) && isset($_POST['status'])) {
    $feedbackId = $_POST['feedback_id'];
    $status = $_POST['status'];
    
    if ($feedbackController->updateFeedbackStatus($feedbackId, $status)) {
        $message = "Status updated successfully!";
    } else {
        $message = "Error updating status.";
    }
}

// Get all feedback
$allFeedback = $feedbackController->getAllFeedback();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback</title>
    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/userDashboard.css">
    <link rel="stylesheet" href="../../css/feedback.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="header">
        <h1>NaviChat Admin</h1>
        <a class="logout" href="../RegisteredUser/logoutConfirmation.php">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
        </a>
    </div>
    
    <div class="row">
        <div class="col-sm-2">
            <div class="sidebar">
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_feedback.php">Manage Feedback</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                </ul>
            </div>
        </div>
        
        <div class="col-sm-9">
            <div class="row">
                <div class='col-sm-12'>
                    <div class="feedback-container">
                        <h1>Manage Feedback</h1>
                        
                        <?php if (!empty($message)): ?>
                            <div class="alert <?= strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success' ?>">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="feedback-list">
                            <?php foreach ($allFeedback as $feedback): ?>
                                <div class="feedback-item">
                                    <div class="feedback-header">
                                        <h3><?= htmlspecialchars($feedback['subject']) ?></h3>
                                        <form method="POST" class="status-form">
                                            <input type="hidden" name="feedback_id" value="<?= $feedback['id'] ?>">
                                            <select name="status" onchange="this.form.submit()">
                                                <option value="pending" <?= $feedback['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="resolved" <?= $feedback['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                                            </select>
                                        </form>
                                    </div>
                                    <div class="feedback-content">
                                        <p><?= nl2br(htmlspecialchars($feedback['message'])) ?></p>
                                    </div>
                                    <div class="feedback-footer">
                                        <span class="user">From: <?= htmlspecialchars($feedback['user_email']) ?></span>
                                        <span class="date">
                                            Submitted on: <?= date('F j, Y, g:i a', strtotime($feedback['created_at'])) ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 