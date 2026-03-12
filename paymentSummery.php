<?php session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Real Estate E-system</title>
    <meta name="description" content="Admin Dashboard..." />
        <?php require("./admin/includes/headerLinks.php"); ?>


</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <!-- Header -->
        <?php require("./admin/includes/header.php"); ?>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-light-subtle shadow" data-bs-theme="light">
            <div class="sidebar-brand">
                <a href="index.php" class="brand-link">
                    <span class="brand-text fw-light">Real Estate E-System</span>
                </a>
            </div>

            <?php include("./sidebar-client.php"); ?>
        </aside>

        <main class="app-main">
           content <!-- page content here -->
        </main>

        <!-- Footer -->
        <?php include("../../admin/includes/footer.php"); ?>
    </div>

    <?php include("../../admin/includes/scripts.php"); ?>
</body>

</html>
