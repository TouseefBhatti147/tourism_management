<?php
session_start();
require_once("../classes/News.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB Connection failed: " . $db->connect_error);
}

$newsObj = new News($db);

// Validate ID
$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid News ID");
}

// Fetch news data
$data = $newsObj->getById($id);
if (!$data) {
    die("News not found");
}
?>

<!doctype html>
<html lang="en">
<head>
  <style>
/* Wrapper for CKEditor / news details */
.details-content {
    overflow: hidden;
    word-wrap: break-word;
}

/* Make all images responsive */
.details-content img {
    max-width: 100% !important;
    height: auto !important;
    display: block;
    margin: 12px 0;
    border-radius: 6px;
    box-shadow: 0 0 4px rgba(0,0,0,0.2);
}

/* Remove inline width/height that break layout */
.details-content img[width],
.details-content img[height] {
    width: auto !important;
    height: auto !important;
}

/* Make long text behave properly */
.details-content p,
.details-content span,
.details-content div {
    max-width: 100% !important;
}

/* Optional: remove weird gaps */
.details-content br {
    line-height: 1.2;
}
</style>

    <meta charset="utf-8" />
    <title>View News</title>

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

    <!-- Header -->
    <div class="app-content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h3>View News / Event</h3>

            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="news_list.php">News List</a></li>
                <li class="breadcrumb-item active">View News</li>
            </ol>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-info mb-4">
                <div class="card-header">
                    <h3 class="card-title mb-0">View News (ID: <?= $id ?>)</h3>
                </div>

                <div class="card-body">

                    <dl class="row">

                        <dt class="col-sm-2">Teaser:</dt>
                        <dd class="col-sm-10">
                            <?= nl2br(htmlspecialchars($data['teaser'])) ?>
                        </dd>

                        <dt class="col-sm-2">Details:</dt>
                        <dd class="col-sm-10">
                          <div class="details-content">
                            <?= $data['details'] ?>
                        </div>
                        </dd>

                        <dt class="col-sm-2">Status:</dt>
                        <dd class="col-sm-10">
                            <?php if ($data['status'] === "Active"): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-2">Created:</dt>
                        <dd class="col-sm-10"><?= $data['create_date'] ?></dd>

                        <dt class="col-sm-2">Updated:</dt>
                        <dd class="col-sm-10"><?= $data['update_date'] ?></dd>

                    </dl>

                </div>

                <div class="card-footer">
                    <a href="news_list.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>

            </div>

        </div>
    </div>

</main>

<?php include("../includes/footer.php"); ?>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"></script>
<script src="../js/adminlte.js"></script>

</body>
</html>
