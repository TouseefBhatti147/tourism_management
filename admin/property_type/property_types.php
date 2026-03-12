<?php
session_start();
require_once("../classes/PropertyType.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$obj = new PropertyType($db);
$list = $obj->getAll();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Real Estate E-system - Property Types</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- FIXED CSS (same as working project list page) -->
    <link rel="preload" href="../css/adminlte.css" as="style" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" media="print" onload="this.media='all'"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="../css/adminlte.css" />
  </head>

  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <div class="app-wrapper">
      <?php include("../includes/header.php"); ?>

      <!-- SIDEBAR -->
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="../index.php" class="brand-link">
            <span class="brand-text fw-light">Real Estate E-System</span>
          </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="app-main">

        <!-- PAGE HEADER (same as project list) -->
        <div class="app-content-header">
          <div class="container-fluid d-flex justify-content-between align-items-center">
            <h3>Property Types List</h3>
            <a href="form_property_type.php" class="btn btn-success">Add Property Type</a>
          </div>
        </div>

        <!-- MAIN CONTENT BODY -->
        <div class="app-content">
          <div class="container-fluid">

            <div class="card mb-4">
              <div class="card-body">

                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Short</th>
                      <th>Short Small</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php if ($list && $list->num_rows > 0): ?>
                      <?php while ($row = $list->fetch_assoc()): ?>
                        <tr id="ptype-row-<?= $row['property_type_id'] ?>">
                          <td><?= $row['property_type_id'] ?></td>
                          <td><?= htmlspecialchars($row['title']) ?></td>
                          <td><?= htmlspecialchars($row['short']) ?></td>
                          <td><?= htmlspecialchars($row['short_sm']) ?></td>

                          <td>
                            <a href="form_property_type.php?id=<?= $row['property_type_id'] ?>" 
                               class="btn btn-sm btn-warning me-1">
                               <i class="bi bi-pencil-square"></i>
                            </a>

                            <button class="btn btn-sm btn-danger"
                                    onclick="deletePropertyType(<?= $row['property_type_id'] ?>)">
                              <i class="bi bi-trash-fill"></i>
                            </button>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5" class="text-center text-muted">No property types found</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>

                </table>

              </div>

              <!-- PAGINATION FOOTER (optional like categories) -->
              <div class="card-footer clearfix">
                <!-- pagination can be added here -->
              </div>

            </div>

          </div>
        </div>

      </main>

      <?php include("../includes/footer.php"); ?>

    </div>

    <!-- FIXED JS (same as project page – required for sidebar dropdowns!) -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
    <script src="../js/adminlte.js"></script>

    <!-- DELETE FUNCTION -->
    <script>
      function deletePropertyType(id) {
        if (!confirm("Are you sure you want to delete this record?")) return;

        fetch("api_property_type.php?action=delete&id=" + id)
          .then(res => res.json())
          .then(result => {
            alert(result.message);
            if (result.success) {
              document.getElementById("ptype-row-" + id).remove();
            }
          })
          .catch(e => alert("Error: " + e.message));
      }
    </script>

  </body>
</html>
