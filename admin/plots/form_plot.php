<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../classes/Plot.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$plotObj = new Plot($db);

$id     = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$record = $id ? $plotObj->getById($id) : null;
$action = $id ? 'update' : 'add';
$title  = $id ? 'Edit Plot' : 'Add Plot';

// Load project, size, type dropdowns only (sector & street load via AJAX)
$projects  = $db->query("SELECT id, project_name FROM projects ORDER BY project_name");
$sizeCats  = $db->query("SELECT id, size FROM size_cat ORDER BY size");
$propTypes = $db->query("SELECT property_type_id, title FROM property_types ORDER BY title");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= htmlspecialchars($title) ?></title>

    <link rel="stylesheet" href="../css/adminlte.css" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <?php include("../includes/header.php"); ?>

    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <?php include("../includes/sidebar.php"); ?>
    </aside>

    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3><?= htmlspecialchars($title) ?></h3>
                <a href="plots_list.php" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="app-content">
            <div class="card">
                <div class="card-body">

                    <form id="plotForm" method="post">
                        <input type="hidden" name="action" value="<?= $action ?>">
                        <input type="hidden" name="id" value="<?= $record['id'] ?? '' ?>">

                        <!-- FIRST ROW — MAIN DROPDOWNS -->
                        <div class="row g-3">

                            <!-- Project -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Project</label>
                                <select name="project_id" id="project_id" class="form-select" required>
                                    <option value="">Select Project</option>
                                    <?php if ($projects): ?>
                                        <?php while ($p = $projects->fetch_assoc()): ?>
                                            <option value="<?= $p['id'] ?>"
                                                <?= isset($record['project_id']) && $record['project_id'] == $p['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($p['project_name']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Sector -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Sector</label>
                                <select name="sector_id" id="sector_id" class="form-select" required>
                                    <option value="">Select Sector</option>
                                </select>
                            </div>

                            <!-- Street -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Street</label>
                                <select name="street_id" id="street_id" class="form-select" required>
                                    <option value="">Select Street</option>
                                </select>
                            </div>

                            <!-- Size Category -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Size Category</label>
                                <select name="size_cat_id" class="form-select" required>
                                    <option value="">Select Size</option>
                                    <?php if ($sizeCats): ?>
                                        <?php while ($sc = $sizeCats->fetch_assoc()): ?>
                                            <option value="<?= $sc['id'] ?>"
                                                <?= isset($record['size_cat_id']) && $record['size_cat_id'] == $sc['id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($sc['size']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Property Type -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Property Type</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <?php if ($propTypes): ?>
                                        <?php while ($pt = $propTypes->fetch_assoc()): ?>
                                            <option value="<?= $pt['property_type_id'] ?>"
                                                <?= isset($record['category_id']) && $record['category_id'] == $pt['property_type_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($pt['title']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                        </div>

                        <hr class="my-4">

                        <!-- SECOND ROW — REMAINING FIELDS -->
                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Plot Address</label>
                                <input type="text" name="plot_detail_address" class="form-control" required
                                       value="<?= htmlspecialchars($record['plot_detail_address'] ?? '') ?>">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Plot Size</label>
                                <input type="text" name="plot_size" class="form-control" required
                                       value="<?= htmlspecialchars($record['plot_size'] ?? '') ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" class="form-control" required
                                       value="<?= htmlspecialchars($record['price'] ?? '') ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Basic Price</label>
                                <input type="text" name="basic_price" class="form-control"
                                       value="<?= htmlspecialchars($record['basic_price'] ?? '') ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control" required
                                       value="<?= htmlspecialchars($record['location'] ?? '') ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Plot Dimension</label>
                                <input type="text" name="plot_dimension" class="form-control"
                                       value="<?= htmlspecialchars($record['plot_dimension'] ?? '') ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Installment</label>
                                <input type="number" name="installment" class="form-control"
                                       value="<?= htmlspecialchars($record['installment'] ?? 0) ?>">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <input type="text" name="status"  class="form-control" required
                                       value="<?= htmlspecialchars($record['status'] ?? '') ?>">
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <?= $id ? "Update Plot" : "Add Plot" ?>
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/adminlte.js"></script>

<script>
// --- Load sectors by project ---
function loadSectors(projectId, selectedSectorId = '') {
    const sectorSelect = document.getElementById("sector_id");
    const streetSelect = document.getElementById("street_id");

    if (!projectId) {
        sectorSelect.innerHTML = '<option value="">Select Sector</option>';
        streetSelect.innerHTML = '<option value="">Select Street</option>';
        return;
    }

    sectorSelect.innerHTML = '<option value="">Loading...</option>';
    streetSelect.innerHTML = '<option value="">Select Street</option>';

    fetch("api_plots.php?action=load_sectors&project_id=" + encodeURIComponent(projectId))
        .then(r => r.json())
        .then(data => {
            sectorSelect.innerHTML = '<option value="">Select Sector</option>';

            data.forEach(row => {
                const sel = (selectedSectorId && String(selectedSectorId) === String(row.sector_id)) ? 'selected' : '';
                sectorSelect.innerHTML += `<option value="${row.sector_id}" ${sel}>${row.sector_name}</option>`;
            });
        });
}

// --- Load streets by sector ---
function loadStreets(sectorId, selectedStreetId = '') {
    const streetSelect = document.getElementById("street_id");

    if (!sectorId) {
        streetSelect.innerHTML = '<option value="">Select Street</option>';
        return;
    }

    streetSelect.innerHTML = '<option value="">Loading...</option>';

    fetch("api_plots.php?action=load_streets&sector_id=" + encodeURIComponent(sectorId))
        .then(r => r.json())
        .then(data => {
            streetSelect.innerHTML = '<option value="">Select Street</option>';

            data.forEach(row => {
                const sel = (selectedStreetId && String(selectedStreetId) === String(row.id)) ? 'selected' : '';
                streetSelect.innerHTML += `<option value="${row.id}" ${sel}>${row.street}</option>`;
            });
        });
}

// Project change
document.getElementById("project_id").addEventListener("change", function () {
    loadSectors(this.value);
});

// Sector change
document.getElementById("sector_id").addEventListener("change", function () {
    loadStreets(this.value);
});

// Pre-fill sector/street on edit
document.addEventListener("DOMContentLoaded", function () {
    const projectId = "<?= isset($record['project_id']) ? $record['project_id'] : '' ?>";
    const sectorId  = "<?= isset($record['sector_id']) ? $record['sector_id'] : '' ?>";
    const streetId  = "<?= isset($record['street_id']) ? $record['street_id'] : '' ?>";

    if (projectId) {
        loadSectors(projectId, sectorId);
        if (sectorId) {
            setTimeout(() => loadStreets(sectorId, streetId), 400);
        }
    }

    // Submit via AJAX
    document.getElementById("plotForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const fd = new FormData(this);

        fetch("api_plots.php", {
            method: "POST",
            body: fd
        })
            .then(r => r.json())
            .then(res => {
                alert(res.message || 'Done');
                if (res.success) {
                    window.location = "plots_list.php";
                }
            })
            .catch(err => alert("Error: " + err.message));
    });
});
</script>

</body>
</html>
