<?php
session_start();
require_once("../classes/Member.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$memberObj = new Member($db);

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid member ID");
}

$data = $memberObj->getById($id);
if (!$data) {
    die("Member not found");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>View Member</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="Admin | View Member" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Admin Dashboard..." />
    <meta name="keywords" content="bootstrap 5, admin dashboard, accessible, WCAG" />
    <meta name="supported-color-schemes" content="light dark" />

    <link rel="preload" href="../css/adminlte.css" as="style" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      crossorigin="anonymous"
      media="print"
      onload="this.media='all'"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/adminlte.css" />

    <style>
        .member-photo-lg {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <?php require("../includes/header.php"); ?>

    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
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
                <h3>View Member (ID: <?= htmlspecialchars($data['id']) ?>)</h3>
                <div>
                    <a href="member_list.php" class="btn btn-secondary me-1">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                    <a href="form_member.php?id=<?= $data['id'] ?>" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">

                <div class="card card-info mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Member Details</h4>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <?php if (!empty($data['image'])): ?>
                                    <img src="../assets/img/member_images/<?= htmlspecialchars($data['image']) ?>"
                                         alt="Member" class="member-photo-lg">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/150?text=No+Image"
                                         alt="No Image" class="member-photo-lg">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-9">
                                <dl class="row mb-0">
                                    <dt class="col-sm-3">Name:</dt>
                                    <dd class="col-sm-9"><?= htmlspecialchars($data['name']) ?></dd>

                                    <dt class="col-sm-3">Username:</dt>
                                    <dd class="col-sm-9"><?= htmlspecialchars($data['username']) ?></dd>

                                    <dt class="col-sm-3">Title:</dt>
                                    <dd class="col-sm-9"><?= htmlspecialchars($data['title']) ?></dd>

                                    <dt class="col-sm-3">CNIC:</dt>
                                    <dd class="col-sm-9"><?= htmlspecialchars($data['cnic']) ?></dd>

                                    <dt class="col-sm-3">S/O, D/O, W/O:</dt>
                                    <dd class="col-sm-9"><?= htmlspecialchars($data['sodowo']) ?></dd>

                                    <dt class="col-sm-3">Business Title:</dt>
                                    <dd class="col-sm-9"><?= htmlspecialchars($data['business_title']) ?></dd>
                                </dl>
                            </div>
                        </div>

                        <hr>

                        <h5>Contact & Address</h5>
                        <dl class="row">
                            <dt class="col-sm-3">Address:</dt>
                            <dd class="col-sm-9"><?= nl2br(htmlspecialchars($data['address'])) ?></dd>

                            <dt class="col-sm-3">City:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['city_name'] ?? '') ?></dd>

                            <dt class="col-sm-3">State:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['state']) ?></dd>

                            <dt class="col-sm-3">Country:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['country_name'] ?? '') ?></dd>

                            <dt class="col-sm-3">Phone:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['phone']) ?></dd>

                            <dt class="col-sm-3">Email:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['email']) ?></dd>

                            <dt class="col-sm-3">RWA:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['rwa']) ?></dd>

                            <dt class="col-sm-3">Create Date:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['create_date']) ?></dd>
                        </dl>

                        <hr>

                        <h5>Nominee Info</h5>
                        <dl class="row">
                            <dt class="col-sm-3">Nominee Name:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['nomineename']) ?></dd>

                            <dt class="col-sm-3">Nominee CNIC:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['nomineecnic']) ?></dd>
                        </dl>

                        <hr>

                        <h5>Account & Status</h5>
                        <dl class="row">
                            <dt class="col-sm-3">Status:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['status']) ?></dd>

                            <dt class="col-sm-3">Member Type:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['mtype']) ?></dd>

                            <dt class="col-sm-3">Login Status:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['login_status']) ?></dd>

                            <dt class="col-sm-3">DOB:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($data['dob']) ?></dd>

                            <dt class="col-sm-3">FP:</dt>
                            <dd class="col-sm-9"><pre class="mb-0"><?= htmlspecialchars($data['fp']) ?></pre></dd>
                        </dl>
                    </div>

                    <div class="card-footer">
                        <a href="member_list.php" class="btn btn-secondary ms-2">Back to List</a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <?php include("../includes/footer.php"); ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="../js/adminlte.js"></script>

</body>
</html>
