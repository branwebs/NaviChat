<?php
// Database connection
require_once 'dbCfg.php';

// Get Dialogflow request
$request = file_get_contents("php://input");
$data = json_decode($request, true);
$userMessage = strtolower($data['queryResult']['queryText']); // User input from Dialogflow

// Define symptoms to track
$symptoms = ["fever", "cough", "fatigue", "pain", "covid"];

foreach ($symptoms as $symptom) {
    if (strpos($userMessage, $symptom) !== false) {
        // Update count in database
        $stmt = $conn->prepare("UPDATE data_count SET count = count + 1 WHERE symptom = ?");
        $stmt->bind_param("s", $symptom);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

?>
