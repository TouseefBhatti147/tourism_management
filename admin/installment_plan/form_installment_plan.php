<?php session_start(); ?>
<?php
$id = $_GET['id'] ?? null;
$pageTitle = $id ? "Edit Installment Plan" : "Add Installment Plan";
$btnText   = $id ? "Update Plan" : "Add Plan";

$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){
    echo json_encode(["success"=>false,"message"=>"DB connection failed"]);
    exit;
}
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

require_once("../classes/InstallmentPlan.php");

$planObj = new InstallmentPlan($db);
$plan    = $id ? $planObj->getById($id) : null;

// Load projects
$projectsRes = $db->query("SELECT id, project_name FROM projects ORDER BY project_name ASC");
// Load sizes
$sizesRes = $db->query("SELECT id, size FROM size_cat ORDER BY size ASC");
// Load property types
$ptypeRes = $db->query("SELECT property_type_id, title FROM property_types ORDER BY title ASC");

// Determine how many rows to show initially
$initialRows = 0;
if ($plan) {
    for ($i = 1; $i <= 62; $i++) {
        $labKey = "lab{$i}";
        $colKey = (string)$i;
        $hasVal = (!empty($plan[$labKey]) || !empty($plan[$colKey]));
        if ($hasVal) {
            $initialRows = $i;
        }
    }
}
if ($initialRows === 0) {
    $initialRows = 6; // show 6 rows by default on Add
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Installment Plan" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Admin Dashboard..." />
    <meta name="keywords" content="bootstrap 5, admin dashboard, accessible, WCAG" />
    <meta name="supported-color-schemes" content="light dark" />

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/adminlte.css" />

    <style>
        .installment-table th,
        .installment-table td {
            vertical-align: middle;
        }
        .installment-row.d-none {
            display: none !important;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <?php require("../includes/header.php"); ?>

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
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3><?= $pageTitle ?></h3>
                <a href="installment_plan_list.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card card-primary mb-4">
                    <div class="card-header">
                        <h4 class="mb-0"><?= $pageTitle ?></h4>
                    </div>

                    <form id="planForm">
                        <div class="card-body">

                            <input type="hidden" name="id" value="<?= htmlspecialchars($id ?? '') ?>">

                            <div class="row mb-3">
                                <!-- Project -->
                                <div class="col-md-4">
                                    <label class="form-label">Project</label>
                                    <select name="project_id" class="form-select" required>
                                        <option value="">Select Project</option>
                                        <?php if ($projectsRes): ?>
                                            <?php while ($p = $projectsRes->fetch_assoc()): ?>
                                                <option value="<?= $p['id'] ?>"
                                                    <?= isset($plan['project_id']) && $plan['project_id'] == $p['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($p['project_name']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Size from size_cat -->
                                <div class="col-md-4">
                                    <label class="form-label">Size (5, 10 Marla etc.)</label>
                                    <select name="size_cat_id" class="form-select" required>
                                        <option value="">Select Size</option>
                                        <?php if ($sizesRes): ?>
                                            <?php while ($s = $sizesRes->fetch_assoc()): ?>
                                                <option value="<?= $s['id'] ?>"
                                                    <?= isset($plan['size_cat_id']) && $plan['size_cat_id'] == $s['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($s['size']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <!-- Property Type from property_types -->
                                <div class="col-md-4">
                                    <label class="form-label">Property Type</label>
                                    <select name="p_type" class="form-select" required>
                                        <option value="">Select Type</option>
                                        <?php if ($ptypeRes): ?>
                                            <?php while ($t = $ptypeRes->fetch_assoc()): ?>
                                                <option value="<?= $t['property_type_id'] ?>"
                                                    <?= isset($plan['p_type']) && $plan['p_type'] == $t['property_type_id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($t['title']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($plan['description'] ?? '') ?></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Total Installments (tno)</label>
                                    <input type="number" name="tno" class="form-control"
                                           value="<?= htmlspecialchars($plan['tno'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Total Amount</label>
                                    <input type="text" name="tamount" id="tamount" class="form-control"
                                           value="<?= htmlspecialchars($plan['tamount'] ?? '') ?>">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="recalculateTotal()">
                                        Recalculate Total from Installments
                                    </button>
                                </div>
                            </div>

                            <hr>

                            <h5 class="mb-3">Installments (Label + Amount)</h5>

                            <div class="table-responsive">
                                <table class="table table-bordered installment-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60px;">#</th>
                                            <th>Label</th>
                                            <th style="width: 200px;">Amount</th>
                                            <th style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="installmentBody">
                                        <?php for ($i = 1; $i <= 62; $i++):
                                            $labKey    = "lab{$i}";
                                            $colKey    = (string)$i;
                                            $labelVal  = $plan[$labKey] ?? '';
                                            $amountVal = $plan[$colKey] ?? '';
                                            $showRow   = $i <= $initialRows;
                                        ?>
                                            <tr class="installment-row<?= $showRow ? '' : ' d-none' ?>" data-row="<?= $i ?>">
                                                <td><?= $i ?></td>
                                                <td>
                                                    <input type="text"
                                                           name="lab<?= $i ?>"
                                                           class="form-control"
                                                           placeholder="Label (e.g. Booking, Monthly, etc.)"
                                                           value="<?= htmlspecialchars($labelVal) ?>">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           name="amount<?= $i ?>"
                                                           class="form-control amount-field"
                                                           placeholder="Amount"
                                                           value="<?= htmlspecialchars($amountVal) ?>">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-danger"
                                                            onclick="removeRow(<?= $i ?>)">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>

                            <button type="button" class="btn btn-outline-success" onclick="addRow()">
                                <i class="bi bi-plus-lg"></i> Add Installment Row
                            </button>

                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary"><?= $btnText ?></button>
                            <a href="installment_plan_list.php" class="btn btn-secondary ms-2">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="../js/adminlte.js"></script>

<script>
function addRow() {
    const rows = document.querySelectorAll('.installment-row');
    for (let i = 0; i < rows.length; i++) {
        if (rows[i].classList.contains('d-none')) {
            rows[i].classList.remove('d-none');
            return;
        }
    }
    alert('Maximum 62 installments reached.');
}

function removeRow(i) {
    const row = document.querySelector('.installment-row[data-row="' + i + '"]');
    if (row) {
        row.classList.add('d-none');
        const labInput = row.querySelector('input[name="lab' + i + '"]');
        const amtInput = row.querySelector('input[name="amount' + i + '"]');
        if (labInput) labInput.value = '';
        if (amtInput) amtInput.value = '';
    }
}

function recalculateTotal() {
    const amountFields = document.querySelectorAll('.amount-field');
    let total = 0;
    amountFields.forEach(input => {
        const val = input.value.replace(/,/g, '').trim();
        if (val !== '' && !isNaN(val)) {
            total += parseFloat(val);
        }
    });
    document.getElementById('tamount').value = total;
}

document.getElementById('planForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const fd = new FormData(this);
    fd.append('action', <?= $id ? "'update'" : "'add'" ?>);

    fetch('api_installment_plan.php', {
        method: 'POST',
        body: fd
    })
    .then(r => r.json())
    .then(res => {
        alert(res.message);
        if (res.success) {
            window.location.href = 'installment_plan_list.php';
        }
    })
    .catch(err => alert('Error: ' + err.message));
});
</script>

</body>
</html>
