<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../includes/db_connection.php';
require_once '../classes/User.php';

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    die("DB connection failed");
}

$userObj = new User($pdo);

$id      = $_GET['id'] ?? null;
$record  = null;

if ($id) {
    $record = $userObj->getUserById($id);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= $id ? "Edit User" : "Add User" ?></title>

    <link rel="stylesheet" href="../css/adminlte.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <style>
        .user-avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 8px;
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
            <h3 class="mb-0"><?= $id ? "Edit User" : "Add User" ?></h3>
            <a href="user_list.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="api_users.php" method="post" enctype="multipart/form-data">

                <input type="hidden" name="action" value="<?= $id ? 'update' : 'add' ?>">
                <input type="hidden" name="id" value="<?= $record['id'] ?? '' ?>">
                <input type="hidden" name="old_pic" value="<?= $record['pic'] ?? '' ?>">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label>First Name</label>
                        <input type="text" name="firstname" class="form-control" required
                               value="<?= htmlspecialchars($record['firstname'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Middle Name</label>
                        <input type="text" name="middelname" class="form-control"
                               value="<?= htmlspecialchars($record['middelname'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Last Name</label>
                        <input type="text" name="lastname" class="form-control"
                               value="<?= htmlspecialchars($record['lastname'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Father / Spouse Name</label>
                        <input type="text" name="sodowo" class="form-control"
                               value="<?= htmlspecialchars($record['sodowo'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= htmlspecialchars($record['email'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control"
                               value="<?= htmlspecialchars($record['mobile'] ?? '') ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required
                               value="<?= htmlspecialchars($record['username'] ?? '') ?>">
                    </div>

                    <?php if (!$id): ?>
                    <div class="col-md-4">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <?php else: ?>
                    <div class="col-md-4">
                        <label>New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <?php endif; ?>

                    <div class="col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" <?= (isset($record['status']) && $record['status']==1 ? 'selected' : '') ?>>Active</option>
                            <option value="0" <?= (isset($record['status']) && $record['status']==0 ? 'selected' : '') ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>User Image</label>
                        <input type="file" name="pic" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <?php if (!empty($record['pic'])): ?>
                            <img src="../../assets/img/user_images/<?= htmlspecialchars($record['pic']) ?>"
                                 class="user-avatar-preview mt-2">
                        <?php else: ?>
                            <p class="text-muted mt-3">No image</p>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-primary"><?= $id ? "Update User" : "Add User" ?></button>
                </div>
            </form>

        </div>
    </div>

</div>
</main>

<?php include("../includes/footer.php"); ?>
</div>
</body>
</html>
