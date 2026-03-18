<?php session_start(); ?>
<?php
$id = $_GET["id"] ?? null;
$pageTitle = $id ? "Edit Country" : "Add Country";
$btn = $id ? "Update Country" : "Add Country";

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
require_once("../classes/Country.php");
$obj = new Country($db);

$data = $id ? $obj->getById($id) : null;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>

    <link rel="stylesheet" href="../css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
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

            <div class="card card-primary">
                <div class="card-header">
                    <h4><?= $pageTitle ?></h4>
                </div>

                <form id="countryForm">
                    <div class="card-body">

                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="mb-3">
                            <label class="form-label">Country Name</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="country_name" 
                                   required
                                   value="<?= htmlspecialchars($data['country_name'] ?? '') ?>">
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary"><?= $btn ?></button>
                        <a href="country_list.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </form>

            </div>

        </div>
    </div>

</main>

<?php include("../includes/footer.php"); ?>

</div>

<script>
document.getElementById("countryForm").addEventListener("submit", function(e){
    e.preventDefault();

    const fd = new FormData(this);
    fd.append("action", <?= $id ? "'update'" : "'add'" ?>);

    fetch("api_country.php", { method: "POST", body: fd })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) window.location.href = "country_list.php";
        });
});
</script>

</body>
</html>
