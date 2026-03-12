<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Us - Real Estate E-System</title>
    <?php require("header.php"); ?>
</head>

<body>

<!-- Navbar -->
<?php require("navbar.php"); ?>

<!-- Header Image -->
<header class="contact-header position-relative">
    <img src="./assets/img/login-bg.jpeg" class="header-img" alt="About Header">
    <div class="header-overlay"></div>
    <div class="header-content text-center">
        <h1 class="fw-bold text-white">About Us</h1>
        <p class="text-light">Building Trust. Delivering Excellence.</p>
    </div>
</header>

<!-- About Section -->
<section class="py-5">
    <div class="container">

        <h3 class="fw-bold text-center mb-5">Who We Are</h3>

        <div class="row g-5 align-items-center">
            <div class="col-md-6">
   <img src="https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=1600&q=80" 
         class="about-us-img" 
         alt="About Header">            </div>

            <div class="col-md-6">
                <h4 class="fw-bold mb-3">A Trusted Name in Real Estate</h4>
                <p class="text-muted">
                    Our Real Estate E-System is dedicated to simplifying property buying,
                    selling, and investment through innovation, transparency, and trust.
                    We aim to provide a seamless real estate experience backed by modern
                    technology and expert guidance.
                </p>

                <p class="text-muted">
                    Just like renowned real-estate organizations, our mission is to
                    inspire confidence among clients by delivering high-quality services
                    and reliable information. From residential to commercial projects,
                    we strive to ensure customer satisfaction at every step.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5" style="background: var(--color-bg-light);">
    <div class="container">

        <h3 class="fw-bold text-center mb-5">Our Mission & Vision</h3>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="service-box h-100">
                    <h5 class="fw-bold">Our Mission</h5>
                    <p class="text-muted">
                        Our mission is to provide a modern, efficient, and transparent
                        platform that connects buyers, sellers, and investors. We aim to
                        empower people with accurate property information and a user-friendly
                        experience that simplifies real-estate decisions.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="service-box h-100">
                    <h5 class="fw-bold">Our Vision</h5>
                    <p class="text-muted">
                        Our vision is to become one of the most trusted and leading real-estate
                        service platforms, known for integrity, innovation, and excellence.
                        We aspire to set new benchmarks in digital real-estate solutions.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Values -->
<section class="py-5">
    <div class="container">

        <h3 class="fw-bold text-center mb-5">Our Core Values</h3>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="service-box text-center h-100">
                    <i class="bi bi-shield-check"></i>
                    <h5>Integrity</h5>
                    <p class="text-muted">We believe in honesty and transparency in every interaction.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="service-box text-center h-100">
                    <i class="bi bi-people-fill"></i>
                    <h5>Commitment</h5>
                    <p class="text-muted">We are dedicated to helping customers make confident decisions.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="service-box text-center h-100">
                    <i class="bi bi-lightbulb"></i>
                    <h5>Innovation</h5>
                    <p class="text-muted">We continuously improve by using modern technology solutions.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require("footer.php"); ?>
<?php require("script.php"); ?>

</body>
</html>
