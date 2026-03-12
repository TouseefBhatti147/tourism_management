<?php
session_start();
require_once("../classes/InstallmentPlan.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$planObj = new InstallmentPlan($db);
$list    = $planObj->getAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Installment Plans</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | Installment Plans" />
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
                <h3>Installment Plans</h3>
                <a href="form_installment_plan.php" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Add Installment Plan
                </a>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card mb-4">
                    <div class="card-body">

                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:70px;">ID</th>
                                    <th>Project</th>
                                    <th>Size</th>
                                    <th>Property Type</th>
                                    <th>Total Installments</th>
                                    <th>Total Amount</th>
                                    <th style="width:150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($list && $list->num_rows > 0): ?>
                                    <?php while ($row = $list->fetch_assoc()): ?>
                                        <tr id="row-<?= $row['id'] ?>">
                                            <td><?= $row['id'] ?></td>
                                            <td><?= htmlspecialchars($row['project_name'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['size_title'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['property_title'] ?? '') ?></td>
                                            <td><?= htmlspecialchars($row['tno']) ?></td>
                                            <td><?= htmlspecialchars($row['tamount']) ?></td>
                                            <td>
                                                <a href="form_installment_plan.php?id=<?= $row['id'] ?>"
                                                   class="btn btn-warning btn-sm me-1" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="deletePlan(<?= $row['id'] ?>)"
                                                        title="Delete">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            No installment plans found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
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
function deletePlan(id) {
    if (!confirm('Delete this installment plan?')) return;

    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);

    fetch('api_installment_plan.php', {
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
    })
    .catch(err => alert('Error: ' + err.message));
}
</script>

</body>
</html>
