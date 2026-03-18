<?php
session_start();
require_once("../classes/Country.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$obj = new Country($db);
$list = $obj->getAll();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Country List</title>

    <link rel="stylesheet" href="../css/adminlte.css">
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
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
            <h3>Countries List</h3>
            <a href="form_country.php" class="btn btn-success">Add Country</a>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card mb-4">
                <div class="card-body">

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th style="width:70px;">ID</th>
                                <th>Country Name</th>
                                <th style="width:150px;">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $list->fetch_assoc()): ?>
                                <tr id="row-<?= $row['id'] ?>">
                                    <td><?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['country_name']) ?></td>

                                    <td>
                                        <a href="form_country.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-warning btn-sm me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <button class="btn btn-danger btn-sm"
                                                onclick="deleteCountry(<?= $row['id'] ?>)">
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

<script>
function deleteCountry(id){
    if (!confirm("Delete this country?")) return;

    fetch("api_country.php?action=delete&id="+id)
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
