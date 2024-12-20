<?php
require_once 'dbCfg.php'; 

$sql = "SELECT email, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plainPassword = $row['password'];
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Update the database with the hashed password
        $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $updateStmt->bind_param("ss", $hashedPassword, $row['email']);
        $updateStmt->execute();
    }
    echo "Passwords successfully hashed.";
} else {
    echo "No users found.";
}
$conn->close();
?>
