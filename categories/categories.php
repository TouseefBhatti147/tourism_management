<?php
session_start();
require_once("../classes/Pagination.php");
require_once("../classes/Category.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$pagination = new Pagination($db, "categories", 10);
$category = new Category($db);

$result = $category->getAll($pagination->perPage, $pagination->offset);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Categories List</title>
    <link rel="stylesheet" href="../css/adminlte.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php include("../includes/header.php"); ?>
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand"><a href="../index.php" class="brand-link"><span class="brand-text fw-light">Real Estate E-System</span></a></div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <main class="app-main">
        <div class="app-content-header">
          <div class="container-fluid d-flex justify-content-between align-items-center">
            <h3>Categories List</h3>
            <a href="form_category.php" class="btn btn-success">Add Category</a>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <div class="card mb-4">
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Name</th>
                      <th>Charges</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($result->num_rows > 0): ?>
                      <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                          <td><?= $row['id'] ?></td>
                          <td><?= htmlspecialchars($row['title']) ?></td>
                          <td><?= htmlspecialchars($row['name']) ?></td>
                          <td><?= htmlspecialchars($row['charges']) ?></td>
                          <td>
                            <a href="form_category.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="deleteCategory(<?= $row['id'] ?>)"><i class="bi bi-trash-fill"></i></button>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr><td colspan="5" class="text-center text-muted">No categories found</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                <?= $pagination->renderLinks('categories.php'); ?>
              </div>
            </div>
          </div>
        </div>
      </main>
      <?php include("../includes/footer.php"); ?>
    </div>

    <script>
      function deleteCategory(id) {
        if (!confirm('Are you sure you want to delete this category?')) return;
        const formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'delete');

        fetch('api_categories.php', { method: 'POST', body: formData })
          .then(res => res.json())
          .then(result => {
            alert(result.message);
            if (result.success) location.reload();
          })
          .catch(err => alert('Error: ' + err.message));
      }
    </script>
  </body>
</html>
