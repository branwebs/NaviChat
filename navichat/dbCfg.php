<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "navichat";
$dbTable = "users";
$dbTable2 = "faq";
$dbTable3 = "pricing";
$dbTable4 = "testimonials";
$dbtable5 = "chatbot_config";

$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die("cannot connect to server...");
}
?>