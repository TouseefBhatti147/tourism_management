<?php
session_start();

require_once("../classes/City.php");
require_once("../classes/Country.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");

$cityObj = new City($db);
$countryObj = new Country($db);

$selected_country = $_GET['country_id'] ?? null;

$countries = $countryObj->getAll();
$list = $cityObj->getAll($selected_country);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Cities List</title>

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
            <h3>Cities List</h3>
            <a href="form_city.php" class="btn btn-success">Add City</a>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <!-- Country Filter -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <select name="country_id" class="form-select">
                                <option value="">All Countries</option>
                                <?php while ($c = $countries->fetch_assoc()): ?>
                                    <option value="<?= $c['id'] ?>"
                                        <?= $selected_country == $c['id'] ? 'selected' : '' ?>>
                                        <?= $c['country_name'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <a href="city_list.php" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cities Table -->
            <div class="card mb-4">
                <div class="card-body">

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>City Name</th>
                            <th>Country</th>
                            <th>Zipcode</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php while ($row = $list->fetch_assoc()): ?>
                            <tr id="row-<?= $row['id'] ?>">
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['city_name'] ?></td>
                                <td><?= $row['country_name'] ?></td>
                                <td><?= $row['zipcode'] ?></td>

                                <td>
                                    <a href="form_city.php?id=<?= $row['id'] ?>"
                                       class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <button class="btn btn-danger btn-sm"
                                            onclick="deleteCity(<?= $row['id'] ?>)">
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
function deleteCity(id){
    if (!confirm("Delete this city?")) return;

    fetch("api_city.php?action=delete&id="+id)
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
