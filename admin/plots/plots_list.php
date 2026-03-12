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

// filters
$search       = $_GET['q'] ?? '';
$projectId    = isset($_GET['project_id'])   ? (int)$_GET['project_id']   : 0;
$sectorId     = $_GET['sector_id']   ?? '';
$streetId     = $_GET['street_id']   ?? '';
$sizeCatId    = isset($_GET['size_cat_id'])  ? (int)$_GET['size_cat_id']  : 0;
$propertyType = isset($_GET['property_type'])? (int)$_GET['property_type']: 0;

// pagination
$page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit  = 20;
$offset = ($page - 1) * $limit;

$filters = [
    'project_id'    => $projectId,
    'sector_id'     => $sectorId,
    'street_id'     => $streetId,
    'size_cat_id'   => $sizeCatId,
    'property_type' => $propertyType,
];

$list       = $plotObj->getAll($search, $limit, $offset, $filters);
$totalRows  = $plotObj->getTotal($search, $filters);
$totalPages = ($totalRows > 0) ? ceil($totalRows / $limit) : 1;

// dropdown data
$projects = $db->query("SELECT id, project_name FROM projects ORDER BY project_name");
$sizeCats = $db->query("SELECT id, size FROM size_cat ORDER BY size");
$propTypes= $db->query("SELECT property_type_id, title FROM property_types ORDER BY title");

