<?php
include_once("../../dbCfg.php");

$table = $_POST['table'] ?? null;
$identifier = $_POST['identifier'] ?? null;

if (!$table || !$identifier) {
    $errors[] = "Invalid input data.";
    header("Location: ../../Boundary/Admin/admin_dashboard.php?" . http_build_query(['error' => $errors[0]]));
    exit();
}

try {
    if ($table === 'faq') {
        $title = $_POST['title'] ?? null;
        $details = $_POST['details'] ?? null;

        if (!$title || !$details) {
            throw new Exception("Missing FAQ fields.");
        }

        $sql = "UPDATE faq SET title = ?, details = ? WHERE title = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $details, $identifier);
    } elseif ($table === 'pricing') {
        $tier = $_POST['tier'] ?? null;
        $price = $_POST['price'] ?? null;
        $features = $_POST['features'] ?? null;

        if (!$tier || !$price || !$features) {
            throw new Exception("Missing Pricing fields.");
        }

        $sql = "UPDATE pricing SET tier = ?, price = ?, features = ? WHERE tier = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $tier, $price, $features, $identifier);
    } elseif ($table === 'testimonials') {
        $review = $_POST['review'] ?? null;
        $reviewer = $_POST['reviewer'] ?? null;

        if (!$review || !$reviewer) {
            throw new Exception("Missing Testimonial fields.");
        }

        $sql = "UPDATE testimonials SET review = ?, reviewer = ? WHERE review = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $review, $reviewer, $identifier);
    } else {
        throw new Exception("Unknown table type.");
    }

    if ($stmt->execute()) {
        header("Location: ../../Boundary/Admin/admin_dashboard.php?" . http_build_query(['success' => "Content updated successfully!"]));
    } else {
        throw new Exception("Failed to execute query: " . $stmt->error);
    }
} catch (Exception $e) {
    header("Location: ../../Boundary/Admin/admin_dashboard.php?" . http_build_query(['error' => $e->getMessage()]));
} finally {
    $stmt->close();
    $conn->close();
}
?>
