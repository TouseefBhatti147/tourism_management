<?php session_start(); ?>
<?php
$id = $_GET['id'] ?? null;
$pageTitle = $id ? 'Edit Sales Center' : 'Add Sales Center';
$btn = $id ? 'Update Sales Center' : 'Add Sales Center';
$card = $id ? 'card-success' : 'card-primary';

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
require_once("../classes/SaleCenter.php");

$obj = new SaleCenter($db);
$data = $id ? $obj->getById($id) : null;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

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
            <h3><?= $pageTitle ?></h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card <?= $card ?> mb-4">
                <div class="card-header"><h4><?= $pageTitle ?></h4></div>

                <form id="saleCenterForm" enctype="multipart/form-data">
                    <div class="card-body">

                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail</label>
                            <textarea name="detail" class="form-control" rows="3"
                                      required><?= htmlspecialchars($data['detail'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="1" <?= isset($data['status']) && $data['status']==1 ? 'selected':'' ?>>Active</option>
                                <option value="0" <?= isset($data['status']) && $data['status']==0 ? 'selected':'' ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" id="imageInput" class="form-control">

                            <img id="previewImage"
                                 src="<?= $id && $data['image'] ? '../assets/img/sales_center_images/'.$data['image'] : '' ?>"
                                 class="mt-3" style="max-width:150px; display: <?= $id && $data['image'] ? 'block' : 'none' ?>">
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button class="btn <?= $id ? 'btn-success':'btn-primary' ?>"><?= $btn ?></button>
                        <a href="sale_center_list.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

</main>

<?php include("../includes/footer.php"); ?>

</div>

<!-- Required JS -->
<script src="../js/adminlte.js"></script>

<script>
// Image Preview
document.getElementById("imageInput").addEventListener("change", function(e){
    const file = e.target.files[0];
    const preview = document.getElementById("previewImage");

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});
</script>

<script>
// Form Submit
document.getElementById("saleCenterForm").addEventListener("submit", function(e){
    e.preventDefault();

    const fd = new FormData(this);
    fd.append("action", <?= $id ? "'update'" : "'add'" ?>);

    fetch("api_sale_center.php", { method: 'POST', body: fd })
        .then(res => res.json())
        .then(d => {
            alert(d.message);
            if (d.success) window.location.href = "sale_center_list.php";
        });
});
</script>

</body>
</html>