// build query string for pagination (preserve filters)
$queryBase = http_build_query([
    'q'            => $search,
    'project_id'   => $projectId,
    'sector_id'    => $sectorId,
    'street_id'    => $streetId,
    'size_cat_id'  => $sizeCatId,
    'property_type'=> $propertyType,
]);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Plots List</title>

    <link rel="stylesheet" href="../css/adminlte.css" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <!-- jQuery (needed for dynamic dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <?php include("../includes/header.php"); ?>

    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <?php include("../includes/sidebar.php"); ?>
    </aside>

    <main class="app-main">
        <div class="app-content">

            <div class="app-content-header">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Plots</h3>
                    <a href="form_plot.php" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> Add Plot
                    </a>
                </div>
            </div>

            <div class="app-content-wrapper">

                <!-- FILTERS -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="get">

                            <div class="row g-3 mb-2">
                                <!-- PROJECT -->
                                <div class="col-md-3">
                                    <label class="form-label mb-1">Project</label>
                                    <select name="project_id" id="projectSelect" class="form-select">
                                        <option value="0">All</option>
                                        <?php if ($projects): ?>
                                            <?php while ($p = $projects->fetch_assoc()): ?>
                                                <option value="<?= $p['id'] ?>"
                                                    <?= $projectId == $p['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($p['project_name']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- SECTOR (loaded dynamically by project) -->
                                <div class="col-md-3">
                                    <label class="form-label mb-1">Sector</label>
                                    <select name="sector_id" id="sectorSelect" class="form-select">
                                        <option value="">All</option>
                                        <!-- options will be loaded via AJAX from api_plots.php?action=load_sectors -->
                                    </select>
                                </div>

                                <!-- STREET (loaded dynamically by sector) -->
                                <div class="col-md-3">
                                    <label class="form-label mb-1">Street</label>
                                    <select name="street_id" id="streetSelect" class="form-select">
                                        <option value="">All</option>
                                        <!-- options will be loaded via AJAX from api_plots.php?action=load_streets -->
                                    </select>
                                </div>

                                <!-- SIZE CATEGORY -->
                                <div class="col-md-3">
                                    <label class="form-label mb-1">Size Category</label>
                                    <select name="size_cat_id" class="form-select">
                                        <option value="0">All</option>
                                        <?php if ($sizeCats): ?>
                                            <?php while ($sc = $sizeCats->fetch_assoc()): ?>
                                                <option value="<?= $sc['id'] ?>"
                                                    <?= $sizeCatId == $sc['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($sc['size']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-end">
                                <!-- PROPERTY TYPE -->
                                <div class="col-md-3">
                                    <label class="form-label mb-1">Property Type</label>
                                    <select name="property_type" class="form-select">
                                        <option value="0">All</option>
                                        <?php if ($propTypes): ?>
                                            <?php while ($pt = $propTypes->fetch_assoc()): ?>
                                                <option value="<?= $pt['property_type_id'] ?>"
                                                    <?= $propertyType == $pt['property_type_id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($pt['title']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- SEARCH -->
                                <div class="col-md-4">
                                    <label class="form-label mb-1">Search</label>
                                    <input type="text" name="q"
                                           class="form-control"
                                           placeholder="Address, size, location..."
                                           value="<?= htmlspecialchars($search) ?>">
                                </div>

                                <!-- BUTTONS -->
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 mb-1">Search</button>
                                    <a href="plots_list.php" class="btn btn-secondary w-100">Reset</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="card mb-4">
                    <div class="card-body p-0">

                        <table class="table table-bordered table-striped mb-0 align-middle">
                            <thead class="table-light">
                            <tr>
                                <th width="60">ID</th>
                                <th>Project</th>
                                <th>Sector</th>
                                <th>Street</th>
                                <th>Address</th>
                                <th>Plot Size</th>
                                <th>Size Category</th>
                                <th>Price</th>
                                <th>Property Type</th>
                                <th>Status</th>
                                <th width="130">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($list && $list->num_rows > 0): ?>
                                <?php while ($row = $list->fetch_assoc()): ?>
                                    <tr id="row-<?= $row['id'] ?>">
                                        <td><?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['project_name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($row['sector_name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($row['street'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($row['plot_detail_address']) ?></td>
                                        <td><?= htmlspecialchars($row['plot_size']) ?></td>
                                        <td><?= htmlspecialchars($row['size_name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($row['price']) ?></td>
                                        <td><?= htmlspecialchars($row['property_type'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($row['status']) ?></td>
                                        <td>
                                            <a href="form_plot.php?id=<?= $row['id'] ?>"
                                               class="btn btn-warning btn-sm me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="deletePlot(<?= $row['id'] ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-3">
                                        No plots found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-end">
                            <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                                <a class="page-link"
                                   href="?page=<?= $page - 1 ?>&<?= $queryBase ?>">«</a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($page == $i ? 'active' : '') ?>">
                                    <a class="page-link"
                                       href="?page=<?= $i ?>&<?= $queryBase ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($page >= $totalPages ? 'disabled' : '') ?>">
                                <a class="page-link"
                                   href="?page=<?= $page + 1 ?>&<?= $queryBase ?>">»</a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

        </div>
    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/adminlte.js"></script>

<script>
// Delete plot (already working)
function deletePlot(id) {
    if (!confirm("Delete this plot?")) return;

    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);

    fetch('api_plots.php', {
        method: 'POST',
        body: fd
    })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) {
                const row = document.getElementById('row-' + id);
                if (row) row.remove();
            }
        });
}

// === Dynamic dropdowns using api_plots.php (load_sectors, load_streets) ===
const currentProjectId = <?= json_encode($projectId) ?>;
const currentSectorId  = <?= json_encode($sectorId) ?>;
const currentStreetId  = <?= json_encode($streetId) ?>;

// Load sectors for a given project
function loadSectors(projectId, selectedSectorId = '') {
    const $sector = $('#sectorSelect');
    const $street = $('#streetSelect');

    if (!projectId || projectId === '0') {
        $sector.html('<option value="">All</option>');
        $street.html('<option value="">All</option>');
        return;
    }

    $.getJSON('api_plots.php', {
        action: 'load_sectors',
        project_id: projectId
    }, function (res) {
        let html = '<option value="">All</option>';

        if (Array.isArray(res) && res.length > 0) {
            res.forEach(function (sec) {
                const selected = (selectedSectorId && selectedSectorId == sec.sector_id) ? 'selected' : '';
                html += `<option value="${sec.sector_id}" ${selected}>${sec.sector_name}</option>`;
            });
        }

        $sector.html(html);

        // if sector changed manually, reset streets
        if (!selectedSectorId) {
            $street.html('<option value="">All</option>');
        }
    });
}

// Load streets for a given sector
function loadStreets(sectorId, selectedStreetId = '') {
    const $street = $('#streetSelect');

    if (!sectorId) {
        $street.html('<option value="">All</option>');
        return;
    }

    $.getJSON('api_plots.php', {
        action: 'load_streets',
        sector_id: sectorId
    }, function (res) {
        let html = '<option value="">All</option>';

        if (Array.isArray(res) && res.length > 0) {
            res.forEach(function (st) {
                const selected = (selectedStreetId && selectedStreetId == st.id) ? 'selected' : '';
                html += `<option value="${st.id}" ${selected}>${st.street}</option>`;
            });
        }

        $street.html(html);
    });
}

$(document).ready(function () {
    // Initial load when page opens (keep selected filters from GET)
    if (currentProjectId) {
        loadSectors(currentProjectId, currentSectorId);
    }
    if (currentSectorId) {
        loadStreets(currentSectorId, currentStreetId);
    }

    // When project changes → reload sectors and reset streets
    $('#projectSelect').on('change', function () {
        const pid = $(this).val();
        loadSectors(pid, '');
        $('#streetSelect').html('<option value="">All</option>');
    });

    // When sector changes → reload streets
    $('#sectorSelect').on('change', function () {
        const sid = $(this).val();
        loadStreets(sid, '');
    });
});
</script>

</body>
</html>
