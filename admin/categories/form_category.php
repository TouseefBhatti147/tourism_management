<?php session_start(); ?>
<?php
$categoryId = $_GET['id'] ?? null;
$pageTitle = $categoryId ? 'Edit Category' : 'Add Category';
$submitText = $categoryId ? 'Update Category' : 'Add Category';
$cardType = $categoryId ? 'card-success' : 'card-primary';

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$category = null;
if ($categoryId) {
    $stmt = $db->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $category = $stmt->get_result()->fetch_assoc();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="../css/adminlte.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      <?php include("../includes/header.php"); ?>
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
          <a href="../index.php" class="brand-link"><span class="brand-text fw-light">Real Estate E-System</span></a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
      </aside>

      <main class="app-main">
        <div class="app-content-header mb-4">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6"><h3><?= $pageTitle ?></h3></div>
            </div>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">
            <div class="card <?= $cardType ?>">
              <div class="card-header"><h4><?= $pageTitle ?></h4></div>
              <form id="categoryForm">
                <div class="card-body">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($categoryId ?? '') ?>">
                  <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($category['title'] ?? '') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($category['name'] ?? '') ?>" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Charges</label>
                    <input type="text" class="form-control" name="charges" value="<?= htmlspecialchars($category['charges'] ?? '') ?>" required>
                  </div>
                </div>
                <div class="card-footer text-end">
                  <button type="submit" class="btn <?= $categoryId ? 'btn-success' : 'btn-primary' ?>"><?= $submitText ?></button>
                  <a href="categories.php" class="btn btn-secondary ms-2">Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
      <?php include("../includes/footer.php"); ?>
    </div>

    <script>
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', <?= $categoryId ? "'update'" : "'add'" ?>);

        fetch('api_categories.php', { method: 'POST', body: formData })
          .then(res => res.json())
          .then(result => {
            alert(result.message);
            if (result.success) window.location.href = 'categories.php';
          })
          .catch(err => alert('Error: ' + err.message));
    });
    </script>
  </body>
</html>
