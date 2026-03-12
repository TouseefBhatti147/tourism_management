<?php session_start(); ?>
<?php
$id = $_GET["id"] ?? null;
$pageTitle = $id ? "Edit News" : "Add News";
$btn = $id ? "Update News" : "Add News";

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
require_once("../classes/News.php");
$newsObj = new News($db);

$data = $id ? $newsObj->getById($id) : null;
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../css/adminlte.css" />

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

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

            <div class="card card-primary mb-4">
                <div class="card-header"><h4><?= $pageTitle ?></h4></div>

                <form id="newsForm">
                    <div class="card-body">

                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="mb-3">
                            <label class="form-label">Teaser</label>
                            <textarea name="teaser" class="form-control" rows="3" required><?= $data['teaser'] ?? '' ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Details</label>
                            <textarea name="details" id="detailsEditor" class="form-control"><?= $data['details'] ?? '' ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Active" <?= isset($data['status']) && $data['status']=="Active" ? 'selected':'' ?>>Active</option>
                                <option value="Inactive" <?= isset($data['status']) && $data['status']=="Inactive" ? 'selected':'' ?>>Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary"><?= $btn ?></button>
                        <a href="news_list.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>

                </form>

            </div>

        </div>
    </div>

</main>

<?php include("../includes/footer.php"); ?>

</div>

<script src="../js/adminlte.js"></script>

<script>
CKEDITOR.replace("detailsEditor");

document.getElementById("newsForm").addEventListener("submit", function(e){
    e.preventDefault();

    const fd = new FormData(this);
    fd.append("action", <?= $id ? "'update'" : "'add'" ?>);
    fd.set("details", CKEDITOR.instances['detailsEditor'].getData());

    fetch("api_news.php", { method: "POST", body: fd })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) window.location.href = "news_list.php";
        });
});
</script>

</body>
</html>
