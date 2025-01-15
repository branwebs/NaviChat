<?php

class FeedbackController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function submitFeedback($userEmail, $subject, $message) {
        // Validate inputs
        if (empty($userEmail) || empty($subject) || empty($message)) {
            return false;
        }

        // Sanitize inputs
        $userEmail = filter_var($userEmail, FILTER_SANITIZE_EMAIL);
        $subject = htmlspecialchars(strip_tags($subject));
        $message = htmlspecialchars(strip_tags($message));

        // Prepare and execute the SQL query
        $stmt = $this->conn->prepare("INSERT INTO feedback (user_email, subject, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $userEmail, $subject, $message);

        try {
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            // Log error for debugging (in a production environment)
            error_log("Error submitting feedback: " . $e->getMessage());
            return false;
        }
    }

    public function getFeedbackByUser($userEmail) {
        $stmt = $this->conn->prepare("SELECT * FROM feedback WHERE user_email = ? ORDER BY created_at DESC");
        $stmt->bind_param("s", $userEmail);
        
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $feedback = [];
            
            while ($row = $result->fetch_assoc()) {
                $feedback[] = $row;
            }
            
            $stmt->close();
            return $feedback;
        } catch (Exception $e) {
            error_log("Error retrieving feedback: " . $e->getMessage());
            return [];
        }
    }

    public function getAllFeedback() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM feedback ORDER BY created_at DESC");
            $stmt->execute();
            $result = $stmt->get_result();
            $feedback = [];
            
            while ($row = $result->fetch_assoc()) {
                $feedback[] = $row;
            }
            
            $stmt->close();
            return $feedback;
        } catch (Exception $e) {
            error_log("Error retrieving all feedback: " . $e->getMessage());
            return [];
        }
    }

    public function updateFeedbackStatus($feedbackId, $status) {
        if (!in_array($status, ['pending', 'resolved'])) {
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE feedback SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $feedbackId);

        try {
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            error_log("Error updating feedback status: " . $e->getMessage());
            return false;
        }
    }

    public function deleteFeedback($feedbackId, $userEmail) {
        // Only allow users to delete their own feedback
        $stmt = $this->conn->prepare("DELETE FROM feedback WHERE id = ? AND user_email = ?");
        $stmt->bind_param("is", $feedbackId, $userEmail);

        try {
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            error_log("Error deleting feedback: " . $e->getMessage());
            return false;
        }
    }

    public function editFeedback($feedbackId, $userEmail, $subject, $message) {
        // Validate inputs
        if (empty($subject) || empty($message)) {
            return false;
        }

        // Sanitize inputs
        $subject = htmlspecialchars(strip_tags($subject));
        $message = htmlspecialchars(strip_tags($message));

        // Only allow users to edit their own feedback
        $stmt = $this->conn->prepare("UPDATE feedback SET subject = ?, message = ? WHERE id = ? AND user_email = ? AND status = 'pending'");
        $stmt->bind_param("ssis", $subject, $message, $feedbackId, $userEmail);

        try {
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            error_log("Error editing feedback: " . $e->getMessage());
            return false;
        }
    }
} 