<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Update User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Update User" />
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
                <h3 class="mb-0">Update User</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item"><a href="users.php">User List</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update User</li>
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
                    <h3 class="card-title mb-0">Update User Details</h3>
                  </div>
                  <!-- /.card-header -->
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                      <!-- Personal Details -->
                      <h5 class="mb-3">Personal Details</h5>
                      <div class="row">
                        <div class="col-md-4 mb-3">
                          <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="firstName" name="firstName" value="Rehman" required>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="middleName" class="form-label">Middle Name</label>
                          <input type="text" class="form-control" id="middleName" name="middleName" value="Saeed">
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="lastName" class="form-label">Last Name</label>
                          <input type="text" class="form-control" id="lastName" name="lastName" value="Khan">
                        </div>
                      </div>

                      <div class="row">
                         <div class="col-md-4 mb-3">
                          <label for="so_do_wo" class="form-label">S/O-D/O-W/O <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="so_do_wo" name="so_do_wo" value="Abdul Kalam" required>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="cnic" class="form-label">CNIC <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="cnic" name="cnic" value="1234567890123" required>
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                          <input type="email" class="form-control" id="email" name="email" value="admin@example.com" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4 mb-3">
                          <label for="mobile" class="form-label">Mobile # <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="mobile" name="mobile" value="03001234567" required>
                        </div>
                        <div class="col-md-8 mb-3">
                           <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                           <input type="text" class="form-control" id="address" name="address" value="Silver Square Plaza, F-11 Markaz" required>
                        </div>
                      </div>

                       <div class="row">
                        <div class="col-md-3 mb-3">
                          <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="city" name="city" value="Islamabad" required>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="state" name="state" value="ICT" required>
                        </div>
                         <div class="col-md-3 mb-3">
                          <label for="zip" class="form-label">Zip <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="zip" name="zip" value="44000" required>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="country" name="country" value="Pakistan" required>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-3">
                           <label for="officeLocation" class="form-label">Office Location <span class="text-danger">*</span></label>
                           <select class="form-select" id="officeLocation" name="officeLocation" required>
                                <option value="" disabled>Select Office Location</option>
                                <option value="Head Office,Islamabad" selected>Head Office,Islamabad</option>
                                <option value="Multan Office">Multan Office</option>
                                <option value="Lahore Office">Lahore Office</option>
                                <option value="UAE Office">UAE Office</option>
                                <option value="Karachi Office">Karachi Office</option>
                                <option value="Sargodha Office">Sargodha Office</option>
                                <option value="Sahiwal Office">Sahiwal Office</option>
                                <option value="Regional Office, Islamabad">Regional Office, Islamabad</option>
                           </select>
                        </div>
                      </div>

                      <hr>

                      <!-- Login Details -->
                      <h5 class="mb-3">Login Details</h5>
                       <div class="row">
                         <div class="col-md-4 mb-3">
                          <label for="loginName" class="form-label">User Login Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" id="loginName" name="loginName" value="admin" placeholder="Enter username" required>
                        </div>
                         <div class="col-md-4 mb-3">
                          <label for="password" class="form-label">New Password</label>
                          <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current">
                        </div>
                         <div class="col-md-4 mb-3">
                          <label for="confirmPassword" class="form-label">Confirm New Password</label>
                          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Leave blank to keep current">
                        </div>
                       </div>

                      <hr>

                      <!-- Permissions -->
                      <h5 class="mb-3">Permissions</h5>
                      <div class="row">
                        <div class="col-md-6">
                            <h6>User Permission</h6>
                            <div class="form-check-group" style="max-height: 300px; overflow-y: auto; padding: 10px; border: 1px solid #ced4da; border-radius: .25rem;">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER1" id="perm1" checked>
                                  <label class="form-check-label" for="perm1">Add/Remove User/Setting (PER1)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER2" id="perm2" checked>
                                  <label class="form-check-label" for="perm2">Allot Plot/File to any Member/Memberplot/File Search/Add Remove New Member(PER2)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER3" id="perm3" checked>
                                  <label class="form-check-label" for="perm3">Add New Scheme(Plot/File/Street/Category,Charges,Property),Installment Plan(PER3)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER4" id="perm4">
                                  <label class="form-check-label" for="perm4">Add Pages/Menu/Downloads(PER4)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER5" id="perm5">
                                  <label class="form-check-label" for="perm5">Add Media/Image Gallery/News/Virtual Tour,News,File Manager,Slider,Center,country,City(PER5)</label>
                                </div>
                                 <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER6" id="perm6">
                                  <label class="form-check-label" for="perm6">Transfer Plot Requests (View/Update)/Allotment Requests(PER6)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER7" id="perm7">
                                  <label class="form-check-label" for="perm7">Balloting/Balloting Draw/Manage Projects(PER7)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER8" id="perm8">
                                  <label class="form-check-label" for="perm8">Message From Registered/Un-Registered Users/Email(PER8)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER9" id="perm9">
                                  <label class="form-check-label" for="perm9">Finance System(PER9)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER10" id="perm10">
                                  <label class="form-check-label" for="perm10">Finger Print Registeration/Verification(PER10)</label>
                                </div>
                                 <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER11" id="perm11">
                                  <label class="form-check-label" for="perm11">Reporting(PER11)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER12" id="perm12">
                                  <label class="form-check-label" for="perm12">Sales Centers(PER12)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER13" id="perm13">
                                  <label class="form-check-label" for="perm13">Form Management(PER13)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER14" id="perm14">
                                  <label class="form-check-label" for="perm14">Form Reporting(PER14)</label>
                                </div>
                                 <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER15" id="perm15">
                                  <label class="form-check-label" for="perm15">Form Finance(PER15)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER16" id="perm16">
                                  <label class="form-check-label" for="perm16">Form User(PER16)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER17" id="perm17">
                                  <label class="form-check-label" for="perm17">Form Editor(PER17)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER18" id="perm18">
                                  <label class="form-check-label" for="perm18">Receipt(PER18)</label>
                                </div>
                                 <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER19" id="perm19">
                                  <label class="form-check-label" for="perm19">Sales Administrator (Receipt)(PER19)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER20" id="perm20">
                                  <label class="form-check-label" for="perm20">Sales Administrator (Transfer/Allotment)(PER20)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER21" id="perm21">
                                  <label class="form-check-label" for="perm21">Receipt Administrator(PER21)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER31" id="perm31">
                                  <label class="form-check-label" for="perm31">Recovery System(PER31)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER32" id="perm32">
                                  <label class="form-check-label" for="perm32">Plot Status User(PER32)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER33" id="perm33">
                                  <label class="form-check-label" for="perm33">Cancellation (PER33)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER34" id="perm34">
                                  <label class="form-check-label" for="perm34">Audit (PER34)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="PER35" id="perm35">
                                  <label class="form-check-label" for="perm35">Manage Surcharges (PER35)</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="BCD_Mgmt" id="perm36">
                                  <label class="form-check-label" for="perm36">BCD Management</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="BCD_Report" id="perm37">
                                  <label class="form-check-label" for="perm37">BCD Reporting</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Projects Permission</h6>
                             <div class="form-check-group" style="padding: 10px; border: 1px solid #ced4da; border-radius: .25rem;">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="proj_multan" id="proj1" checked>
                                  <label class="form-check-label" for="proj1">Royal Orchard Multan</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="proj_multan_2" id="proj2" checked>
                                  <label class="form-check-label" for="proj2">Royal Orchard-II, Multan</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="proj_sargodha" id="proj3" checked>
                                  <label class="form-check-label" for="proj3">Royal Orchard Sargodha</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="proj_sahiwal" id="proj4" checked>
                                  <label class="form-check-label" for="proj4">Royal Orchard Sahiwal</label>
                                </div>
                             </div>
                        </div>
                      </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-warning">Update User</button>
                      <a href="users.php" class="btn btn-secondary ms-2">Cancel</a>
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
