<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Countries List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Countries List" />
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
                <h3 class="mb-0">Countries List</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Countries List</li>
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
                  <div class="card-header d-flex align-items-center">
                    <h3 class="card-title mb-0">Countries</h3>
                    <a href="add_country.php" class="btn btn-success ms-auto">Add Country</a>
                  </div>
                  <div class="card-body">
                    <table class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Country Name</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>UAE</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                         <tr>
                          <td>2</td>
                          <td>Saudi Arabia</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                         <tr>
                          <td>3</td>
                          <td>Pakistan</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>Qatar</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                         <tr>
                          <td>5</td>
                          <td>...</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                         <tr>
                          <td>6</td>
                          <td>UK</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                         <tr>
                          <td>7</td>
                          <td>Ireland</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                         <tr>
                          <td>8</td>
                          <td>Austria</td>
                          <td>
                            <a href="update_country.php" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                   <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
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
    <script src="../js/adminlte.js"></script>
  </body>
</html>
