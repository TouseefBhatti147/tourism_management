<?php
session_start();

// If user is NOT logged in → redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Real Estate E-system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="preload" href="./css/adminlte.css" as="style" />
    <link rel="stylesheet" href="./css/font-family.css" />
    <link rel="stylesheet" href="./css/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="./css/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="./css/adminlte.css" />
    <link rel="stylesheet" href="./css/apexcharts.css" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">

        <!-- Header -->
        <?php require("includes/header.php"); ?>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-light-subtle shadow" data-bs-theme="light">
            <div class="sidebar-brand">
                <a href="index.php" class="brand-link">
                    <span class="brand-text fw-light">Real Estate E-System</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">

            <!-- Page Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="app-content">
                <div class="container-fluid">
                    <?php include("admin-dashboard.php"); ?>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <?php include("includes/footer.php"); ?>

    </div>

    <?php include("includes/scripts.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
