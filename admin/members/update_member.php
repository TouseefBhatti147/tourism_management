<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Update Member</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Update Member" />
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
                <h3 class="mb-0">Update Member</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="members.php">Members List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Member</li>
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
                    <h3 class="card-title mb-0">Update Member Details (ID: 2)</h3>
                  </div>
                  <!-- /.card-header -->
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card-body">

                      <div class="mb-3">
                        <label for="memberName" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="memberName" name="memberName" placeholder="Enter Full Name" value="Naeem Akhter Chaudhary" required>
                      </div>

                      <div class="mb-3">
                        <label for="memberFatherSpouse" class="form-label">Father/Spouse Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="memberFatherSpouse" name="memberFatherSpouse" placeholder="Enter Father's or Spouse's Name" value="Khalid Iftikhar Manzoor" required>
                      </div>

                      <div class="mb-3">
                        <label for="memberCNIC" class="form-label">CNIC <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="memberCNIC" name="memberCNIC" placeholder="Enter CNIC (e.g., 12345-6789012-3)" value="4230138959244" required>
                      </div>

                      <div class="mb-3">
                        <label for="memberAddress" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="memberAddress" name="memberAddress" rows="3" placeholder="Enter Full Postal Address" required>335-GG,Phase -4 DHA Lahore</textarea>
                      </div>

                      <div class="mb-3">
                        <label for="memberImage" class="form-label">Image</label>
                        <input type="file" class="form-control" id="memberImage" name="memberImage">
                        <!-- Add logic to display current image if available -->
                      </div>

                      <div class="mb-3">
                        <label for="memberStatus" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="memberStatus" name="memberStatus" required>
                          <option value="Active" selected>Active</option>
                          <option value="In-Active">In-Active</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <label for="memberSecurityStatus" class="form-label">Security Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="memberSecurityStatus" name="memberSecurityStatus" required>
                          <option value="Not Verified" selected>Not Verified</option>
                          <option value="Cleared">Cleared</option>
                          <option value="Pending">Pending</option>
                        </select>
                      </div>

                      <!-- Fields for Username/Password are often handled on a separate page for security -->
                      <!-- You can add them here if needed, but leave them blank by default for security -->
                       <div class="mb-3">
                        <label for="memberUsername" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="memberUsername" name="memberUsername" placeholder="Enter Username" value="naeem.akhter" required>
                      </div>

                       <div class="mb-3">
                        <label for="memberPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="memberPassword" name="memberPassword" placeholder="Leave blank to keep current password">
                         <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                      </div>


                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-warning">Update Member</button>
                      <a href="members.php" class="btn btn-secondary ms-2">Cancel</a>
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
