<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - News List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | News List" />
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
                <h3 class="mb-0">News List</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">News List</li>
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
                    <h3 class="card-title mb-0">News</h3>
                    <a href="add_news.php" class="btn btn-success ms-auto">Add News</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px;">Id</th>
                                <th>Teaser</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Create Date</th>
                                <th style="width: 130px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3</td>
                                <td>Membership Forms sales closed for Royal Orchard Multan.</td>
                                <td>Membership Forms sales closed. "Record Sales" achieved in 2 days from 17th ~ 18th Aug, 2015 for Royal Orchard Housing Multan. An overwhelming response from the General Public & Property Consultants. Thanks to all conerned.</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2015-08-19 11:11:11</td>
                                <td>
                                    <a href="view_news.php?id=3" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=3" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>5</td>
                                <td>After the remarkable success of Royal Orchard Multan, HRL launched Royal Orchard Sahiwal on 15th Jan, 2016.</td>
                                <td>After the remarkable success of Royal Orchard Multan, HRL launched Royal Orchard Sahiwal on 15th Jan, 2016. .</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2016-01-15 12:14:00</td>
                                <td>
                                    <a href="view_news.php?id=5" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=5" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>6</td>
                                <td>Investors Conference held at Royal Orchard, Multan on 21st March, 2015.</td>
                                <td>Investors Conference held at Royal Orchard, Multan on 21st March, 2015.</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2015-03-24 04:03:08</td>
                                <td>
                                    <a href="view_news.php?id=6" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=6" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Investors Conference held at DHA Phase-I Islamabad on 28th April, 2015.</td>
                                <td>Investors Conference held at DHA Phase-I Islamabad on 28th April, 2015.</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2015-04-29 02:39:38</td>
                                <td>
                                    <a href="view_news.php?id=7" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=7" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Open Certificate Registration opens for Royal Orchard Housing Projects.</td>
                                <td>Open Certificate Registration opens for Royal Orchard Housing Projects upto 24th Dec, 2015.</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2015-12-14 11:46:19</td>
                                <td>
                                    <a href="view_news.php?id=8" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=8" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>9</td>
                                <td>After the remarkable success at Multan & Sahiwal, HRL & RDBL launched Royal Orchard Sargodha on 12th Feb, 2016.</td>
                                <td>After the remarkable success at Multan & Sahiwal, HRL & RDBL launched Royal Orchard Sargodha on 12th Feb, 2016. .</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2016-02-12 11:39:25</td>
                                <td>
                                    <a href="view_news.php?id=9" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=9" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>10</td>
                                <td>Residential Plots Balloting Ceremony held at Royal Orchard Multan on 8th April, 2016.</td>
                                <td>Residential Plots Balloting Ceremony held at Royal Orchard Housing Multan on 8th Apr, 2016. Go to Draw Results to get your plot allocation.</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2016-04-08 12:08:33</td>
                                <td>
                                    <a href="view_news.php?id=10" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=10" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>11</td>
                                <td>Chief of Army Staff (COAS) Open Golf Championship 2016 (28th Apr - 1st May) sponsored by HRL & Royal Orchard.</td>
                                <td>Chief of Army Staff (COAS) Open Golf Championship 2016 (28th Apr - 1st May) sponserned by HRL & Royal Orchard.</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2016-04-25 06:21:34</td>
                                <td>
                                    <a href="view_news.php?id=11" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=11" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>12</td>
                                <td>Hurry Up! Book your Plot in Royal Orchard Sahiwal. 10% discount offer is not valid after 30th Apr, 2016.</td>
                                <td>Hurry Up! Book your Plot in Royal Orchard Sahiwal. 10% discount offer is not valid after 30th Apr, 2016.</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2016-04-29 12:11:28</td>
                                <td>
                                    <a href="view_news.php?id=12" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=12" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>13</td>
                                <td>Royal T12 Cricket Tournament held at "Royal Orchard Housing Multan" from 20th to 23rd October, 2016 in which 8 teams participated.</td>
                                <td>Royal T12 Cricket Tournament held at "Royal Orchard Housing Multan" from 20th to 23rd October, 2016 in which 8 teams participated</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2016-10-25 02:36:18</td>
                                <td>
                                    <a href="view_news.php?id=13" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=13" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>14</td>
                                <td>Honorable Al-Shaikh Ayad Bin Ahmad Abbass Al-Shukri and Other Delegates from Madina Munawara, Saudia Arabia at Masjid Al-Mustafa, Royal Orchard Multan.</td>
                                <td>Honorable Al-Shaikh Ayad Bin Ahmad Abbass Al-Shukri and Other Delegates from Madina Munawara, Saudia Arabia at Masjid Al-Mustafa, Royal Orchard Multan.</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2016-11-29 10:22:23</td>
                                <td>
                                    <a href="view_news.php?id=14" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=14" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>15</td>
                                <td>Huge celebrations of "Jashn-e-Azadi" at Royal Orchard Housing Multan.</td>
                                <td>A celebration ceremony of "Jashn-e-Azadi" held at Royal Orchard Housing Multan.</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2017-08-16 05:35:50</td>
                                <td>
                                    <a href="view_news.php?id=15" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=15" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                </td>
                            </tr>
                             <tr>
                                <td>16</td>
                                <td>Sanctioning of NOC Royal Orchard Sargodha</td>
                                <td>Sanctioning of NOC Royal Orchard Sargodha</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>2024-05-30 04:43:55</td>
                                <td>
                                    <a href="view_news.php?id=16" class="btn btn-sm btn-info me-1"><i class="bi bi-eye-fill"></i></a>
                                    <a href="update_news.php?id=16" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
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
