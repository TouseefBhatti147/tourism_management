<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Plot Size List - Real Estate E-System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php include("../includes/header.php"); ?>

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
        <!-- Header -->
        <div class="app-content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6"><h3>Plot Sizes List</h3></div>
              <div class="col-sm-6 text-end">
                <a href="form_plot_size.php" class="btn btn-success">
                  <i class="bi bi-plus-circle"></i> Add Plot Size
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Body -->
        <div class="app-content">
          <div class="container-fluid">
            <!-- Search Filter -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" id="searchKeyword" class="form-control" placeholder="Search by Size, Type or Code">
              </div>
              <div class="col-md-3 align-self-end">
                <button id="searchBtn" class="btn btn-primary w-100">
                  <i class="bi bi-search"></i> Search
                </button>
              </div>
              <div class="col-md-3 align-self-end">
                <button id="resetBtn" class="btn btn-secondary w-100">
                  <i class="bi bi-arrow-repeat"></i> Reset
                </button>
              </div>
            </div>

            <!-- Data Table -->
            <div class="card shadow-sm">
              <div class="card-body">
                <div id="tableMessage" class="alert alert-info">Loading...</div>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                      <tr>
                        <th style="width: 60px;">ID</th>
                        <th>Size</th>
                        <th>Type</th>
                        <th>Code</th>
                        <th style="width: 120px;">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="plotSizeTableBody"></tbody>
                  </table>
                </div>

                <!-- Pagination -->
                <nav>
                  <ul class="pagination justify-content-end mt-3" id="pagination"></ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </main>

      <?php include("../includes/footer.php"); ?>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
      const searchBtn = document.getElementById("searchBtn");
      const resetBtn = document.getElementById("resetBtn");
      const searchInput = document.getElementById("searchKeyword");

      searchBtn.addEventListener("click", () => loadPlotSizes(1));
      resetBtn.addEventListener("click", () => {
        searchInput.value = "";
        loadPlotSizes(1);
      });

      loadPlotSizes();

      function loadPlotSizes(page = 1) {
        const search = searchInput.value.trim();
        const query = new URLSearchParams({ page, search });

        fetch("api_plot_size.php?" + query)
          .then(res => res.json())
          .then(result => {
            const tbody = document.getElementById("plotSizeTableBody");
            const pagination = document.getElementById("pagination");
            const msg = document.getElementById("tableMessage");

            tbody.innerHTML = "";
            pagination.innerHTML = "";

            if (result.success && result.data.length > 0) {
              msg.style.display = "none";
              result.data.forEach(row => {
                tbody.innerHTML += `
                  <tr>
                    <td>${row.id}</td>
                    <td>${escapeHTML(row.size)}</td>
                    <td>${escapeHTML(row.type)}</td>
                    <td>${escapeHTML(row.code)}</td>
                    <td class="text-center">
                      <a href="form_plot_size.php?id=${row.id}" class="btn btn-sm btn-warning me-1">
                        <i class="bi bi-pencil-square"></i>
                      </a>
                      <button class="btn btn-sm btn-danger" onclick="deletePlotSize(${row.id})">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>`;
              });

              // Pagination
              for (let i = 1; i <= result.pagination.total_pages; i++) {
                pagination.innerHTML += `
                  <li class="page-item ${i === result.pagination.current ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="loadPlotSizes(${i})">${i}</a>
                  </li>`;
              }

            } else {
              msg.style.display = "block";
              msg.className = "alert alert-secondary";
              msg.textContent = "No records found.";
            }
          })
          .catch(() => {
            const msg = document.getElementById("tableMessage");
            msg.style.display = "block";
            msg.className = "alert alert-danger";
            msg.textContent = "Error loading data.";
          });
      }

      window.deletePlotSize = function(id) {
        if (!confirm("Are you sure you want to delete this plot size?")) return;

        const formData = new FormData();
        formData.append("action", "delete");
        formData.append("id", id);

        fetch("api_plot_size.php", { method: "POST", body: formData })
          .then(res => res.json())
          .then(result => {
            alert(result.message);
            if (result.success) loadPlotSizes();
          })
          .catch(() => alert("Error deleting record."));
      }

      function escapeHTML(str) {
        if (!str) return "";
        return str.replace(/[&<>"']/g, t => ({
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#039;"
        }[t]));
      }
    });
    </script>
  </body>
</html>
