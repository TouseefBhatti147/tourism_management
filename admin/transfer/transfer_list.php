<?php
session_start();
$db = new mysqli("localhost","root","","rdlpk_db1");
require_once("../classes/Transfer.php");

$tr = new Transfer($db);

// Search + pagination
$search = $_GET['search'] ?? '';
$page   = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit  = 20;
$offset = ($page - 1) * $limit;

$list  = $tr->getAll($search, $limit, $offset);
$total = $tr->getTotal($search);

$totalPages = ($total > 0) ? ceil($total / $limit) : 1;
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Plot Transfers</title>

<link rel="stylesheet" href="../css/adminlte.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

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
            <h3 class="mb-0">Plot Transfers</h3>

            <a href="form_transfer.php" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> New Transfer
            </a>
        </div>
    </div>

    <div class="app-content-wrapper">

        <!-- Search -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="get" class="row g-2">
                    <div class="col-md-4">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search plot / owner / buyer"
                               value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary">Search</button>
                        <a href="transfer_list.php" class="btn btn-secondary ms-1">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card mb-4">
            <div class="card-body p-0">

                <table class="table table-bordered table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Plot</th>
                            <th>From (Old Owner)</th>
                            <th>To (New Owner)</th>
                            <th>Date</th>
                            <th width="100">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if ($list && $list->num_rows > 0): ?>
                        <?php while ($row = $list->fetch_assoc()): ?>
                            <tr id="row-<?= $row['id'] ?>">
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['plot_detail_address']) ?> (<?= htmlspecialchars($row['plot_size']) ?>)</td>
                                <td><?= htmlspecialchars($row['from_member']) ?></td>
                                <td><?= htmlspecialchars($row['to_member']) ?></td>
                                <td><?= htmlspecialchars($row['create_date']) ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm"
                                            onclick="deleteTransfer(<?= $row['id'] ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                No transfers found.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>

            <!-- Pagination -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-end">
                    <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">«</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($page == $i ? 'active' : '') ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($page >= $totalPages ? 'disabled' : '') ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">»</a>
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
function deleteTransfer(id) {
    if (!confirm("Do you want to delete this transfer?")) return;

    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);

    fetch('api_transfer.php', {
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
</script>

</body>
</html>
