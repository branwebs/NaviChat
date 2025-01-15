<?php
session_start();
session_destroy(); // Destroy all session data
header('Location: ../../Boundary/Users/userLogin.php');
exit(); // Ensure no further code is executed
?>