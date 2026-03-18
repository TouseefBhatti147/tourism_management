<?php session_start(); ?>
<?php
$id = $_GET["id"] ?? null;
$pageTitle = $id ? "Edit City" : "Add City";
$btn = $id ? "Update City" : "Add City";

$db = new mysqli("localhost", "root", "", "rdlpk_db1");

require_once("../classes/City.php");
require_once("../classes/Country.php");

$cityObj = new City($db);
$countryObj = new Country($db);

$data = $id ? $cityObj->getById($id) : null;
$countries = $countryObj->getAll();
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
                <div class="card-header"><h4><?= $pageTitle ?></h4></div>

                <form id="cityForm">
                    <div class="card-body">

                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="mb-3">
                            <label class="form-label">City Name</label>
                            <input type="text" class="form-control"
                                name="city_name" required
                                value="<?= htmlspecialchars($data['city_name'] ?? '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select name="country_id" class="form-select" required>
                                <option value="">Select Country</option>
                                <?php while ($c = $countries->fetch_assoc()): ?>
                                    <option value="<?= $c['id'] ?>"
                                        <?= isset($data['country_id']) && $data['country_id'] == $c['id'] ? 'selected' : '' ?>>
                                        <?= $c['country_name'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Zip Code</label>
                            <input type="text" class="form-control"
                                name="zipcode"
                                value="<?= htmlspecialchars($data['zipcode'] ?? '') ?>">
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary"><?= $btn ?></button>
                        <a href="city_list.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </form>

            </div>

        </div>
    </div>

</main>

<?php include("../includes/footer.php"); ?>

</div>

<script>
document.getElementById("cityForm").addEventListener("submit", function(e){
    e.preventDefault();

    const fd = new FormData(this);
    fd.append("action", <?= $id ? "'update'" : "'add'" ?>);

    fetch("api_city.php", { method: "POST", body: fd })
        .then(r => r.json())
        .then(res => {
            alert(res.message);
            if (res.success) window.location.href = "city_list.php";
        });
});
</script>

</body>
</html>
