<?php session_start(); ?>
<?php
$sectorDataJSON = 'null';
$pageError = '';
$sectorId = isset($_GET['id']) ? trim($_GET['id']) : null;
$pageTitle = $sectorId ? 'Edit Sector' : 'Add New Sector';
$cardTitle = $sectorId ? 'Edit Sector Details' : 'New Sector Information';
$submitText = $sectorId ? 'Update Sector' : 'Add Sector';
$cardType = $sectorId ? 'card-success' : 'card-primary';

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    $pageError = "Database connection failed: " . $db->connect_error;
}

// ✅ --- Fetch All Projects for Dropdown ---
$projects = [];
if (empty($pageError)) {
    $result = $db->query("SELECT id, project_name FROM projects ORDER BY project_name ASC");
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// ✅ --- Fetch Sector Data if Editing ---
if ($sectorId && empty($pageError)) {
    $stmt = $db->prepare("SELECT * FROM sectors WHERE id = ?");
    $stmt->bind_param("i", $sectorId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $sector = $result->fetch_assoc();
        $sectorDataJSON = json_encode(['success' => true, 'data' => $sector]);
    } else {
        $pageError = "⚠️ Sector not found for ID: " . htmlspecialchars($sectorId);
        $sectorDataJSON = json_encode(['success' => false, 'message' => $pageError]);
    }

    $stmt->close();
}
$db->close();

$formDisabled = !empty($pageError);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sector - <?= $pageTitle ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/adminlte.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">
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
    <div class="app-content-header mb-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3><?= $pageTitle ?></h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $pageTitle ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card <?= $cardType ?> mb-4 shadow-sm">
                        <div class="card-header"><h4><?= $cardTitle ?></h4></div>
                        <form id="sectorForm" method="POST">
                            <div class="card-body">
                                <div id="apiResponse" class="alert" style="display:none;"></div>
                                <?php if($pageError): ?>
                                <div class="alert alert-danger"><?= $pageError ?></div>
                                <?php endif; ?>

                                <input type="hidden" name="id" id="sectorId" value="<?= htmlspecialchars($sectorId ?? '') ?>">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="sectorName" class="form-label">Sector Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="sector_name" name="sector_name" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                   
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                        <select class="form-select" id="project_id" name="project_id" required <?= $formDisabled?'disabled':'' ?>>
                                            <option value="" disabled selected>Select Project</option>
                                            <?php foreach ($projects as $project): ?>
                                                <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['project_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="details" class="form-label">Details <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="details" name="details" rows="4" required <?= $formDisabled?'disabled':'' ?>></textarea>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <button type="submit" id="submitButton" class="btn <?= $sectorId?'btn-success':'btn-primary' ?>" <?= $formDisabled?'disabled':'' ?>><?= $submitText ?></button>
                                <a href="sectors.php" class="btn btn-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("../includes/footer.php"); ?>
</div>

<script>
const preloadedData = <?= $sectorDataJSON ?>;
const isUpdateMode = <?= $sectorId?'true':'false' ?>;

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('sectorForm');
    const apiResponseDiv = document.getElementById('apiResponse');
    const submitButton = document.getElementById('submitButton');

    if (isUpdateMode && preloadedData && preloadedData.success && preloadedData.data) {
        populateForm(preloadedData.data);
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = isUpdateMode ? 'Updating...' : 'Adding...';

        const formData = new FormData(this);
        formData.set('action', isUpdateMode ? 'update' : 'add');

        fetch('api_sectors.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(result => {
            showApiResponse(result.message, result.success);
            if (result.success) {
                setTimeout(() => window.location.href = 'sectors.php', 1000);
            }
        })
        .catch(err => {
            console.error(err);
            showApiResponse('Error: ' + err.message, false);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = isUpdateMode ? 'Update Sector' : 'Add Sector';
        });
    });

    function populateForm(data) {
        document.getElementById('sector_name').value = data.sector_name || '';
        document.getElementById('project_id').value = data.project_id || '';
        document.getElementById('details').value = data.details || '';
    }

    function showApiResponse(message, isSuccess) {
        apiResponseDiv.textContent = message;
        apiResponseDiv.style.display = 'block';
        apiResponseDiv.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
    }
});
</script>
</body>
</html>
