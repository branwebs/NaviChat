<?php
include_once("../../dbCfg.php");

$table = $_POST['table'];
$identifier = $_POST['identifier'];

if ($table === 'faq') {
    $title = $_POST['title'];
    $details = $_POST['details'];

    $sql = "UPDATE faq SET title = ?, details = ? WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $details, $identifier);
} elseif ($table === 'pricing') {
    $tier = $_POST['tier'];
    $price = $_POST['price'];
    $features = $_POST['features'];

    $sql = "UPDATE pricing SET tier = ?, price = ?, features = ? WHERE tier = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $tier, $price, $features, $identifier);
} elseif ($table === 'testimonials') {
    $review = $_POST['review'];
    $reviewer = $_POST['reviewer'];

    $sql = "UPDATE testimonials SET review = ?, reviewer = ? WHERE review = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $review, $reviewer, $identifier);
}

if ($stmt->execute()) {
    $success[] = "Content updated successfully!";
    header("Location: ../../Boundary/Admin/admin_dashboard.php" . urlencode($success[0]));
    exit();
} else {
    $errors[] = "Content Update Failed";
    header("Location: ../../Boundary/Admin/admin_dashboard.php" . urlencode($errors[0]));
    exit();
}


$stmt->close();
$conn->close();
?>
