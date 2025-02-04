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
                <form method='POST' action='../../Controller/Admin/updateUserController.php'>
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

// Generate FAQ Table
$faqRows = '';
$sql = "SELECT * FROM faq";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faqRows .= "<tr>
                        <td>" . htmlspecialchars($row['title']) . "</td>
                        <td>" . htmlspecialchars($row['details']) . "</td>
                        <td>
                            <button type='button' onclick='openEditModal(\"faq\", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['details']) . "\")'>Edit</button>
                        </td>
                     </tr>";
    }
}

// Generate Pricing Table
$pricingRows = '';
$sql = "SELECT * FROM pricing";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pricingRows .= "<tr>
                            <td>" . htmlspecialchars($row['tier']) . "</td>
                            <td>" . htmlspecialchars($row['price']) . "</td>
                            <td>" . htmlspecialchars($row['features']) . "</td>
                            <td>
                                <button type='button' class='edit-btn' onclick='openEditModal(\"pricing\", \"" . htmlspecialchars($row['tier']) . "\", \"" . htmlspecialchars($row['tier']) . "\", \"" . htmlspecialchars($row['price']) . "\", \"" . htmlspecialchars($row['features']) . "\")'>Edit</button>
                            </td>
                         </tr>";
    }
}

// Generate Testimonials Table
$testimonialsRows = '';
$sql = "SELECT * FROM testimonials";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $testimonialsRows .= "<tr>
                                <td>" . htmlspecialchars($row['review']) . "</td>
                                <td>" . htmlspecialchars($row['reviewer']) . "</td>
                                <td>
                                    <button type='button' class='edit-btn' onclick='openEditModal(\"testimonials\", \"" . htmlspecialchars($row['review']) . "\", \"" . htmlspecialchars($row['review']) . "\", \"" . htmlspecialchars($row['reviewer']) . "\")'>Edit</button>
                                </td>
                             </tr>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/adminDashboard.css">

    <!-- Bootstrap scripts-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Admin Dashboard</title>

</head>

<body>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <a href="#" class="menu-item active" data-section="website-content">Website Content Management</a>
        <a href="#" class="menu-item" data-section="users-management">Users Management</a>
        <a href="../../index.php" class="logout-btn">Logout</a>
    </div>

    <!-- Content Area -->
    <div id="website-content" class="section active">
        <h2>FAQ</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?= $faqRows ?>
            </tbody>
        </table>

        <h2>Pricing</h2>
        <table>
            <thead>
                <tr>
                    <th>Tier</th>
                    <th>Price</th>
                    <th>Features</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?= $pricingRows ?>
            </tbody>
        </table>

        <h2>Testimonials</h2>
        <table>
            <thead>
                <tr>
                    <th>Review</th>
                    <th>Reviewer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?= $testimonialsRows ?>
            </tbody>
        </table>
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

        function openEditModal(table, identifier, content1, content2, content3) {
            const modal = document.getElementById('editModal');
            modal.style.display = 'block';

            // Set the table name and identifier
            document.getElementById('table').value = table;
            document.getElementById('identifier').value = identifier;

            // Hide all groups initially
            document.getElementById('faq-group').style.display = 'none';
            document.getElementById('pricing-group').style.display = 'none';
            document.getElementById('testimonials-group').style.display = 'none';

            // Show and populate fields based on the table
            if (table === 'faq') {
                document.getElementById('faq-group').style.display = 'block';
                document.getElementById('faq-title').value = content1; // title
                document.getElementById('faq-details').value = content2; // details
            } else if (table === 'pricing') {
                document.getElementById('pricing-group').style.display = 'block';
                document.getElementById('pricing-tier').value = content1; // tier
                document.getElementById('pricing-price').value = content2; // price
                document.getElementById('pricing-features').value = content3; // features
            } else if (table === 'testimonials') {
                document.getElementById('testimonials-group').style.display = 'block';
                document.getElementById('testimonials-review').value = content1; // review
                document.getElementById('testimonials-reviewer').value = content2; // reviewer
            }
        }

        function submitEditForm() {
            // Prevent default form submission
            event.preventDefault();

            const form = document.getElementById('editForm');
            const formData = new FormData(form);

            fetch(form.action, {
                    method: form.method,
                    body: formData,
                })
                .then(response => {
                    if (response.ok) {
                        // Close the modal
                        closeEditModal();

                        // Refresh the page after successful form submission
                        location.reload();
                    } else {
                        alert("Failed to save changes. Please try again.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    </script>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <form id="editForm" method="POST" action="../../Controller/Admin/updateContentController.php">
                <input type="hidden" id="table" name="table">
                <input type="hidden" id="identifier" name="identifier">

                <!-- Common Fields -->
                <div class="form-group" id="faq-group" style="display: none;">
                    <label for="faq-title">Title:</label>
                    <input type="text" id="faq-title" name="title">
                    <label for="faq-details">Details:</label>
                    <textarea id="faq-details" name="details"></textarea>
                </div>

                <div class="form-group" id="pricing-group" style="display: none;">
                    <label for="pricing-tier">Tier:</label>
                    <input type="text" id="pricing-tier" name="tier">
                    <label for="pricing-price">Price:</label>
                    <input type="text" id="pricing-price" name="price">
                    <label for="pricing-features">Features:</label>
                    <textarea id="pricing-features" name="features"></textarea>
                </div>

                <div class="form-group" id="testimonials-group" style="display: none;">
                    <label for="testimonials-review">Review:</label>
                    <textarea id="testimonials-review" name="review"></textarea>
                    <label for="testimonials-reviewer">Reviewer:</label>
                    <input type="text" id="testimonials-reviewer" name="reviewer">
                </div>

                <button type="submit" onclick="submitEditForm()">Save</button>
            </form>
        </div>
    </div>


</body>

</html>