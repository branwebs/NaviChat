<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;900&family=Ubuntu:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <!-- CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://kit.fontawesome.com/e3ffb3fff0.js" crossorigin="anonymous"></script>

    <!-- Bootstrap scripts-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>


    </style>
</head>

<body>
    <?php
    include_once("db_Connect.php");
    session_start();

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uid = $_POST["uid"];
        $type = $_POST["user_type"];

        // Check if fields are filled
        if (empty($uid) || empty($type) || $type == '0') {
            $errors[] = "Please fill in all fields.";
        } else {

            $stmt = $conn->prepare("SELECT * FROM users WHERE uid = ? AND type = ?");
            $stmt->bind_param("si", $uid, $type);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if there is a matching record
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Set session and redirect based on user type
                if ($type === '1') {
                    $_SESSION['uid'] = $_POST["uid"];
                    $_SESSION['user_type'] = $_POST["user_type"];
                    header("Location: user_dashboard.php");
                    exit();
                } else if ($type === '2') {
                    $_SESSION['uid'] = $_POST["uid"];
                    $_SESSION['user_type'] = $_POST["user_type"];
                    header("Location: admin_dashboard.php");
                    exit();
                }
            } else {
                $errors[] = "Invalid credentials. Please try again.";
            }
        }
    }
    ?>


    <section class="colored-section" id="title">

        <div class="container-fluid">

            <!-- Nav Bar -->

            <nav class="navbar navbar-expand-lg navbar-dark">

                <a class="navbar-brand" href="">NaviBot</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

                    <!-- Left-aligned navigation items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pricing">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faq">FAQ</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="Boundary/userLogin.php">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                            </a>
                        </li>
                    </ul>

                </div>
            </nav>


            <!-- Title -->

            <div class="row">

                <div class="col-lg-6">
                    <h1 class="big-heading">Enhance your business with AI customer service.</h1>
                    <button type="button" class="btn btn-dark btn-lg download-button"><i class="fa-regular fa-pen-to-square"></i> Register</button>
                </div>

            </div>

        </div>

    </section>


    <!-- FAQ -->

    <section class="white-section" id="faq">

        <div class="container-fluid">

            <div class="row">
                <div class="feature-box col-lg-4">
                    <i class="icon fas fa-check-circle fa-4x"></i>
                    <h3 class="feature-title">What are the benefits of NaviChat?</h3>
                    <p>Increase customer satisfaction: NaviBot analyzes customer questions and delivers human-like answers in seconds. This enables your customers to receive the information they need 24/7, increasing their satisfaction.</p>
                </div>

                <div class="feature-box col-lg-4">
                    <i class="icon fas fa-bullseye fa-4x"></i>
                    <h3 class="feature-title">Is NaviChat easy to use?</h3>
                    <p>Our design is user friendly and all controlled in the user dashboard convieneintly.</p>
                </div>

                <div class="feature-box col-lg-4">
                    <i class="icon fas fa-heart fa-4x"></i>
                    <h3 class="feature-title">Is NaviChat Effective?</h3>
                    <p>Yes as shown in our reviews many of our customers have seen a significant increase in customer retention and sales.</p>
                </div>
            </div>


        </div>
    </section>


    <!-- Testimonials -->

    <section class="colored-section" id="testimonials">

        <div id="testimonial-carousel" class="carousel slide" data-ride="false">
            <div class="carousel-inner">
                <div class="carousel-item active container-fluid">
                    <h2 class="testimonial-text">After using this chatbot service for my business my sales have went up significantly!</h2>
                    <em>Jamie, Founder of SlappyCakes</em>
                </div>
                <div class="carousel-item container-fluid">
                    <h2 class="testimonial-text">I used to be overwhelmed with customer enquries but now all quieres are answered promptly and customers are satisfied!</h2>
                    <em>Sophie, Customer Service Agent at Beds&Pillows</em>
                </div>
            </div>
            <a class="carousel-control-prev" href="#testimonial-carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#testimonial-carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>

    </section>


    <!-- Press -->

    <section class="colored-section" id="press">
        <img class="press-logo" src="images/techcrunch.png" alt="tc-logo">
        <img class="press-logo" src="images/tnw.png" alt="tnw-logo">
        <img class="press-logo" src="images/bizinsider.png" alt="biz-insider-logo">
        <img class="press-logo" src="images/mashable.png" alt="mashable-logo">

    </section>


    <!-- Pricing -->

    <section class="white-section" id="pricing">

        <h2 class="section-heading">Our Subscription Plan</h2>
        <p>Simple plan with all the features!</p>

        <div class="row">

            <div class="pricing-column col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Starter</h3>
                    </div>
                    <div class="card-body">
                        <h2 class="price-text">$29 /mo</h2>
                        <p>Chatbot API</p>
                        <p>Ticketing Feature</p>
                    </div>
                </div>
            </div>


            <div class="pricing-column col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Premium</h3>
                    </div>
                    <div class="card-body">
                        <h2 class="price-text">$59 / mo</h2>
                        <p>Chatbot API</p>
                        <p>Ticketing Feature</p>
                        <p>Analysis and monitoring</p>
                        <p>Prioirity Support</p>
                    </div>
                </div>
            </div>



        </div>

    </section>


    <!-- Call to Action -->

    <section class="colored-section" id="cta">

        <div class="container-fluid">

            <h3 class="big-heading">Join us now and enhance your businesses!</h3>
            <button class="download-button btn btn-lg btn-dark" type="button"><i class="fa-regular fa-pen-to-square"></i> Register</button>
            <button class="download-button btn btn-lg brn-light" type="button"><i class="fab fa-google-play"></i> Contact Us</button>
        </div>
    </section>


    <!-- Footer -->

    <footer class="white-section" id="footer">
        <div class="container-fluid">
            <i class="social-icon fab fa-facebook-f"></i>
            <i class="social-icon fab fa-twitter"></i>
            <i class="social-icon fab fa-instagram"></i>
            <i class="social-icon fas fa-envelope"></i>
            <p>© Copyright 2024 NaviChat</p>
        </div>
    </footer>


</body>

</html>