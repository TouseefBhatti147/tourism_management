<?php session_start(); ?>
<?php
$chargeDataJSON = 'null';
$pageError = '';
$chargeId = isset($_GET['id']) ? trim($_GET['id']) : null;
$pageTitle = $chargeId ? 'Edit Charges' : 'Add New Charges';
$cardTitle = $chargeId ? 'Edit Charges Details' : 'New Charges Information';
$submitText = $chargeId ? 'Update Charges' : 'Add Charges';
$cardType = $chargeId ? 'card-success' : 'card-primary';

// ✅ Database connection
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    $pageError = "Database connection failed: " . $db->connect_error;
}

// ✅ Fetch all projects for dropdown
$projects = [];
if (empty($pageError)) {
    $result = $db->query("SELECT id, project_name FROM projects ORDER BY project_name ASC");
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// ✅ Fetch existing record (edit mode)
if ($chargeId && empty($pageError)) {
    $stmt = $db->prepare("SELECT * FROM charges WHERE id = ?");
    $stmt->bind_param("i", $chargeId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $charge = $result->fetch_assoc();
        $chargeDataJSON = json_encode(['success' => true, 'data' => $charge]);
    } else {
        $pageError = "⚠️ Record not found for ID: " . htmlspecialchars($chargeId);
        $chargeDataJSON = json_encode(['success' => false, 'message' => $pageError]);
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
<title><?= $pageTitle ?> - Real Estate E-System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/adminlte.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
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
                        <form id="chargesForm" method="POST">
                            <div class="card-body">
                                <div id="apiResponse" class="alert" style="display:none;"></div>
                                <?php if($pageError): ?>
                                    <div class="alert alert-danger"><?= $pageError ?></div>
                                <?php endif; ?>

                                <input type="hidden" name="id" id="chargeId" value="<?= htmlspecialchars($chargeId ?? '') ?>">

                                <!-- Project Dropdown -->
                                <div class="mb-3">
                                    <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                    <select class="form-select" id="project_id" name="project_id" required <?= $formDisabled?'disabled':'' ?>>
                                        <option value="">Select Project</option>
                                        <?php foreach ($projects as $p): ?>
                                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['project_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="note" class="form-label">Note <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="note" name="note" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="monthly" class="form-label">Monthly <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="monthly" name="monthly" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total" class="form-label">Total <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="total" name="total" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="type" name="type" required <?= $formDisabled?'disabled':'' ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <button type="submit" id="submitButton" class="btn <?= $chargeId?'btn-success':'btn-primary' ?>" <?= $formDisabled?'disabled':'' ?>>
                                    <?= $submitText ?>
                                </button>
                                <a href="charges.php" class="btn btn-secondary ms-2">Cancel</a>
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
const preloadedData = <?= $chargeDataJSON ?>;
const isUpdateMode = <?= $chargeId?'true':'false' ?>;

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('chargesForm');
    const apiResponseDiv = document.getElementById('apiResponse');
    const submitButton = document.getElementById('submitButton');

    if (isUpdateMode && preloadedData && preloadedData.success && preloadedData.data) {
        const data = preloadedData.data;
        document.getElementById('project_id').value = data.project_id || '';
        document.getElementById('name').value = data.name || '';
        document.getElementById('note').value = data.note || '';
        document.getElementById('monthly').value = data.monthly || '';
        document.getElementById('total').value = data.total || '';
        document.getElementById('type').value = data.type || '';
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitButton.disabled = true;
        submitButton.textContent = isUpdateMode ? 'Updating...' : 'Adding...';

        const formData = new FormData(this);
        formData.set('action', isUpdateMode ? 'update' : 'add');

        fetch('api_charges.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(result => {
                showApiResponse(result.message, result.success);
                if (result.success) {
                    setTimeout(() => window.location.href = 'charges.php', 1000);
                }
            })
            .catch(err => showApiResponse('Error: ' + err.message, false))
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = isUpdateMode ? 'Update Charges' : 'Add Charges';
            });
    });

    function showApiResponse(message, isSuccess) {
        apiResponseDiv.textContent = message;
        apiResponseDiv.style.display = 'block';
        apiResponseDiv.className = isSuccess ? 'alert alert-success' : 'alert alert-danger';
    }
});
</script>
</body>
</html>
