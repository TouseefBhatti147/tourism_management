<?php session_start(); ?>
<?php
$sliderId = $_GET['id'] ?? null;
$pageTitle = $sliderId ? 'Edit Slider' : 'Add Slider';
$btnText  = $sliderId ? 'Update Slider' : 'Add Slider';
$cardType = $sliderId ? 'card-success' : 'card-primary';

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

require_once("../classes/Slider.php");
$sliderObj = new Slider($db);

$slider = $sliderId ? $sliderObj->getById($sliderId) : null;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

    <!-- AdminLTE / Required CSS -->
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

    <!-- Sidebar -->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="../index.php" class="brand-link">
                <span class="brand-text fw-light">Real Estate E-System</span>
            </a>
        </div>
        <?php include("../includes/sidebar.php"); ?>
    </aside>

    <!-- Main Page -->
    <main class="app-main">

        <!-- Page Header -->
        <div class="app-content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <h3><?= $pageTitle ?></h3>
            </div>
        </div>

        <!-- Page Content -->
        <div class="app-content">
            <div class="container-fluid">

                <div class="card <?= $cardType ?> mb-4">
                    <div class="card-header">
                        <h4><?= $pageTitle ?></h4>
                    </div>

                    <form id="sliderForm" enctype="multipart/form-data">

                        <div class="card-body">

                            <input type="hidden" name="id" value="<?= $sliderId ?>">

                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                       value="<?= htmlspecialchars($slider['title'] ?? '') ?>" required>
                            </div>

                            <!-- Detail -->
                            <div class="mb-3">
                                <label class="form-label">Detail</label>
                                <input type="text" name="detail" class="form-control"
                                       value="<?= htmlspecialchars($slider['detail'] ?? '') ?>" required>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" id="imageInput" class="form-control">

                                <!-- Image Preview -->
                                <img id="previewImage"
                                     src="<?= $sliderId && $slider['image']
                                         ? '../assets/img/slider_images/' . $slider['image']
                                         : '' ?>"
                                     class="mt-3"
                                     style="max-width: 180px; display: <?= $sliderId && $slider['image'] ? 'block' : 'none'; ?>;">
                            </div>

                        </div>

                        <div class="card-footer text-end">
                            <button type="submit"
                                    class="btn <?= $sliderId ? 'btn-success' : 'btn-primary' ?>">
                                <?= $btnText ?>
                            </button>

                            <a href="slider_list.php" class="btn btn-secondary ms-2">Cancel</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<!-- JS Required for Sidebar & AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="../js/adminlte.js"></script>

<!-- Live Image Preview JS -->
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewImage');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    } else {
        preview.src = "";
        preview.style.display = "none";
    }
});
</script>

<!-- Form Submit -->
<script>
document.getElementById('sliderForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const fd = new FormData(this);
    fd.append("action", <?= $sliderId ? "'update'" : "'add'" ?>);

    fetch("api_slider.php", {
        method: "POST",
        body: fd
    })
    .then(res => res.json())
    .then(result => {
        alert(result.message);
        if (result.success) window.location.href = "slider_list.php";
    })
    .catch(err => alert("Error: " + err.message));
});
</script>

</body>
</html>
