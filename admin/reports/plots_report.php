<?php session_start(); ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Dashboard" />
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
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
      crossorigin="anonymous"
    />
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php require("../includes/header.php");?>


      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="../index.php" class="brand-link">
            <img
              src="../assets/img/AdminLTELogo.png"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Summary of Unsold Plots/Villas</h3>
                  </div>

                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label for="projectSelect" class="form-label">Project:</label>
                        <select id="projectSelect" class="form-select">
                          <option selected>Select Project</option>
                          <option>Royal Orchard Multan</option>
                          <option>Royal Orchard Sargodha</option>
                          <option>Royal Orchard Sahiwal</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="blockSelect" class="form-label">Block:</label>
                        <select id="blockSelect" class="form-select">
                          <option selected>Select Block</option>
                          <option>Residential</option>
                          <option>Commercial</option>
                        </select>
                      </div>
                    </div>

                    <table class="table table-bordered" role="table">
                      <thead>
                        <tr>
                          <th style="width: 10px" scope="col">S.No</th>
                          <th scope="col">Plot Categories</th>
                          <th scope="col">Total Unsold</th>
                          <th scope="col">Reserved</th>
                          <th scope="col">Net Balance(Open)</th>
                          <th scope="col">Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="align-middle">
                          <td>1.</td>
                          <td>5 Marla Residential</td>
                          <td>150</td>
                          <td>20</td>
                          <td>130</td>
                          <td></td>
                        </tr>
                        <tr class="align-middle">
                          <td>2.</td>
                          <td>10 Marla Residential</td>
                          <td>80</td>
                          <td>10</td>
                          <td>70</td>
                          <td>Phase II</td>
                        </tr>
                        <tr class="align-middle">
                          <td>3.</td>
                          <td>1 Kanal Residential</td>
                          <td>45</td>
                          <td>5</td>
                          <td>40</td>
                          <td></td>
                        </tr>
                        <tr class="align-middle">
                          <td>4.</td>
                          <td>4 Marla Commercial</td>
                          <td>25</td>
                          <td>15</td>
                          <td>10</td>
                          <td>Main Boulevard</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr class.="align-middle" style="font-weight: bold;">
                          <td colspan="2" class="text-end">Total</td>
                          <td>300</td>
                          <td>50</td>
                          <td>250</td>
                          <td></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                      <li class="page-item"><a class="page-link" href="#">«</a></li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../js/adminlte.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>

    <script>
      const sales_chart_options = {
        series: [
          { name: 'Digital Goods', data: [28, 48, 40, 19, 86, 27, 90] },
          { name: 'Electronics', data: [65, 59, 80, 81, 56, 55, 40] }
        ],
        chart: {
          height: 280,
          type: 'area',
          toolbar: { show: false }
        },
        colors: ['#0d6efd', '#20c997'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
          type: 'datetime',
          categories: [
            '2023-01-01',
            '2023-02-01',
            '2023-03-01',
            '2023-04-01',
            '2023-05-01',
            '2023-06-01',
            '2023-07-01'
          ]
        },
        tooltip: { x: { format: 'MMMM yyyy' } }
      };

      const sales_chart = new ApexCharts(document.querySelector('#sales-chart'), sales_chart_options);
      sales_chart.render();
    </script>
  </body>
</html>