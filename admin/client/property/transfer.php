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
                            <h3 class="mb-0">Property</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Property</li>
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

                        <div class="card mb-6">

                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Project Name</th>
                                            <th>Type</th>
                                            <th>Membership No.</th>
                                            <th>Form No</th>
                                            <th>Block Name</th>
                                            <th>Nominee Name</th>
                                            <th>Booking Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Example Project</td>
                                            <td>Residential</td>
                                            <td>12345</td>
                                            <td>F-001</td>
                                            <td>A Block</td>
                                            <td>John Doe</td>
                                            <td>Arif Hussain</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-end">
                                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                                </ul>
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