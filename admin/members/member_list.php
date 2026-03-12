<?php
session_start();
require_once("../classes/Member.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$memberObj = new Member($db);

// pagination setup
$search  = $_GET['q'] ?? '';
$page    = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit   = 10;
$offset  = ($page - 1) * $limit;

$list       = $memberObj->getAll($search, $limit, $offset);
$totalRows  = $memberObj->getTotal($search);
$totalPages = ceil($totalRows / $limit);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Members List</title>

    <link rel="stylesheet" href="../css/adminlte.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <style>
        .member-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        .app-content-wrapper { overflow: visible !important; }
        body, html { overflow-y: auto !important; }
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
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Members</h3>
                    <a href="form_member.php" class="btn btn-success">
                        <i class="bi bi-plus-lg"></i> Add Member
                    </a>
                </div>
            </div>

            <div class="app-content-wrapper">

                <!-- SEARCH -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form method="get" class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="q" class="form-control"
                                       placeholder="Search name, username, CNIC, phone"
                                       value="<?= htmlspecialchars($search) ?>">
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="member_list.php" class="btn btn-secondary ms-1">Reset</a>
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
                                    <th style="width:50px;">ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>CNIC</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                    <th style="width:160px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php if ($list && $list->num_rows > 0): ?>
                                <?php while ($row = $list->fetch_assoc()): ?>
                                    <tr id="row-<?= $row['id'] ?>">
                                        <td><?= $row['id'] ?></td>

                                        <td>
                                            <?php if (!empty($row['image'])): ?>
                                                <img src="../assets/img/member_images/<?= $row['image'] ?>" class="member-avatar">
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>

                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['username']) ?></td>
                                        <td><?= htmlspecialchars($row['cnic']) ?></td>
                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                        <td><?= htmlspecialchars($row['city_name'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($row['country_name'] ?? '') ?></td>

                                        <td>
                                            <?php if (strtolower($row['status']) === 'active'): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php elseif (strtolower($row['status']) === 'inactive'): ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= $row['status'] ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <a href="view_member.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm me-1">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="form_member.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="deleteMember(<?= $row['id'] ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="10" class="text-center text-muted py-3">No members found.</td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                    <!-- PAGINATION -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-end">

                            <!-- PREVIOUS -->
                            <li class="page-item <?= ($page <= 1 ? 'disabled' : '') ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>&q=<?= urlencode($search) ?>">«</a>
                            </li>

                            <!-- PAGE NUMBERS -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($page == $i ? 'active' : '') ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($search) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- NEXT -->
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
function deleteMember(id) {
    if (!confirm('Delete this member?')) return;

    const fd = new FormData();
    fd.append('action', 'delete');
    fd.append('id', id);

    fetch('api_member.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) document.getElementById('row-' + id).remove();
        });
}
</script>

</body>
</html>
