<?php
include_once("../../dbCfg.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Guide</title>
    
    <!-- CSS links -->
    <link rel="stylesheet" type="text/css" href="../../css/installationGuide.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap scripts-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <div class="sidebar">
        <a href="user_dashboard.php" class="menu-item" >Analytics</a>
        <a href="#" class="menu-item active" data-section="installation">Installation Guide</a>
        <a href="viewProfile.php" class="menu-item">Profile</a>
        <a href="subscription.php" class="menu-item">Subscription</a>
        <a href="../../index.php" class="logout-btn">Logout</a>
    </div>

    <!-- Installation Guide Section -->
    <div id="installation" class="section active">
        <h2>Chatbot Installation Guide</h2>
        <div class="installation-content">
            <h3>Step 1: Download the Chatbot</h3>
            <p>Download the chatbot package from your account dashboard.</p>

            <h3>Step 2: Configure the Database</h3>
            <p>Import the database schema from <code>database.sql</code> into your MySQL database.</p>

            <h3>Step 3: Update Configuration Files</h3>
            <p>Modify <code>dbCfg.php</code> with your database credentials:</p>
            <pre>
                &lt;?php
                $servername = "your_server";
                $username = "your_username";
                $password = "your_password";
                $dbname = "your_database";
                ?&gt;
            </pre>

            <h3>Step 4: Deploy on Your Server</h3>
            <p>Upload the chatbot files to your server and ensure all dependencies are installed.</p>

            <h3>Step 5: Test the Chatbot</h3>
            <p>Visit your chatbot's URL and start testing its functionality.</p>
        </div>
    </div>
</body>
</html>
