<?php
session_start();
require_once("../classes/News.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$obj = new News($db);
$list = $obj->getAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>News List</title>

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/adminlte.css" />

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

<?php include("../includes/header.php"); ?>

<aside class="app-sidebar bg-body-secondary shadow">
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
            <h3>News List</h3>
            <a href="form_news.php" class="btn btn-success">Add News</a>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card mb-4">
                <div class="card-body">

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Teaser</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th style="width:130px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $list->fetch_assoc()): ?>
                                <tr id="row-<?= $row['id'] ?>">
                                    <td><?= $row['id'] ?></td>

                                    <td><?= substr(strip_tags($row['teaser']), 0, 70) ?>...</td>

                                    <td>
                                        <?= $row['status']=="Active" 
                                            ? '<span class="badge bg-success">Active</span>'
                                            : '<span class="badge bg-secondary">Inactive</span>' ?>
                                    </td>

                                    <td><?= $row['create_date'] ?></td>
                                    <td><?= $row['update_date'] ?></td>

                                    <td>
                                <a href="view_news.php?id=<?= $row['id'] ?>" 
                                class="btn btn-info btn-sm me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="form_news.php?id=<?= $row['id'] ?>" 
                                class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <button class="btn btn-danger btn-sm"
                                        onclick="deleteNews(<?= $row['id'] ?>)">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>

</main>

<?php include("../includes/footer.php"); ?>

</div>

<script src="../js/adminlte.js"></script>

<script>
function deleteNews(id){
    if (!confirm("Delete this news item?")) return;

    fetch("api_news.php?action=delete&id="+id)
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success){
                document.getElementById("row-"+id).remove();
            }
        });
}
</script>

</body>
</html>
