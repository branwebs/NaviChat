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
    require_once 'dbCfg.php';
    ?>


    <section class="colored-section" id="title">

        <div class="container-fluid">

            <!-- Nav Bar -->

            <nav class="navbar navbar-expand-lg navbar-dark">

                <a class="navbar-brand" href="">NaviChat</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

                    <!-- Left-aligned navigation items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#faq">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimonials">Reviews</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pricing">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Contact</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="Boundary/Users/userLogin.php">
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
                    <a href="Boundary/Users/register.php" class="btn btn-dark btn-lg download-button">
                        <i class="fa-regular fa-pen-to-square"></i> Register
                    </a>
                </div>

            </div>

        </div>

    </section>


    <!-- FAQ -->

    <section class="white-section" id="faq">
        <div class="container-fluid">
            <div class="row">
                <?php
                $faqQuery = "SELECT title, details FROM faq";
                $faqResult = $conn->query($faqQuery);

                if ($faqResult->num_rows > 0) {
                    while ($row = $faqResult->fetch_assoc()) {
                        echo '<div class="feature-box col-lg-4">';
                        echo '<i class="icon fas fa-check-circle fa-4x"></i>';
                        echo '<h3 class="feature-title">' . htmlspecialchars($row['title']) . '</h3>';
                        echo '<p>' . htmlspecialchars($row['details']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No FAQs found.</p>";
                }
                ?>
            </div>
        </div>
    </section>



    <!-- Testimonials -->

    <section class="colored-section" id="testimonials">
        <div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $testimonialQuery = "SELECT review, reviewer FROM testimonials";
                $testimonialResult = $conn->query($testimonialQuery);
                $isActive = true;

                if ($testimonialResult->num_rows > 0) {
                    while ($row = $testimonialResult->fetch_assoc()) {
                        echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . ' container-fluid">';
                        echo '<h2 class="testimonial-text">' . htmlspecialchars($row['review']) . '</h2>';
                        echo '<em>' . htmlspecialchars($row['reviewer']) . '</em>';
                        echo '</div>';
                        $isActive = false;
                    }
                } else {
                    echo "<p>No testimonials found.</p>";
                }
                ?>
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
            <?php
            $pricingQuery = "SELECT tier, price, features FROM Pricing";
            $pricingResult = $conn->query($pricingQuery);

            if ($pricingResult->num_rows > 0) {
                while ($row = $pricingResult->fetch_assoc()) {
                    echo '<div class="pricing-column col-lg-4 col-md-6">';
                    echo '<div class="card">';
                    echo '<div class="card-header">';
                    echo '<h3>' . htmlspecialchars($row['tier']) . '</h3>';
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<h2 class="price-text">$' . htmlspecialchars($row['price']) . ' / mo</h2>';
                    echo '<p>' . nl2br(htmlspecialchars($row['features'])) . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<p>No pricing plans found.</p>";
            }
            ?>
        </div>
    </section>


    <!-- Call to Action -->

    <section class="colored-section" id="cta">

        <div class="container-fluid">

            <h3 class="big-heading">Join us now and enhance your businesses!</h3>
            <a href="Boundary/Users/register.php" class="btn btn-dark btn-lg download-button">
                <i class="fa-regular fa-pen-to-square"></i> Register
            </a>
            <button class="download-button btn btn-lg brn-light" type="button"><i class="fa-solid fa-phone"></i> Contact Us</button>
        </div>
    </section>


    <!-- Footer -->

    <footer class="white-section" id="footer">
        <div class="container-fluid">
            <i class="social-icon fab fa-facebook-f"></i>
            <i class="social-icon fab fa-instagram"></i>
            <i class="social-icon fas fa-envelope"></i>
            <p>© Copyright 2024 NaviChat</p>
        </div>
    </footer>


</body>

</html>