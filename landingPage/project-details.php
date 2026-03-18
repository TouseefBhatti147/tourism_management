<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project Details - Real Estate E-System</title>
    <?php require("header.php"); ?>
</head>
<body>

<?php require("navbar.php"); ?>

<!-- PAGE HEADER -->
<header class="contact-header position-relative">
    <img src="./assets/img/login-bg.jpeg" class="header-img" alt="Project Header">
    <div class="header-overlay"></div>
    <div class="header-content text-center">
        <h1 class="fw-bold text-white">Project Details</h1>
        <p class="text-light">Explore our featured real-estate projects</p>
    </div>
</header>


<!-- PROJECT DETAILS SECTION -->
<section class="py-5">
    <div class="container">

        <div class="row g-4 align-items-start">

            <!-- LEFT: PROJECT IMAGE -->
           <!-- LEFT: PROJECT IMAGE SLIDER -->
<div class="col-md-6">

    <div id="projectSlider" class="carousel slide shadow rounded" data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#projectSlider" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#projectSlider" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#projectSlider" data-bs-slide-to="2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=1600&q=80"
                     class="d-block w-100 rounded"
                     style="height: 350px; object-fit: cover;">
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1507089947368-19c1da9775ae?auto=format&fit=crop&w=1600&q=80"
                     class="d-block w-100 rounded"
                     style="height: 350px; object-fit: cover;">
            </div>

            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1600585154323-2e4bff8ba1a5?auto=format&fit=crop&w=1600&q=80"
                     class="d-block w-100 rounded"
                     style="height: 350px; object-fit: cover;">
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#projectSlider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#projectSlider" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

</div>


            <!-- RIGHT: PROJECT INFO -->
            <div class="col-md-6">

                <h2 class="fw-bold mb-3">Blue World City – Islamabad</h2>

                <p class="text-muted mb-3">
                    Blue World City is a magnificent housing society located near Chakri Road, Rawalpindi.
                    Known for its modern infrastructure, elegant architecture, and world-class amenities,
                    it is one of the most popular residential projects in Pakistan.
                </p>

                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <strong>Location:</strong> Chakri Road, Near M2 Motorway
                    </li>
                    <li class="list-group-item">
                        <strong>Category:</strong> Residential & Commercial
                    </li>
                    <li class="list-group-item">
                        <strong>Status:</strong> Ongoing Development
                    </li>
                    <li class="list-group-item">
                        <strong>Developer:</strong> Blue Group of Companies
                    </li>
                </ul>

                <a href="#" class="btn btn-primary">Download Brochure</a>
            </div>
        </div>

    </div>
</section>

<!-- PROJECT DESCRIPTION -->
<section class="py-5" style="background: var(--color-bg-subtle);">
    <div class="container">

        <h3 class="fw-bold mb-4">Project Overview</h3>

        <p class="text-muted">
            The project is planned to offer a luxurious living experience with advanced facilities such as a water theme park, 
            night safari, and world-class infrastructure. Designed for both investment and residential purposes, Blue World City 
            promises high returns and modern living.
        </p>

        <p class="text-muted">
            With easy installment plans and a prime location, this project is ideal for families and investors seeking
            long-term opportunities.
        </p>

    </div>
</section>

<!-- FEATURES / AMENITIES -->
<section class="py-5">
    <div class="container">

        <h3 class="fw-bold text-center mb-5">Project Amenities</h3>

        <div class="row g-4 text-center">

            <div class="col-md-3">
                <div class="service-box h-100">
                    <i class="bi bi-building"></i>
                    <h5>Modern Infrastructure</h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box h-100">
                    <i class="bi bi-tree"></i>
                    <h5>Parks & Green Areas</h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box h-100">
                    <i class="bi bi-people-fill"></i>
                    <h5>Community Centers</h5>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box h-100">
                    <i class="bi bi-lightning"></i>
                    <h5>24/7 Electricity & Security</h5>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- LOCATION MAP -->
<section class="py-5"  >
    <div class="container">

        <h3 class="fw-bold text-center mb-4">Project Location</h3>

        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="ratio ratio-16x9 shadow rounded">
                    <iframe
                        src="https://maps.google.com/maps?q=Islamabad&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        style="border:0;"
                        allowfullscreen="">
                    </iframe>
                </div>

            </div>
        </div>

    </div>
</section>


<?php require("footer.php"); ?>
<?php require("script.php"); ?>

</body>
</html>
