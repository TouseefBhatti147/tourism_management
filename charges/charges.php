<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Charges List - Real Estate E-System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
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
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6"><h3>Charges List</h3></div>
              <div class="col-sm-6 text-end">
                <a href="form_charges.php" class="btn btn-success">Add Charges</a>
              </div>
            </div>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <!-- Filters -->
            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label">Project</label>
                <select id="projectFilter" class="form-select">
                  <option value="">All Projects</option>
                  <?php
                  $db = new mysqli("localhost", "root", "", "rdlpk_db1");
                  $res = $db->query("SELECT id, project_name FROM projects ORDER BY project_name ASC");
                  while ($r = $res->fetch_assoc()) {
                    echo "<option value='{$r['id']}'>" . htmlspecialchars($r['project_name']) . "</option>";
                  }
                  $db->close();
                  ?>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" id="searchKeyword" class="form-control" placeholder="Search by Name or Note">
              </div>
              <div class="col-md-4 align-self-end">
                <button id="searchBtn" class="btn btn-primary w-100">Search</button>
              </div>
            </div>

            <!-- Table -->
            <div class="card">
              <div class="card-body">
                <div id="tableMessage" class="alert alert-info">Loading...</div>
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Project</th>
                      <th>Name</th>
                      <th>Note</th>
                      <th>Monthly</th>
                      <th>Total</th>
                      <th>Type</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="chargesTableBody"></tbody>
                </table>
                <nav><ul class="pagination justify-content-end mt-3" id="pagination"></ul></nav>
              </div>
            </div>
          </div>
        </div>
      </main>

      <?php include("../includes/footer.php"); ?>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
      loadCharges();

      document.getElementById('searchBtn').addEventListener('click', () => loadCharges(1));

      function loadCharges(page = 1) {
        const search = document.getElementById('searchKeyword').value.trim();
        const projectId = document.getElementById('projectFilter').value;

        const query = new URLSearchParams({ page, search, project_id: projectId });

        fetch('api_charges.php?' + query)
          .then(res => res.json())
          .then(result => {
            const tbody = document.getElementById('chargesTableBody');
            const pagination = document.getElementById('pagination');
            const msg = document.getElementById('tableMessage');

            tbody.innerHTML = '';
            pagination.innerHTML = '';

            if (result.success && result.data.length > 0) {
              msg.style.display = 'none';
              result.data.forEach(row => {
                tbody.innerHTML += `
                  <tr>
                    <td>${row.id}</td>
                    <td>${row.project_name || '-'}</td>
                    <td>${row.name}</td>
                    <td>${row.note}</td>
                    <td>${row.monthly}</td>
                    <td>${row.total}</td>
                    <td>${row.type}</td>
                    <td>
                      <a href="form_charges.php?id=${row.id}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                      <button class="btn btn-danger btn-sm" onclick="deleteCharge(${row.id})"><i class="bi bi-trash"></i></button>
                    </td>
                  </tr>`;
              });

              for (let i = 1; i <= result.pagination.total_pages; i++) {
                pagination.innerHTML += `<li class="page-item ${i===result.pagination.current?'active':''}">
                  <a class="page-link" href="#" onclick="loadCharges(${i})">${i}</a></li>`;
              }

            } else {
              msg.textContent = 'No records found.';
              msg.className = 'alert alert-secondary';
              msg.style.display = 'block';
            }
          })
          .catch(() => {
            document.getElementById('tableMessage').textContent = 'Error loading data.';
          });
      }

      window.deleteCharge = function(id) {
        if (!confirm("Are you sure you want to delete this record?")) return;

        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        fetch('api_charges.php', { method: 'POST', body: formData })
          .then(res => res.json())
          .then(result => {
            alert(result.message);
            if (result.success) loadCharges();
          });
      }
    });
    </script>
  </body>
</html>
