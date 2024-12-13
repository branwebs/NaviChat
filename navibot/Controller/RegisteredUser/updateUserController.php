<?php
// Include the User entity
require_once '../../Entity/users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['email'])) {
        $action = $_POST['action'];
        $email = $_POST['email'];

        // Instantiate the User entity
        $user = new User();

        if ($action === 'approve') {
            // Approve the user by setting access to 1
            $result = $user->updateAccess($email, 1);
            if ($result) {
                header('Location: ../../Boundary/Admin/admin_dashboard.php?message=User approved successfully');
            } else {
                header('Location: ../../Boundary/Admin/admin_dashboard.php?error=Failed to approve user');
            }
        } elseif ($action === 'reject') {
            // Reject the user by deleting from the database
            $result = $user->deleteUser($email);
            if ($result) {
                header('Location: ../../Boundary/Admin/admin_dashboard.php?message=User rejected and removed successfully');
            } else {
                header('Location: ../../Boundary/Admin/admin_dashboard.php?error=Failed to reject user');
            }
        } else {
            header('Location: ../../Boundary/Admin/admin_dashboard.php?error=Invalid action');
        }
    } else {
        header('Location: ../../Boundary/Admin/admin_dashboard.php?error=Invalid request parameters');
    }
}
?>

