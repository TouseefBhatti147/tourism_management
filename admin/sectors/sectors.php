<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Real Estate E-system - Sectors List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="../css/adminlte.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
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
          <h3>Sectors List</h3>
          <a href="form_sector.php" class="btn btn-success">Add Sector</a>
        </div>
      </div>

      <div class="app-content">
        <div class="container-fluid">
          <div class="card mb-4">
            <div class="card-body">
              <!-- 🔹 Filter -->
              <div class="row mb-3">
                <div class="col-md-4">
                  <label class="form-label">Select Project</label>
                  <select id="projectFilter" class="form-select">
                    <option value="0">All Projects</option>
                    <?php
                      $db = new mysqli("localhost", "root", "", "rdlpk_db1");
                      $projects = $db->query("SELECT id, project_name FROM projects ORDER BY project_name ASC");
                      while ($p = $projects->fetch_assoc()) {
                        echo "<option value='{$p['id']}'>{$p['project_name']}</option>";
                      }
                      $db->close();
                    ?>
                  </select>
                </div>
                <div class="col-md-2 align-self-end">
                  <button id="searchBtn" class="btn btn-primary w-100">Search</button>
                </div>
              </div>

              <!-- 🔹 Data Table -->
              <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Project Name</th>
                      <th>Sector Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="sectorsTable">
                    <tr><td colspan="5" class="text-center">Loading...</td></tr>
                  </tbody>
                </table>
              </div>

              <!-- 🔹 Pagination -->
              <nav>
                <ul id="pagination" class="pagination pagination-sm m-0 float-end"></ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </main>

    <?php include("../includes/footer.php"); ?>
  </div>

  <script>
  let currentPage = 1;
  let currentProject = 0;

  function loadSectors(page = 1, project_id = 0) {
    $('#sectorsTable').html('<tr><td colspan="5" class="text-center">Loading...</td></tr>');
    $('#pagination').empty();

    $.getJSON('api_sectors.php', { page, project_id }, function(response) {
      if (response.success) {
        const sectors = response.data;
        const pagination = response.pagination;

        if (sectors.length === 0) {
          $('#sectorsTable').html('<tr><td colspan="5" class="text-center text-muted">No sectors found</td></tr>');
        } else {
          let rows = '';
          sectors.forEach(sec => {
            rows += `
              <tr>
                <td>${sec.sector_id}</td>
                <td>${sec.project_name || '-'}</td>
                <td>${sec.sector_name}</td>
                <td>
                  <a href="form_sector.php?id=${sec.sector_id}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                  <button class="btn btn-sm btn-danger" onclick="deleteSector(${sec.sector_id})"><i class="bi bi-trash-fill"></i></button>
                </td>
              </tr>`;
          });
          $('#sectorsTable').html(rows);
        }

        // Pagination links
        for (let i = 1; i <= pagination.total_pages; i++) {
          const active = (i === pagination.current) ? 'active' : '';
          $('#pagination').append(`
            <li class="page-item ${active}">
              <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>`);
        }
      } else {
        $('#sectorsTable').html('<tr><td colspan="5" class="text-danger text-center">Failed to load sectors</td></tr>');
      }
    });
  }

  function changePage(page) {
    currentPage = page;
    loadSectors(page, currentProject);
  }

  $('#searchBtn').click(function() {
    currentProject = parseInt($('#projectFilter').val());
    currentPage = 1;
    loadSectors(currentPage, currentProject);
  });

  function deleteSector(id) {
    if (!confirm('Are you sure you want to delete this sector?')) return;
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);

    fetch('api_sectors.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(result => {
        alert(result.message);
        if (result.success) loadSectors(currentPage, currentProject);
      });
  }

  // Load all sectors initially
  loadSectors();
  </script>
</body>
</html>
