<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us - Real Estate E-System</title>
    <?php require("header.php"); ?>
</head>

<body>

<!-- Navbar -->
  <?php require("navbar.php"); ?>

<!-- Header Image Section -->
<header class="contact-header position-relative">
    <img src="./assets/img/login-bg.jpeg" class="header-img" alt="Property Image">
    <div class="header-overlay"></div>
    <div class="header-content text-center">
        <h1 class="fw-bold text-white">Contact Us</h1>
        <p class="text-light">We are here to help you find your dream property</p>
    </div>
</header>
 
<!-- Contact Form Section (One Row Layout) -->
<section class="py-5">
    <div class="container">
        <h3 class="fw-bold text-center mb-5">Send Us a Message</h3>

        <div class=" p-5 rounded form-box">

            <form>

                <div class="row g-4">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter your full name" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" class="form-control" placeholder="Enter your phone number">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea rows="5" class="form-control" placeholder="Write your message…" required></textarea>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-primary px-5 py-2">Submit</button>
                </div>

            </form>

        </div>
    </div>
</section>
 

<?php require("footer.php"); ?>
<?php require("script.php"); ?>
</body>
</html>
