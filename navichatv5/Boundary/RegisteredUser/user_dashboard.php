
<?php
include_once("../../dbCfg.php");

$sql = "SELECT symptom, count FROM data_count";
$result = $conn->query($sql);

$symptomData = [];
while ($row = $result->fetch_assoc()) {
    $symptomData[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User_dashboard</title>
    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/userDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap scripts-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- Chart.js for Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <div class="sidebar">
        <a href="#" class="menu-item active" data-section="analytics">Analytics</a>
        <a href="#" class="menu-item" data-section="installation">Installation Guide</a>
        <a href="viewProfile.php" class="menu-item">Profile</a>
        <a href="subscription.php"class="menu-item">Subscription</a>
        <a href="../../index.php" class="logout-btn">Logout</a>
    </div>

    <!-- Analytics Section -->
<div id="analytics" class="section active">
    <h2>Chatbot Analytics</h2>  
    <div class="analytics-container">
        <table class="analytics-table">
            <tr>
                <th>Symptom</th>
                <th>Reported Cases</th>
            </tr>
            <?php foreach ($symptomData as $symptom): ?>
            <tr>
                <td><?php echo htmlspecialchars($symptom['symptom']); ?></td>
                <td><?php echo htmlspecialchars($symptom['count']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <canvas id="symptomChart"></canvas>
    </div>
</div>

<script>
// Prepare data for Chart.js
const symptomLabels = <?php echo json_encode(array_column($symptomData, 'symptom')); ?>;
const symptomCounts = <?php echo json_encode(array_column($symptomData, 'count')); ?>;

// Create Chart
const ctx = document.getElementById('symptomChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: symptomLabels,
        datasets: [{
            label: 'Reported Cases',
            data: symptomCounts,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>

