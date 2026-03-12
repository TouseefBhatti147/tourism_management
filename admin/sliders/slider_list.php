<?php
session_start();
require_once("../classes/Slider.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$sliderObj = new Slider($db);
$list = $sliderObj->getAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Slider List</title>

    <!-- AdminLTE CSS + Required -->
    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
          media="print" onload="this.media='all'" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/adminlte.css" />
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

        <!-- HEADER -->
        <div class="app-content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3>Slider List</h3>
                <a href="form_slider.php" class="btn btn-success">Add Slider</a>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card mb-4">
                    <div class="card-body">

                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th style="width:60px;">ID</th>
                                    <th>Title</th>
                                    <th>Detail</th>
                                    <th style="width:130px;">Image</th>
                                    <th style="width:150px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if ($list->num_rows > 0): ?>
                                    <?php while ($row = $list->fetch_assoc()): ?>
                                        <tr id="slider-row-<?= $row['id'] ?>">
                                            <td><?= $row['id'] ?></td>
                                            <td><?= htmlspecialchars($row['title']) ?></td>
                                            <td><?= htmlspecialchars($row['detail']) ?></td>

                                            <td>
                                                <img src="../assets/img/slider_images/<?= $row['image'] ?>"
                                                     width="120"
                                                     class="rounded border">
                                            </td>

                                            <td>
                                                <a href="form_slider.php?id=<?= $row['id'] ?>"
                                                   class="btn btn-warning btn-sm me-1">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <button class="btn btn-danger btn-sm"
                                                        onclick="deleteSlider(<?= $row['id'] ?>)">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5"
                                            class="text-center text-muted">
                                            No sliders found
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

<!-- AdminLTE Required JS -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="../js/adminlte.js"></script>

<script>
// DELETE SLIDER
function deleteSlider(id) {
    if (!confirm("Are you sure you want to delete this slider?")) return;

    fetch("api_slider.php?action=delete&id=" + id)
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                document.getElementById("slider-row-" + id).remove();
            }
        })
        .catch(err => alert("Error: " + err.message));
}
</script>

</body>
</html>
