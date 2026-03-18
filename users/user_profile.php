<?php
require_once("../includes/db_connection.php");
require_once("../classes/User.php");

$pdo = Database::getConnection();
$userObj = new User($pdo);

$id = $_GET['id'] ?? null;
$record = $userObj->getUserById($id);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>User Profile</title>

<link rel="stylesheet" href="../css/adminlte.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

<style>
.profile-img {
    width: 120px;
    height: 120px;
    border-radius: 10px;
    object-fit: cover;
}
</style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

<?php include("../includes/header.php"); ?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <?php include("../includes/sidebar.php"); ?>
</aside>

<main class="app-main">
<div class="app-content">

    <div class="app-content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h3 class="mb-0">User Profile</h3>
            <a href="user_list.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="../../admin/assets/img/user_images/<?= $record['pic'] ?? 'no_image.png' ?>" class="profile-img">
                </div>

                <div class="col-md-9">

                    <h4><?= $record['firstname'] . ' ' . $record['middelname'] . ' ' . $record['lastname'] ?></h4>

                    <table class="table table-bordered mt-3">
                        <tr>
                            <th>Username</th>
                            <td><?= $record['username'] ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $record['email'] ?></td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td><?= $record['mobile'] ?></td>
                        </tr>
                        <tr>
                            <th>Father/Spouse</th>
                            <td><?= $record['sodowo'] ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?= $record['status'] == 1 ? "Active" : "Inactive" ?></td>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <td><?= date("d-m-Y", strtotime($record['create_date'])) ?></td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>
    </div>

</div>
</main>

<?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
