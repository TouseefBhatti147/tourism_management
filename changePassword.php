<?php session_start(); ?>

<!doctype html>
<html lang="en">

<head>
    <title>Real Estate E-system</title>
    <meta name="description" content="Admin Dashboard..." />
    <?php include("../../admin/includes/headerLinks.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <!-- Header -->
        <?php require("../../admin/includes/header.php"); ?>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-light-subtle shadow" data-bs-theme="light">
            <div class="sidebar-brand">
                <a href="index.php" class="brand-link">
                    <span class="brand-text fw-light">Real Estate E-System</span>
                </a>
            </div>
           <?php include("../../sidebar-client.php"); ?>
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

            <div class="app-content">
                <div class="container-fluid">

                    <div class="col-md-12">
                        <div class="card mb-6">

                            <div class="card-body">

                                <!-- Old Password -->
                                <div class="mb-3">
                                    <label class="form-label">Old Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Old Password">
                                </div>

                                <!-- Info Box -->
                                <div class="alert alert-info py-2" style="font-size:14px;">
                                    Only fill new password if you want to change it!
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" class="form-control" placeholder="Enter New Password">
                                </div>

                                <!-- Confirm New Password -->
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Confirm New Password">
                                </div>

                            </div>

                            <div class="card-footer d-flex gap-3">
                                <button class="btn btn-primary">Change Password</button>
                                <button class="btn btn-secondary"><i class="fas fa-undo"></i> Reset</button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </main>

        <!-- Footer -->
        <?php include("../../admin/includes/footer.php"); ?>
    </div>

    <?php include("../../admin/includes/scripts.php"); ?>

</body>
</html>
