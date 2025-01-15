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

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&family=Ubuntu:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <!-- CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/e3ffb3fff0.js" crossorigin="anonymous"></script>

    <!-- Bootstrap scripts-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>
<body>
    <div class="header">
            <h1>NaviChat</h1>
            <a class="logout" href="../RegisteredUser/logoutConfirmation.php" >
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </a>
            
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="sidebar">
                <ul>
                    <li><a href="#">Manage Tickets</a></li>
                    <li>
                        <a href="#">Configure Chatbot &#9662;</a>
                        <ul class="dropdown">
                            <li><a href="answerTemplates.php">Manage Answer Templates</a></li>
                            <li><a href="#">Installation Guide</a></li>
                            <li><a href="#">Select Industry</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Live Chat</a></li>
                    <li><a href="#">Trends</a></li>
                    <li><a href="#">Analytics</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="viewProfile.php" >Profile</a></li>
                    <li><a href="subscription.php">Subscription</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-8">
           
        </div>
    </div>
  
</body>
</html>

