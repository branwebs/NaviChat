<?php
session_start();
require_once '../../dbCfg.php';
require_once '../../Controller/RegisteredUsers/FeedbackController.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../Users/userLogin.php');
    exit;
}

$userEmail = $_SESSION['email'];
$feedbackController = new FeedbackController($conn);
$message = '';

// Handle delete feedback
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $feedbackId = $_POST['feedback_id'];
    if ($feedbackController->deleteFeedback($feedbackId, $userEmail)) {
        $message = "Feedback deleted successfully!";
    } else {
        $message = "Error deleting feedback.";
    }
}

// Handle edit feedback
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $feedbackId = $_POST['feedback_id'];
    $subject = $_POST['subject'];
    $feedbackMessage = $_POST['message'];
    
    if ($feedbackController->editFeedback($feedbackId, $userEmail, $subject, $feedbackMessage)) {
        $message = "Feedback updated successfully!";
    } else {
        $message = "Error updating feedback. You can only edit pending feedback.";
    }
}

$feedbackList = $feedbackController->getFeedbackByUser($userEmail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/userDashboard.css">
    <link rel="stylesheet" href="../../css/feedback.css">
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
                            <li><a href="#">Manage Answer Templates</a></li>
                            <li><a href="#">Installation Guide</a></li>
                            <li><a href="#">Select Industry</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Live Chat</a></li>
                    <li><a href="#">Trends</a></li>
                    <li><a href="#">Analytics</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="VP.php">Profile</a></li>
                    <li><a href="subscription.php">Subscription</a></li>
                </ul>
            </div>
        </div>
        
        <div class="col-sm-9">
            <div class="row">
                <div class='col-sm-2'></div>
                <div class='col-sm-9'>
                    <div class="feedback-container">
                        <h1>Your Feedback History</h1>
                        <div class="button-group mb-4">
                            <button type="button" class="submit-btn" onclick="window.location.href='feedback.php'">Submit New Feedback</button>
                        </div>

                        <?php if (!empty($message)): ?>
                            <div class="alert <?= strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success' ?>">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (empty($feedbackList)): ?>
                            <p class="no-feedback">You haven't submitted any feedback yet.</p>
                        <?php else: ?>
                            <div class="feedback-list">
                                <?php foreach ($feedbackList as $feedback): ?>
                                    <div class="feedback-item" id="feedback-<?= $feedback['id'] ?>">
                                        <div class="feedback-header">
                                            <h3><?= htmlspecialchars($feedback['subject']) ?></h3>
                                            <span class="status <?= $feedback['status'] ?>">
                                                <?= ucfirst(htmlspecialchars($feedback['status'])) ?>
                                            </span>
                                        </div>
                                        <div class="feedback-content">
                                            <p><?= nl2br(htmlspecialchars($feedback['message'])) ?></p>
                                        </div>
                                        <div class="feedback-footer">
                                            <span class="date">
                                                Submitted on: <?= date('F j, Y, g:i a', strtotime($feedback['created_at'])) ?>
                                            </span>
                                            <?php if ($feedback['status'] === 'pending'): ?>
                                                <div class="action-buttons">
                                                    <button onclick="showEditForm(<?= $feedback['id'] ?>, '<?= htmlspecialchars(addslashes($feedback['subject'])) ?>', '<?= htmlspecialchars(addslashes($feedback['message'])) ?>')" class="edit-btn">Edit</button>
                                                    <form method="POST" style="display: inline;">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="feedback_id" value="<?= $feedback['id'] ?>">
                                                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Edit Form (Hidden by default) -->
                                    <div id="edit-form-<?= $feedback['id'] ?>" class="edit-feedback-form" style="display: none;">
                                        <form method="POST">
                                            <input type="hidden" name="action" value="edit">
                                            <input type="hidden" name="feedback_id" value="<?= $feedback['id'] ?>">
                                            
                                            <div class="form-group">
                                                <label for="subject-<?= $feedback['id'] ?>">Subject:</label>
                                                <input type="text" id="subject-<?= $feedback['id'] ?>" name="subject" class="form-control" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="message-<?= $feedback['id'] ?>">Message:</label>
                                                <textarea id="message-<?= $feedback['id'] ?>" name="message" class="form-control" rows="5" required></textarea>
                                            </div>
                                            
                                            <div class="button-group">
                                                <button type="submit" class="submit-btn">Update Feedback</button>
                                                <button type="button" class="cancel-btn" onclick="hideEditForm(<?= $feedback['id'] ?>)">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class='col-sm-1'></div>
            </div>
        </div>
    </div>

    <script>
        function showEditForm(id, subject, message) {
            // Hide the feedback display
            document.getElementById('feedback-' + id).style.display = 'none';
            // Show the edit form
            document.getElementById('edit-form-' + id).style.display = 'block';
            // Populate the form fields
            document.getElementById('subject-' + id).value = subject;
            document.getElementById('message-' + id).value = message;
        }

        function hideEditForm(id) {
            // Show the feedback display
            document.getElementById('feedback-' + id).style.display = 'block';
            // Hide the edit form
            document.getElementById('edit-form-' + id).style.display = 'none';
        }
    </script>
</body>
</html> 