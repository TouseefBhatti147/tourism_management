<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../classes/MemberPlot.php");

// DB connection
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$mpObj = new MemberPlot($db);

// search + pagination
$search = $_GET['q'] ?? '';
$page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit  = 20;
$offset = ($page - 1) * $limit;

$list       = $mpObj->getAll(['search' => $search], $limit, $offset);
$totalRows  = $mpObj->getTotal(['search' => $search]);
$totalPages = ($totalRows > 0) ? ceil($totalRows / $limit) : 1;

// For export URLs
$exportQuery = http_build_query(['q' => $search]);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Member Plot List</title>

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
          media="print" onload="this.media='all'" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/adminlte.css" />

    <style>
        .table-nowrap td,
        .table-nowrap th {
            white-space: nowrap;
        }
    </style>
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
                <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h3 class="mb-0">Member Plot Assignments</h3>

                    <div class="d-flex flex-wrap gap-2">
                        <!-- Export buttons -->
                      
                        <a href="export_memberplots_excel.php?<?= $exportQuery ?>"
                           class="btn btn-outline-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                       

                        <a href="form_memberplot.php" class="btn btn-success ms-1">
                            <i class="bi bi-plus-lg"></i> Assign Plot
                        </a>
                    </div>
                </div>
            </div>

            <div class="app-content-wrapper">

                <!-- Search -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="get" class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <input type="text"
                                       name="q"
                                       class="form-control"
                                       placeholder="Search project / member / MS No / status / street"
                                       value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="memberplot_list.php" class="btn btn-secondary ms-1">Reset</a>
                            </div>
                            <div class="col-md-5 text-md-end text-muted small">
                                <?php if ($totalRows > 0): ?>
                                    Showing <?= $offset + 1 ?>–<?= min($offset + $limit, $totalRows) ?> of <?= $totalRows ?> records
                                <?php else: ?>
                                    No records to display.
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0 align-middle table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Sector</th>
                                        <th>Street</th>
                                        <th>Plot Size</th>
                                        <th>Member</th>
                                        <th>MS No</th>
                                        
                                        <th>Status</th>
                                       
                                        <th width="130">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if ($list && $list->num_rows > 0): ?>
                                    <?php while ($row = $list->fetch_assoc()): ?>
                                        <tr id="row-<?= $row['id'] ?>">
                                            <td><?= $row['id'] ?></td>

                                            <td><?= htmlspecialchars($row['project_name'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['sector_name'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['street_name'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['plot_size'] ?? '-') ?></td>

                                            <td><?= htmlspecialchars($row['member_name'] ?? $row['member_id']) ?></td>
                                            <td><?= htmlspecialchars($row['msno']) ?></td>
                                           

                                            <td>
                                                <?php
                                                $status = $row['status'];
                                                $badge  = 'secondary';
                                                if (strcasecmp($status, 'Approved') === 0) $badge = 'success';
                                                elseif (strcasecmp($status, 'Pending') === 0) $badge = 'warning';
                                                elseif (strcasecmp($status, 'Cancelled') === 0) $badge = 'danger';
                                                ?>
                                                <span class="badge bg-<?= $badge ?>">
                                                    <?= htmlspecialchars($status) ?>
                                                </span>
                                            </td>

                                        

                                           <td>
    <!-- Edit -->
    <a href="form_memberplot.php?id=<?= $row['id'] ?>"
       class="btn btn-warning btn-sm me-1">
        <i class="bi bi-pencil"></i>
    </a>

    <!-- Delete -->
    <button class="btn btn-danger btn-sm me-1"
            onclick="deleteMemberPlot(<?= $row['id'] ?>)">
        <i class="bi bi-trash"></i>
    </button>

    <!-- View Installments -->
    <a href="view_installment.php?plot_id=<?= $row['plot_id'] ?>&member_id=<?= $row['member_id'] ?>"
       class="btn btn-info btn-sm">
        <i class="bi bi-list-ul"></i>
    </a>
</td>

                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="13" class="text-center text-muted py-3">
                                            No records found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-end">
                            <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>&q=<?= urlencode($search) ?>">«</a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($page == $i ? 'active' : '') ?>">
                                    <a class="page-link"
                                       href="?page=<?= $i ?>&q=<?= urlencode($search) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($page >= $totalPages ? 'disabled' : '') ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>&q=<?= urlencode($search) ?>">»</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<script>
function deleteMemberPlot(id) {
    if (!confirm("Do you want to delete this record?")) return;

    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);

    fetch('api_memberplot.php', {
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
    .catch(e => alert('Error: ' + e.message));
}
</script>

<script src="https://cdn.jsdelivr.net/npm/overlaysscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="../js/adminlte.js"></script>

</body>
</html>
