<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Membership Request List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Membership Request List" />
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
                <h3 class="mb-0">Membership Request List</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Members List</li>
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
                    <h3 class="card-title mb-0">Members</h3>
                  </div>
                  <div class="card-body">

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="add_member.php" class="btn btn-success">Add New Member</a>
                        <a href="members.php?status=active" class="btn btn-primary">Active</a>
                        <a href="members.php?status=inactive" class="btn btn-secondary">In-active</a>
                        <a href="transfer_requests.php" class="btn btn-warning">Transfer Request (Members)</a>
                        <a href="dealers.php" class="btn btn-info">Dealers</a>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-hover">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Father/Spouse</th>
                            <th>CNIC</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Security Status</th>
                            <th>Action</th>
                            <th>Update Username/Password</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Data from user -->
                          <tr>
                            <td>2</td>
                            <td>Naeem Akhter Chaudhary</td>
                            <td>Khalid Iftikhar Manzoor</td>
                            <td>4230138959244</td>
                            <td>335-GG,Phase -4 DHA Lahore</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=2" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member.php?id=2" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>Faheem Ahmed Siddiqui</td>
                            <td>Afzal Ahmed Siddiqui</td>
                            <td>4220173369877</td>
                            <td>House # 44, D.O.H.S, National Stadium Colony, Karachi</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=3" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=3" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>4</td>
                            <td>Farrukh Mateen Siddiqui</td>
                            <td>Afzal Ahmed Siddiqui</td>
                            <td>4220151580409</td>
                            <td>House # D 171,Block 7, Gulshan e Iqbal, Karachi</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=4" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=4" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>5</td>
                            <td>Abuzar Mehmood</td>
                            <td>Muhammad Shafi Arif</td>
                            <td>3630289838195</td>
                            <td>H # 21/c shahruknealam colony Multan</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=5" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=5" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>6</td>
                            <td>Mian Ali Husnain</td>
                            <td>Mian Bashir Ahmad</td>
                            <td>3630237895793</td>
                            <td>Department Of Computer Science, BZU Multan</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=6" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=6" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>7</td>
                            <td>Muzammil Hannan</td>
                            <td>Abdul Sattar</td>
                            <td>3660357606471</td>
                            <td>Al Muzammil Motors, Multan Road, Thingi, District Vehari</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=7" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=7" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>8</td>
                            <td>Abdul Razaq</td>
                            <td>Waryam</td>
                            <td>3610212314999</td>
                            <td>Chah Waryam Wala, Multan Road, Teh Kabir Wala, Distt Khanewal</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=8" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=8" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>9</td>
                            <td>Fozia Rehman</td>
                            <td>Khawaja Abdul Rehman</td>
                            <td>3630446705026</td>
                            <td>Al Mustafa Road,Mohsin Town, Near Walait Abad, Colony No 1, Multan</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=9" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=9" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <tr>
                            <td>10</td>
                            <td>Rana Ghulam Murtaza</td>
                            <td>Ch. Zafar Ullah Khan</td>
                            <td>3630251098005</td>
                            <td>House No 206/A, Block A, Shah Rukn-e Alam Colony, Multan</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td><span class="badge bg-danger">Not Verified</span></td>
                            <td>
                              <a href="update_member.php?id=10" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>
                            </td>
                            <td>
                                <a href="update_member_credentials.php?id=10" class="btn btn-sm btn-info">Update</a>
                            </td>
                          </tr>
                          <!-- End data from user -->
                        </tbody>
                      </table>
                    </div>
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
