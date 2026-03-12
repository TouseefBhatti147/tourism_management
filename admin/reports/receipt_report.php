<?php session_start();?>
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
      <!-- Header -->
        <?php require("../includes/header.php");?>


      <!-- Sidebar -->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="../index.php" class="brand-link">
            <img
              src="https://placehold.co/33x33/6c757d/ffffff?text=RE"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <!-- Sidebar Menu -->
        <?php include("../includes/sidebar.php"); ?>
        <!-- /.sidebar-wrapper -->
      </aside>

      <!-- Main Content -->
      <main class="app-main">
        <!-- App Content Header -->
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

        <!-- App Content -->
        <div class="app-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                
             

                <!-- Sales Summary Card -->
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Sales Summary</h3>
                    <div class="card-tools float-end">
                      <div class="btn-group" role="group" aria-label="Sales Timeframe">
                        <button type="button" class="btn btn-sm btn-outline-secondary active">Daily</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Monthly</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Yearly</button>
                      </div>
                    </div>
                  </div>

                  <div class="card-body p-0">
                    <div class="p-3">
                        <p class="mb-0 text-muted">Sales Summary Today: 22-10-2025</p>
                        <h5 class="mb-1">Amount (GBP - Millions)</h5>
                    </div>
                    <table class="table table-bordered table-striped text-center" role="table">
                      <thead class="thead-light">
                        <tr>
                          <th rowspan="2" class="align-middle">Sales Center</th>
                          <th colspan="6">Payment Mode Wise</th>
                        </tr>
                        <tr>
                          <th>Cash</th>
                          <th>Cheque</th>
                          <th>PO</th>
                          <th>Online</th>
                          <th>JV</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="text-start">Royal Orchard Multan</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                        </tr>
                        <tr>
                          <td class="text-start">Royal Orchard Sargodha</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                        </tr>
                        <tr>
                          <td class="text-start">Royal Orchard Sahiwal</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr style="font-weight: bold;">
                          <td class="text-start">Total</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                          <td>0</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                
             

              </div>
            </div>
          </div>
        </div>
      </main>

      <!-- Footer -->
     <?php require("../includes/footer.php");?>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../js/adminlte.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>

    <script>
      // The sales chart script from your original file is preserved here.
      // You would need a <div id="sales-chart"></div> in the HTML to display it.
      /*
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
      */
    </script>
  </body>
</html>

