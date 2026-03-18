<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - User List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | User List" />
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
          <a href="./index.php" class="brand-link">
           
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
                <h3 class="mb-0">User List</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">User List</li>
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
                    <h3 class="card-title mb-0">Users</h3>
                     <a href="add_user.php" class="btn btn-success ms-auto">Add User</a>
                  </div>
                  <div class="card-body">

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="users.php?status=active" class="btn btn-primary">Active</a>
                        <a href="users.php?status=all" class="btn btn-secondary">All</a>
                        <a href="users.php?status=inactive" class="btn btn-warning">In-active</a>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-hover">
                        <thead>
                          <tr>
                            <th>User Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Login Name</th>
                            <th>Father/Spouse</th>
                            <th>Status</th>
                            <th>Create Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Updated Data -->
                          <tr>
                            <td>1</td>
                            <td></td>
                            <td>Rehman</td>
                            <td>Saeed</td>
                            <td>Khan</td>
                            <td>admin</td>
                            <td>Abdul Kalam</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>27-01-2014</td>
                            <td>
                              <a href="update_user.php?id=1" class="btn btn-sm btn-warning me-1" title="Update"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger me-1" title="Delete"><i class="bi bi-trash-fill"></i></a>
                              <a href="#" class="btn btn-sm btn-info" title="Show Password"><i class="bi bi-eye-fill"></i></a>
                            </td>
                          </tr>
                           <tr>
                            <td>49</td>
                            <td></td>
                            <td>Col Fahim-ud-Din</td>
                            <td></td>
                            <td>Shad</td>
                            <td>col-</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>25-11-2014</td>
                            <td>
                              <a href="update_user.php?id=49" class="btn btn-sm btn-warning me-1" title="Update"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger me-1" title="Delete"><i class="bi bi-trash-fill"></i></a>
                              <a href="#" class="btn btn-sm btn-info" title="Show Password"><i class="bi bi-eye-fill"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>59</td>
                            <td></td>
                            <td>test</td>
                            <td></td>
                            <td>test</td>
                            <td>test-</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>20-04-2015</td>
                            <td>
                              <a href="update_user.php?id=59" class="btn btn-sm btn-warning me-1" title="Update"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger me-1" title="Delete"><i class="bi bi-trash-fill"></i></a>
                              <a href="#" class="btn btn-sm btn-info" title="Show Password"><i class="bi bi-eye-fill"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>54</td>
                            <td></td>
                            <td>Muhammad</td>
                            <td>Javed</td>
                            <td>Iqbal</td>
                            <td>mjaved</td>
                            <td>Rashid Ahmed</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>22-01-2015</td>
                            <td>
                              <a href="update_user.php?id=54" class="btn btn-sm btn-warning me-1" title="Update"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger me-1" title="Delete"><i class="bi bi-trash-fill"></i></a>
                              <a href="#" class="btn btn-sm btn-info" title="Show Password"><i class="bi bi-eye-fill"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>53</td>
                            <td></td>
                            <td>Riaz</td>
                            <td></td>
                            <td>Mustafa</td>
                            <td>finance-</td>
                            <td></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>20-12-2014</td>
                            <td>
                              <a href="update_user.php?id=53" class="btn btn-sm btn-warning me-1" title="Update"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger me-1" title="Delete"><i class="bi bi-trash-fill"></i></a>
                              <a href="#" class="btn btn-sm btn-info" title="Show Password"><i class="bi bi-eye-fill"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td>57</td>
                            <td></td>
                            <td>Tamoor</td>
                            <td></td>
                            <td>Afzal</td>
                            <td>ta</td>
                            <td>Sher Afzal</td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>14-03-2015</td>
                            <td>
                              <a href="update_user.php?id=57" class="btn btn-sm btn-warning me-1" title="Update"><i class="bi bi-pencil-square"></i></a>
                              <a href="#" class="btn btn-sm btn-danger me-1" title="Delete"><i class="bi bi-trash-fill"></i></a>
                              <a href="#" class="btn btn-sm btn-info" title="Show Password"><i class="bi bi-eye-fill"></i></a>
                            </td>
                          </tr>
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

