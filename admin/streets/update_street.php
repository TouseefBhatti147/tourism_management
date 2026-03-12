<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Update Street</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Update Street" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Admin Dashboard..." />
    <meta name="keywords" content="bootstrap 5, admin dashboard, accessible, WCAG" />
    <meta name="supported-color-schemes" content="light dark" />

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/adminlte.css" />
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php require("../includes/header.php");?>

      <!-- Sidebar -->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
 <a href="..\index.php" class="brand-link">

            <img
              src="./assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <!-- Main Content -->
      <main class="app-main">
        <!-- App Content Header -->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Update Street</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="streets.php">Streets List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Street</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <!-- App Content -->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0">Update Street Details</h3>
                  </div>
                  <div class="card-body">
                    <form action="#" method="post">
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="projectId" class="form-label">Project ID <span class="text-danger">*</span></label>
                          <select id="projectId" class="form-select" required>
                            <option disabled value="">Select Project</option>
                            <option selected>Royal Orchard Multan</option>
                            <option>Royal Orchard-II, Multan</option>
                            <option>Royal Orchard Sargodha</option>
                            <option>Royal Orchard Sahiwal</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                           <label for="blockName" class="form-label">Block Name <span class="text-danger">*</span></label>
                           <select id="blockName" class="form-select" required>
                             <option disabled value="">Select Block Name</option>
                             <option selected>General Block</option>
                             <!-- Other options should be populated dynamically -->
                           </select>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-md-6 mb-3">
                          <label for="sector" class="form-label">Sector <span class="text-danger">*</span></label>
                          <select id="sector" class="form-select" required>
                            <option disabled value="">Select Sector</option>
                             <option selected>Block-A</option>
                             <!-- Other options should be populated dynamically -->
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="streetName" class="form-label">Street <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="streetName" value="Jinnah Boulevard" required>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update Street</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

     <?php include("../includes/footer.php"); ?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="./js/adminlte.js"></script>
  </body>
</html>