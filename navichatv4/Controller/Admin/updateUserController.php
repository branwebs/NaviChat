<?php
// Database connection setup
require_once '../../Entity/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $email = $_POST['email'] ?? null;

    if (!$action || !$email) {
        echo "<script>alert('Invalid request. Please try again.'); window.location.href = '../../Boundary/Admin/admin_dashboard.php';</script>";
        exit;
    }

    if ($action === 'approve') {
        $query = "UPDATE users SET access = 1 WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            echo "<script>alert('User approved successfully!'); window.location.href = '../../Boundary/Admin/admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to approve user. Please try again.'); window.location.href = '../../Boundary/Admin/admin_dashboard.php';</script>";
        }
        
    } elseif ($action === 'reject') {
        $query = "DELETE FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            echo "<script>alert('User rejected and removed successfully!'); window.location.href = '../../Boundary/Admin/admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to remove user. Please try again.'); window.location.href = '../../Boundary/Admin/admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Unknown action.'); window.location.href = '../../Boundary/Admin/admin_dashboard.php';</script>";
    }
}
?>


