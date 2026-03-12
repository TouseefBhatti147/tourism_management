<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/admin/includes/db_connection.php";

$pdo = Database::getConnection();

// Get logged-in member ID
$member_id = $_SESSION['member_id'] ?? null;

if (!$member_id) {
    header("Location: " . $client . "login.php?error=not_logged_in");
    exit;
}

// Fetch membership records
$sql = "SELECT 
    mp.id AS membership_id,  
    mp.plotno,
    mp.plot_id,
    m.nomineename,
    p.project_name,
    pt.title AS plot_type,
    s.sector_name

FROM memberplot mp
LEFT JOIN member m              ON mp.member_id = m.id
LEFT JOIN plots pl              ON mp.plot_id   = pl.id
LEFT JOIN projects p            ON pl.project_id = p.id
LEFT JOIN property_types pt     ON pl.category_id = pt.property_type_id
LEFT JOIN sectors s             ON pl.sector_id = s.sector_id

WHERE mp.member_id = ?
ORDER BY mp.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$member_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
    <title>Membership | Real Estate E-system</title>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/admin/includes/headerLinks.php"; ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    <!-- Client Header -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/header-client.php"; ?>

    <!-- Sidebar -->
    <aside class="app-sidebar bg-light-subtle shadow" data-bs-theme="light">
        <div class="sidebar-brand">
            <a href="client-dashboard.php" class="brand-link">
                <span class="brand-text fw-light">Real Estate E-System</span>
            </a>
        </div>

        <?php include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/sidebar-client.php"; ?>
    </aside>

    <!-- Main Content -->
    <main class="app-main">

        <!-- Page Header -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Membership</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Membership</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="app-content">
            <div class="container-fluid">

                <div class="col-md-12">
                    <div class="card mb-6">

                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Project Name</th>
                                        <th>Type</th>
                                        <th>Membership No.</th>
                                        <th>Block Name</th>
                                        <th>Nominee Name</th>
                                        <th class="text-center">View Payment</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php if (empty($records)) { ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted p-3">
                                            No membership records found.
                                        </td>
                                    </tr>
                                <?php } else { 
                                    $sr = 1;
                                    foreach ($records as $row) { ?>
                                        <tr>
                                            <td><?= $sr++ ?></td>
                                            <td><?= htmlspecialchars($row['project_name']) ?></td>
                                            <td><?= htmlspecialchars($row['plot_type']) ?></td>
                                            <td><?= htmlspecialchars($row['plotno']) ?></td>
                                            <td><?= htmlspecialchars($row['sector_name']) ?></td>
                                            <td><?= htmlspecialchars($row['nomineename']) ?></td>

                                            <!-- New Payment Ledger Button -->
                                            <td class="text-center">
                                               <a href="paymentLedger.php?plot_id=<?= $row['plot_id'] ?>" 
   class="btn btn-sm btn-primary">View Ledger</a>

                                            </td>
                                        </tr>
                                <?php }} ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-end">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>

    <!-- Footer -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/admin/includes/footer.php"; ?>

</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/admin/includes/scripts.php"; ?>

</body>
</html>
