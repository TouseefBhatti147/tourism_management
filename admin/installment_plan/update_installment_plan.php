<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Update Installment Plan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Update Installment Plan" />
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
                <h3 class="mb-0">Update Installment Plan</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="installment_plan.php">Installment Plan List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Installment Plan</li>
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
                    <h3 class="card-title mb-0">Update Installment Plan (ID: 1)</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- 
                    In a real application, you would fetch the data based on an ID
                    (e.g., update_installment_plan.php?id=1) and pre-fill the values.
                    I've pre-filled it with the example data for ID 1.
                  -->
                  <form action="" method="POST">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4">
                           <div class="mb-3">
                            <label for="projectSelect" class="form-label">Project <span class="text-danger">*</span></label>
                            <select id="projectSelect" name="projectName" class="form-select" required>
                              <option value="" disabled>Please Select Project</option>
                              <option selected>Royal Orchard Multan</option>
                              <option>Royal Orchard Sargodha</option>
                              <option>Royal Orchard Sahiwal</option>
                            </select>
                          </div>
                        </div>
                         <div class="col-md-4">
                           <div class="mb-3">
                            <label for="sizeSelect" class="form-label">Size <span class="text-danger">*</span></label>
                            <select id="sizeSelect" name="size" class="form-select" required>
                                <option value="" disabled>Please Select Size</option>
                                <option>5 Marla</option>
                                <option selected>8 Marla</option>
                                <option>10 Marla</option>
                                <option>12 Marla</option>
                                <option>1 Kanal</option>
                                <option>2 Kanal</option>
                                <option>4 Marla (Com)</option>
                                <option>2 Marla (Com)</option>
                                <option>6 Marla (Com)</option>
                                <option>9 Marla (Com)</option>
                                <option>8 Marla (Com)</option>
                                <option>12 Marla (Com)</option>
                                <option>10 Marla (Com)</option>
                                <option>6.7 Marla (Com)</option>
                                <option>8.9 Marla (Com)</option>
                                <option>3 Kanal</option>
                                <option>15 Marla</option>
                                <option>6 Marla</option>
                                <option>7 Marla</option>
                                <option>1.88 Marla</option>
                                <option>1.81 Marla</option>
                                <option>7.5 Marla</option>
                                <option>3.5 Marla</option>
                                <option>4.1 Marla</option>
                                <option>4 Marla</option>
                                <option>2 Kanal (Com)</option>
                                <option>4 Kanal (Com)</option>
                                <option>1 Kanal (Com)</option>
                                <option>4 Kanal</option>
                            </select>
                          </div>
                        </div>
                         <div class="col-md-4">
                           <div class="mb-3">
                            <label for="typeSelect" class="form-label">Property Type <span class="text-danger">*</span></label>
                            <select id="typeSelect" name="propertyType" class="form-select" required>
                              <option value="" disabled>Select Property Type</option>
                              <option selected>Residential</option>
                              <option>Commercial</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      
                      <div class="mb-3">
                        <label for="planDescription" class="form-label">Plan Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="planDescription" name="planDescription" rows="3" required>8.25 Marla - Smart Homes (30-M Default) Price=12,500,000 with Construction</textarea>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label for="totalInstallments" class="form-label">Total No. <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="totalInstallments" name="totalInstallments" value="30" required>
                          </div>
                        </div>
                        <div class="col-md-6">
                           <div class="mb-3">
                            <label for="totalAmount" class="form-label">Total Amount <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="totalAmount" name="totalAmount" step="0.01" value="12500000" required>
                          </div>
                        </div>
                      </div>

                      <hr>
                      <h5 class="mb-3">Installment Details</h5>
                      <div class="row">
                        <!-- Installment 1-4 -->
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment1" class="form-label">1.</label>
                            <input type="number" class="form-control" id="installment1" name="installment1" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment2" class="form-label">2.</label>
                            <input type="number" class="form-control" id="installment2" name="installment2" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment3" class="form-label">3.</label>
                            <input type="number" class="form-control" id="installment3" name="installment3" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment4" class="form-label">4.</label>
                            <input type="number" class="form-control" id="installment4" name="installment4" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <!-- Installment 5-8 -->
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment5" class="form-label">5.</label>
                            <input type="number" class="form-control" id="installment5" name="installment5" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment6" class="form-label">6.</label>
                            <input type="number" class="form-control" id="installment6" name="installment6" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment7" class="form-label">7.</label>
                            <input type="number" class="form-control" id="installment7" name="installment7" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment8" class="form-label">8.</label>
                            <input type="number" class="form-control" id="installment8" name="installment8" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <!-- Installment 9-12 -->
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment9" class="form-label">9.</label>
                            <input type="number" class="form-control" id="installment9" name="installment9" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment10" class="form-label">10.</label>
                            <input type="number" class="form-control" id="installment10" name="installment10" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment11" class="form-label">11.</label>
                            <input type="number" class="form-control" id="installment11" name="installment11" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment12" class="form-label">12.</label>
                            <input type="number" class="form-control" id="installment12" name="installment12" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <!-- Installment 13-16 -->
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment13" class="form-label">13.</label>
                            <input type="number" class="form-control" id="installment13" name="installment13" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment14" class="form-label">14.</label>
                            <input type="number" class="form-control" id="installment14" name="installment14" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment15" class="form-label">15.</label>
                            <input type="number" class="form-control" id="installment15" name="installment15" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment16" class="form-label">16.</label>
                            <input type="number" class="form-control" id="installment16" name="installment16" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <!-- Installment 17-20 -->
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment17" class="form-label">17.</label>
                            <input type="number" class="form-control" id="installment17" name="installment17" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment18" class="form-label">18.</label>
                            <input type="number" class="form-control" id="installment18" name="installment18" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment19" class="form-label">19.</label>
                            <input type="number" class="form-control" id="installment19" name="installment19" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label for="installment20" class="form-label">20.</label>
                            <input type="number" class="form-control" id="installment20" name="installment20" placeholder="Amount" step="0.01" value="0">
                          </div>
                        </div>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-warning">Update</button>
                      <a href="installment_plan.php" class="btn btn-secondary ms-2">Cancel</a>
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

