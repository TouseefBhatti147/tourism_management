<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Streets List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="../css/adminlte.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php include("../includes/header.php"); ?>

      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="../index.php" class="brand-link">
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid d-flex justify-content-between align-items-center">
            <h3>Streets List</h3>
            <a href="form_street.php" class="btn btn-success">Add Street</a>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <div class="card mb-4">
              <div class="card-header">
                <div class="row g-2">
                  <div class="col-md-4">
                    <label for="projectSelect" class="form-label">Project</label>
                    <select id="projectSelect" class="form-select">
                      <option value="">All Projects</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="sectorSelect" class="form-label">Sector</label>
                    <select id="sectorSelect" class="form-select">
                      <option value="">All Sectors</option>
                    </select>
                  </div>
                  <div class="col-md-2 d-flex align-items-end">
                    <button id="searchBtn" class="btn btn-primary w-100">Search</button>
                  </div>
                </div>
              </div>

              <div class="card-body">
                <div id="tableMessage" class="alert alert-info text-center" style="display:none;">Loading...</div>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Project</th>
                        <th>Sector</th>
                        <th>Street</th>
                        <th>Create Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="streetsTableBody">
                      <tr><td colspan="6" class="text-center">Loading...</td></tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="card-footer text-end">
                <nav>
                  <ul class="pagination pagination-sm justify-content-end m-0" id="pagination"></ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </main>

      <?php include("../includes/footer.php"); ?>
    </div>

    <!-- AdminLTE / Bootstrap JS so header menu and dropdowns work -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
    <script src="../js/adminlte.js"></script>

    <script>
      let currentPage = 1;
      let totalPages = 1;

      $(document).ready(function () {
        loadProjects();
        loadSectors(); // load all initially
        loadStreets();

        // Search button click
        $('#searchBtn').on('click', function () {
          currentPage = 1;
          loadStreets();
        });

        // When project changes -> load sectors for that project
        $('#projectSelect').on('change', function () {
          const projectId = $(this).val();
          loadSectors(projectId);
        });
      });

      // ------------------- LOAD PROJECTS -------------------
      function loadProjects() {
        $.getJSON('../projects/api_projects.php', function (res) {
          if (res.success && res.data.length > 0) {
            const select = $('#projectSelect');
            select.empty().append('<option value="">All Projects</option>');
            res.data.forEach(p => {
              select.append(`<option value="${p.id}">${p.project_name}</option>`);
            });
          }
        });
      }

      // ------------------- LOAD SECTORS -------------------
      function loadSectors(projectId = '') {
        let url = '../sectors/api_sectors.php';
        if (projectId) url += '?project_id=' + encodeURIComponent(projectId);

        $.getJSON(url, function (res) {
          const select = $('#sectorSelect');
          select.empty().append('<option value="">All Sectors</option>');
          if (res.success && res.data.length > 0) {
            res.data.forEach(sec => {
              // sectors table field name is sector_id
              select.append(`<option value="${sec.sector_id}">${sec.sector_name}</option>`);
            });
          }
        });
      }

      // ------------------- LOAD STREETS -------------------
      function loadStreets(page = 1) {
        const projectId = $('#projectSelect').val();
        const sectorId = $('#sectorSelect').val();

        $('#tableMessage').show().text('Loading streets...');
        $('#streetsTableBody').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

        $.getJSON('api_streets.php', { page, project_id: projectId, sector_id: sectorId }, function (res) {
          $('#tableMessage').hide();

          if (res.success && res.data.length > 0) {
            const tbody = $('#streetsTableBody');
            tbody.empty();
            res.data.forEach(st => {
              tbody.append(`
                <tr>
                  <td>${st.id}</td>
                  <td>${st.project_name || '-'}</td>
                  <td>${st.sector_name || '-'}</td>
                  <td>${st.street}</td>
                  <td>${st.create_date || ''}</td>
                  <td>
                    <a href="form_street.php?id=${st.id}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                    <button class="btn btn-sm btn-danger" onclick="deleteStreet(${st.id})"><i class="bi bi-trash-fill"></i></button>
                  </td>
                </tr>
              `);
            });
            setupPagination(res.pagination);
          } else {
            $('#streetsTableBody').html('<tr><td colspan="6" class="text-center">No records found.</td></tr>');
            $('#pagination').empty();
          }
        });
      }

      // ------------------- PAGINATION -------------------
      function setupPagination(pagination) {
        currentPage = pagination.current;
        totalPages = pagination.total_pages;
        const $pagination = $('#pagination');
        $pagination.empty();

        if (totalPages <= 1) return;

        const prevDisabled = currentPage === 1 ? 'disabled' : '';
        const nextDisabled = currentPage === totalPages ? 'disabled' : '';

        $pagination.append(`<li class="page-item ${prevDisabled}"><a class="page-link" href="#" onclick="changePage(${currentPage - 1})">«</a></li>`);

        for (let i = 1; i <= totalPages; i++) {
          const active = i === currentPage ? 'active' : '';
          $pagination.append(`<li class="page-item ${active}"><a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`);
        }

        $pagination.append(`<li class="page-item ${nextDisabled}"><a class="page-link" href="#" onclick="changePage(${currentPage + 1})">»</a></li>`);
      }

      function changePage(page) {
        if (page < 1 || page > totalPages) return;
        loadStreets(page);
      }

      // ------------------- DELETE STREET -------------------
      function deleteStreet(id) {
        if (!confirm('Are you sure you want to delete this street?')) return;

        $.post('api_streets.php', { action: 'delete', id }, function (res) {
          if (res.success) {
            alert('✅ Street deleted successfully');
            loadStreets(currentPage);
          } else {
            alert('❌ ' + res.message);
          }
        }, 'json');
      }
    </script>
  </body>
</html>
