<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Add Country</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Add Country" />
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
                <h3 class="mb-0">Add Country</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="countries.php">Countries List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add Country</li>
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
                <div class="card card-success mb-4">
                  <div class="card-header">
                    <h3 class="card-title mb-0">New Country Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- Note the 'id' for the JavaScript to find the form -->
                  <form id="addCountryForm" method="POST">
                    <div class="card-body">

                      <!-- Form Message Feedback -->
                      <div id="formMessage" class="alert" style="display: none;"></div>

                      <div class="mb-3">
                        <label for="countryName" class="form-label">Country Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="countryName" name="countryName" placeholder="Enter Country Name" required>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-success">Submit</button>
                      <a href="countries.php" class="btn btn-secondary ms-2">Cancel</a>
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

    <!-- AJAX Form Submission Script -->
    <script>
      document.getElementById('addCountryForm').addEventListener('submit', function(event) {

        // Prevent the default form submission
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const messageDiv = document.getElementById('formMessage');

        // Display a loading message
        messageDiv.style.display = 'block';
        messageDiv.className = 'alert alert-info';
        messageDiv.textContent = 'Submitting country...';

        // Send the data using Fetch API
        fetch('ajax_add_country.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Show success message
            messageDiv.className = 'alert alert-success';
            messageDiv.textContent = data.message;
            // Reset the form
            form.reset();
          } else {
            // Show error message
            messageDiv.className = 'alert alert-danger';
            messageDiv.textContent = data.message;
          }
        })
        .catch(error => {
          // Show network or server error
          messageDiv.className = 'alert alert-danger';
          messageDiv.textContent = 'An error occurred. Please check the console.';
          console.error('AJAX Error:', error);
        });
      });
    </script>
  </body>
</html>
