<?php session_start(); ?>
<?php
$propertyTypeId = $_GET['id'] ?? null;
$pageTitle = $propertyTypeId ? 'Edit Property Type' : 'Add Property Type';
$submitText = $propertyTypeId ? 'Update Property Type' : 'Add Property Type';
$cardType = $propertyTypeId ? 'card-success' : 'card-primary';

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$propertyType = null;
if ($propertyTypeId) {
    $stmt = $db->prepare("SELECT * FROM property_types WHERE property_type_id=?");
    $stmt->bind_param("i", $propertyTypeId);
    $stmt->execute();
    $propertyType = $stmt->get_result()->fetch_assoc();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

    <!-- SAME CSS AS PROJECT PAGE (fixes sidebar dropdown) -->
    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" media="print" onload="this.media='all'"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="../css/adminlte.css" />
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

        <!-- PAGE HEADER SAME AS LIST PAGE -->
        <div class="app-content-header">
          <div class="container-fluid d-flex justify-content-between align-items-center">
            <h3><?= $pageTitle ?></h3>
          </div>
        </div>

        <div class="app-content">
          <div class="container-fluid">

            <div class="card <?= $cardType ?> mb-4">
              <div class="card-header">
                  <h4><?= $pageTitle ?></h4>
              </div>

              <form id="propertyTypeForm">
                <div class="card-body">

                  <input type="hidden" name="property_type_id" value="<?= htmlspecialchars($propertyTypeId ?? '') ?>">

                  <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title"
                    value="<?= htmlspecialchars($propertyType['title'] ?? '') ?>" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Short</label>
                    <input type="text" class="form-control" name="short"
                    value="<?= htmlspecialchars($propertyType['short'] ?? '') ?>">
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Short Small</label>
                    <input type="text" class="form-control" name="short_sm"
                    value="<?= htmlspecialchars($propertyType['short_sm'] ?? '') ?>">
                  </div>

                </div>

                <div class="card-footer text-end">
                  <button type="submit" class="btn <?= $propertyTypeId ? 'btn-success' : 'btn-primary' ?>">
                    <?= $submitText ?>
                  </button>
                  <a href="property_types.php" class="btn btn-secondary ms-2">Cancel</a>
                </div>

              </form>
            </div>

          </div>
        </div>

      </main>

      <?php include("../includes/footer.php"); ?>

    </div>

    <!-- REQUIRED JS for sidebar dropdown (same as project page) -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
    <script src="../js/adminlte.js"></script>

    <script>
    document.getElementById('propertyTypeForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const fd = new FormData(this);
        fd.append('action', <?= $propertyTypeId ? "'update'" : "'add'" ?>);

        fetch('api_property_type.php', {
            method: 'POST',
            body: fd
        })
        .then(res => res.json())
        .then(result => {
            alert(result.message);
            if (result.success) window.location.href = 'property_types.php';
        })
        .catch(err => alert('Error: ' + err.message));
    });
    </script>

  </body>
</html>
