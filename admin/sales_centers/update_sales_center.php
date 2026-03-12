<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Update Center</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Update Center" />
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
          <a href="../index.php" class="brand-link">
            
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
                <h3 class="mb-0">Update Center</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="sales_centers.php">Centers List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Center</li>
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
                <div class="card card-warning mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0">Update Center (ID: 1)</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- 
                    In a real application, you would fetch the data based on an ID
                    (e.g., update_center.php?id=1) and pre-fill the values.
                  -->
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                      
                      <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="Head Office, Islamabad" required>
                      </div>
                      
                      <div class="mb-3">
                        <label for="detail" class="form-label">Detail <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="detail" name="detail" rows="6" required>Silver Square Plaza, Plot # 15, Street # 73,
Mehr Ali Road, F-11 Markaz, Islamabad.
Toll Free : 00800-SMART (76278)
UAN : +92 51 111 444 475
Tel : +92 51 2224301 - 04
Email: sales@smartcitypk.com</textarea>
                      </div>

                      <div class="mb-3">
                        <label for="image" class="form-label">Change Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div classid="imageHelp" class="form-text">Current image: <!-- Image name was not provided --></div>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-warning">Update</button>
                      <a href="sales_centers.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
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
    <script src="../js/adminlte.js"></script>
  </body>
</html>
