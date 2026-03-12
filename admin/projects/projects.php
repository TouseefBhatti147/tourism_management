<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Projects List</title>
    <link rel="stylesheet" href="../css/adminlte.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .thumb-img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
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
                    <div class="col-sm-6"><h3>Projects List</h3></div>
                    <div class="col-sm-6 text-end">
                        <a href="form_project.php" class="btn btn-primary">+ Add New Project</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">All Projects</h5>
                    </div>

                    <div class="card-body p-3">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th width="60">ID</th>
                                    <th>Project Name</th>
                                    <th>Image</th>
                                    <th>Map</th>
                                    <th>Status</th>
                                    <th width="180">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php while ($p = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $p['id'] ?></td>

                                    <td><?= htmlspecialchars($p['project_name']) ?></td>

                                    <td>
                                        <?php if ($p['project_images']) { ?>
                                            <img src="/real_estate_esystem/admin/assets/img/projects/<?= $p['project_images']; ?>" class="thumb-img">
                                        <?php } else { ?>
                                            <span class="text-muted">No Image</span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ($p['project_map']) { ?>
                                            <img src="/real_estate_esystem/admin/assets/img/projects/<?= $p['project_map']; ?>" class="thumb-img">
                                        <?php } else { ?>
                                            <span class="text-muted">No Map</span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <span class="badge <?= $p['status'] ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $p['status'] ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>

                                    <td class="text-center">

                                        <a href="form_project.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <button class="btn btn-sm btn-danger"
                                                onclick="deleteProject(<?= $p['id'] ?>)">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>

                                    </td>
                                </tr>
                            <?php } ?>
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
function deleteProject(id) {
    if (!confirm("Are you sure you want to delete this project?")) return;

    fetch("api_projects.php", {
        method: "POST",
        body: new URLSearchParams({
            action: "delete",
            id: id
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload();
        }
    })
    .catch(err => {
        alert("Delete failed: " + err);
    });
}
</script>

</body>
</html>
