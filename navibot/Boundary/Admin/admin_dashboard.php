<?php
include_once("../../dbCfg.php");

$sqlApproved = "SELECT email, name, phone, company, subscription FROM users WHERE access = 1";
$resultApproved = $conn->query($sqlApproved);

// Query for users with access 0
$sqlPending = "SELECT email, name, phone, company, subscription FROM users WHERE access = 0";
$resultPending = $conn->query($sqlPending);

function generateTableRows($result, $showButtons = false)
{
    $rows = '';
    if ($result->num_rows > 0) {
        while ($r = $result->fetch_assoc()) {
            // Buttons only for pending users
            $buttons = $showButtons ? "
                <form method='POST' action='../../Controller/RegisteredUser/updateUserController.php'>
                    <input type='hidden' name='email' value='" . htmlspecialchars($r["email"]) . "'>
                    <button type='submit' name='action' value='approve'>Approve</button>
                    <button type='submit' name='action' value='reject'>Reject</button>
                </form>" : "";

            $rows .= "<tr>
                          <td>" . htmlspecialchars($r["email"]) . "</td>
                          <td>" . htmlspecialchars($r["name"]) . "</td>
                          <td>" . htmlspecialchars($r["phone"]) . "</td>
                          <td>" . htmlspecialchars($r["company"]) . "</td>
                          <td>" . htmlspecialchars($r["subscription"]) . "</td>
                          <td>" . $buttons . "</td>
                      </tr>";
        }
    } else {
        $rows = "<tr><td colspan='" . ($showButtons ? '6' : '5') . "' class='no-record'>No record to list...</td></tr>";
    }
    return $rows;
}

$approvedUsers = generateTableRows($resultApproved);
$pendingUsers = generateTableRows($resultPending, true);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminDashboard.css">
    <title>Admin Dashboard</title>
    
</head>

<body>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <a href="#" class="menu-item active" data-section="website-content">Website Content Management</a>
        <a href="#" class="menu-item" data-section="users-management">Users Management</a>
        <a href="#" class="menu-item" data-section="demo-chatbot">Demo Chatbot Configuration</a>

        <a href="../../index.php" class="logout-btn">Logout</a>
    </div>

    <!-- Content Area -->
    <div class="content">
        <!-- Website Content Management -->
        <div id="website-content" class="section active">
            <h2>Website Content Management</h2>

            <h3>Update Pricing:</h3>
            <div class="form-group">
                <label for="tier">Tier:</label>
                <input type="text" id="tier" name="tier">
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price">
            </div>

            <div class="form-group">
                <label for="features">Features:</label>
                <textarea id="features" name="features"></textarea>
            </div>

            <h3>Update Testimonials:</h3>
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea id="review" name="review"></textarea>
            </div>

            <div class="form-group">
                <label for="reviewer">Reviewer:</label>
                <input type="text" id="reviewer" name="reviewer">
            </div>

            <h3>Update FAQ:</h3>
            <div class="form-group">
                <label for="faq-title">Title:</label>
                <input type="text" id="faq-title" name="faq-title">
            </div>

            <div class="form-group">
                <label for="faq-details">Details:</label>
                <textarea id="faq-details" name="faq-details"></textarea>
            </div>

            <button type="button">Save Changes</button>
        </div>


        <!-- Users Management -->
        <div id="users-management" class="section">
            <h2>Registered Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Subscription</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $approvedUsers ?>
                </tbody>
            </table>

            <h2>Pending Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Subscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $pendingUsers ?>
                </tbody>
            </table>
        </div>
        

        <!-- Demo Chatbot Configuration -->
        <div id="demo-chatbot" class="section">
            <h2>Demo Chatbot Configuration</h2>
            <p>Configure demo chatbot settings here.</p>
        </div>
    </div>

    <script>
        // JavaScript to toggle sections
        const menuItems = document.querySelectorAll('.menu-item');
        const sections = document.querySelectorAll('.section');

        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove 'active' class from all menu items
                menuItems.forEach(i => i.classList.remove('active'));

                // Add 'active' class to clicked menu item
                this.classList.add('active');

                // Hide all sections
                sections.forEach(section => section.classList.remove('active'));

                // Show the selected section
                const sectionId = this.getAttribute('data-section');
                document.getElementById(sectionId).classList.add('active');
            });
        });
    </script>
</body>

</html>