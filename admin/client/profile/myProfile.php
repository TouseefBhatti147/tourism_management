<?php session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <title>Real Estate E-system</title>
    <meta name="description" content="Admin Dashboard..." />
    <?php include("../../includes/headerLinks.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        <?php require("../../includes/header.php"); ?>

        <!-- Sidebar  client = bg-light-subtle, data-bs-theme= light , dark = bg-body-secondary , data-bs-theme= dark -->
        <aside class="app-sidebar  bg-light-subtle shadow" data-bs-theme="light">
            <div class="sidebar-brand">
                <a href="index.php" class="brand-link">
                    <span class="brand-text fw-light">Real Estate E-System</span>
                </a>
            </div>
            <?php include("../../includes/sidebar.php"); ?>
        </aside>

        <!-- Main Content -->
        <main class="app-main">

            <!--begin::App Content Header-->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Profile</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content Header-->

            <!--begin::App Content-->
            <div class="app-content">
                <div class="container-fluid">

                    <div class="col-md-12">

                        <div class="row">
                            <!-- Left Side (Image + Name) -->
                            <div class="col-md-3 text-center">
                                <div class="card p-3 ">
                                    <img src="../../assets//img//avatar2.png" class="ms-auto me-auto mt-0 mb-0 img-thumbnail" style="width:100%; max-width:220px;">
                                    <h5 class="mt-3 p-2" style="background:#1d79a7; color:white; border-radius:4px;">
                                        Ghulam Hussain
                                    </h5>
                                </div>
                            </div>

                            <!-- Right Side (Information Table) -->
                            <div class="col-md-9">
                                <table class="table table-bordered">

                                    <!-- Section: Personal Info -->
                                    <tr style="background:#1d79a7; color:white;">
                                        <th colspan="2">Personal Information</th>
                                    </tr>
                                    <tr>
                                        <th style="width:200px;">CNIC/NICOP</th>
                                        <td>3630218159145</td>
                                    </tr>
                                    <tr>
                                        <th>Father/Spouse</th>
                                        <td><span style="color:green;">s/o:</span> Mohammad Pehlwan</td>
                                    </tr>

                                    <!-- Section: Location -->
                                    <tr style="background:#1d79a7; color:white;">
                                        <th colspan="2">Location</th>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>Jhangir Abad, PO Khad Factory, Multan City, District, Multan</td>
                                    </tr>
                                    <tr>
                                        <th>Country, City</th>
                                        <td>Pakistan, Multan, Rawalpindi</td>
                                    </tr>

                                    <!-- Section: Contact Info -->
                                    <tr style="background:#1d79a7; color:white;">
                                        <th colspan="2">Contact Information</th>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>ghussain2000@yahoo.com</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>0304-2070252</td>
                                    </tr>
                                    <tr>
                                        <th>Alternative Phone</th>
                                        <td>0304-2070252</td>
                                    </tr>

                                    <!-- Section: Activity -->
                                    <tr style="background:#1d79a7; color:white;">
                                        <th colspan="2">Activity</th>
                                    </tr>
                                    <tr>
                                        <th>Joined</th>
                                        <td>28-03-2015</td>
                                    </tr>

                                </table>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
            <!--end::App Content-->

        </main>


        <!-- Footer -->
        <?php include("../../includes/footer.php"); ?>
    </div>

    <?php include("../../includes/scripts.php"); ?>

</body>

</html>