<?php 
session_start();

/* ------------------------------------
   DATABASE CONNECTION
------------------------------------- */
$conn = mysqli_connect("localhost", "root", "", "rdlpk_db1");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* ------------------------------------
   FETCH SLIDER
------------------------------------- */
$sliderQuery = "SELECT * FROM slider ORDER BY id DESC";
$sliderResult = mysqli_query($conn, $sliderQuery);

/* ------------------------------------
   FETCH PROJECTS (Top 3 Active)
------------------------------------- */
$projectQuery = "SELECT * FROM projects WHERE status = 1 ORDER BY id DESC LIMIT 3";
$projectResult = mysqli_query($conn, $projectQuery);

/* ------------------------------------
   FETCH NEWS (Latest 5)
------------------------------------- */
$newsQuery = "SELECT * FROM latest_news WHERE status = 'active' ORDER BY id DESC LIMIT 5";
$newsResult = mysqli_query($conn, $newsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Real Estate E-System - Explore Homes, Live Better</title>
    <?php require("header.php"); ?>

<style>
.destination-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
}

.heroCarousel .carousel-item img {
    width: 100%;
    height: 450px !important;
    object-fit: cover !important;
    border-radius: 10px;
}
</style>

</head>

<body>

<!-- NAVBAR -->
<?php $navbarClass = "navbar-absolute"; include("navbar.php"); ?>


<!-- HERO SECTION -->
<section class="hero">
    <img class="img" src="./assets/img/Decore.svg" alt="">
    <div class="container">
        <div class="row align-items-center">

            <!-- LEFT TEXT -->
            <div class="col-md-6">
                <p class="text-uppercase text-danger fw-bold mb-2">Your Digital Real Estate Platform</p>

                <h1>Buy & Sell Plots <br> the Smart Way</h1>

                <p>Explore, buy, and sell plots effortlessly — bringing societies and customers together through smart digital solutions.</p>

                <a href="#" class="btn btn-orange">Explore Properties</a>
            </div>

            <!-- SLIDER -->
            <div class="col-md-6">
                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">

                    <div class="carousel-indicators">
                        <?php 
                        mysqli_data_seek($sliderResult, 0);
                        $i = 0;
                        while ($slide = mysqli_fetch_assoc($sliderResult)) { ?>
                            <button type="button"
                                data-bs-target="#heroCarousel"
                                data-bs-slide-to="<?= $i ?>"
                                class="<?= ($i == 0 ? 'active' : '') ?>">
                            </button>
                        <?php $i++; } ?>
                    </div>

                    <div class="carousel-inner">
                        <?php 
                        mysqli_data_seek($sliderResult, 0);
                        $i = 0;
                        while ($slide = mysqli_fetch_assoc($sliderResult)) { ?>
                            <div class="carousel-item <?= ($i == 0 ? 'active' : '') ?>">
                                <img src="admin/assets/img/slider_images/<?= $slide['image']; ?>"
                                     alt="<?= $slide['title']; ?>">
                            </div>
                        <?php $i++; } ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>



<!-- SERVICES SECTION -->
<section class="services text-center mt-5">
    <div class="container">
        <h6 class="text-muted">CATEGORY</h6>
        <h2 class="fw-bold mb-5">Digital Real Estate Services We Provide</h2>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-map"></i>
                    <h5>Digital Plot Management</h5>
                    <p>View society maps, plot details, and real-time availability online.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-cart-check"></i>
                    <h5>Buy & Sell Plots</h5>
                    <p>Secure, transparent buying & selling for all members.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-receipt"></i>
                    <h5>Online Payment Ledger</h5>
                    <p>Track installments, dues, and payment history instantly.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="service-box">
                    <i class="bi bi-people"></i>
                    <h5>Member Portal</h5>
                    <p>Check bookings, ownership details, and profile securely.</p>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- TOP PROJECTS -->
<section class="destinations text-center mt-5">
    <div class="container">
        <h6 class="text-muted">Our Projects</h6>
        <h2 class="fw-bold mb-5">Our Top Projects</h2>

        <div class="row g-4">

        <?php if (mysqli_num_rows($projectResult) > 0) { ?>
            <?php while ($p = mysqli_fetch_assoc($projectResult)) { ?>

                <?php 
                    // NEW: only filename stored in DB
                    $imageFile = $p['project_images'] ?: "default.jpg";
                    $imagePath = "admin/assets/img/projects/" . $imageFile;
                ?>

                <div class="col-md-4">
                    <div class="card destination-card h-100 shadow-sm">

                        <!-- PROJECT IMAGE -->
                        <img src="<?= $imagePath; ?>"
                             class="card-img-top"
                             alt="<?= htmlspecialchars($p['project_name']); ?>"
                             onerror="this.src='assets/img/projects/default.jpg'">

                        <div class="card-body">
                            <h5 class="fw-bold"><?= htmlspecialchars($p['project_name']); ?></h5>

                            <p class="text-muted">
                                <?= htmlspecialchars(substr($p['teaser'], 0, 100)); ?>...
                            </p>

                            <a href="project-details.php?id=<?= $p['id']; ?>"
                               class="btn btn-sm btn-primary mt-2">
                               More Details
                            </a>
                        </div>

                    </div>
                </div>

            <?php } ?>

        <?php } else { ?>

            <p class="text-center text-muted">No projects available at the moment.</p>

        <?php } ?>

        </div>
    </div>
</section>



<!-- LATEST NEWS -->
<section class="news-section mt-5">
    <div class="container">
        <h2 class="fw-bold mb-4">Latest News</h2>

        <div class="row g-4">
        <?php while ($n = mysqli_fetch_assoc($newsResult)) { ?>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">

                    <small class="text-muted"><?= date("d M Y", strtotime($n['create_date'])); ?></small>

                    <h5 class="mt-2"><?= substr($n['teaser'], 0, 70); ?>...</h5>

                    <a href="news-details.php?id=<?= $n['id']; ?>" class="mt-3 d-block">
                       Read More →
                    </a>
                </div>
            </div>
        <?php } ?>
        </div>

    </div>
</section>



<!-- SUBSCRIBE -->
<section class="subscribe mt-5">
    <div class="container">
        <div class="subscribe-inner">
            <img class="img1" src="./assets/img/group-left.svg" alt="">
            <h3 class="fw-bold mb-5">Subscribe for Updates</h3>

            <form class="d-flex justify-content-center">
                <input type="email" placeholder="Your Email" required>
                <button class="ms-2">Subscribe</button>
            </form>

            <img class="img2" src="./assets/img/group-right.svg" alt="">
        </div>
    </div>
</section>


<!-- FOOTER -->
<?php require("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php require("script.php"); ?>

</body>
</html>
