<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/admin/includes/db_connection.php";

$pdo = Database::getConnection();

// Only logged-in members can access this page
if (!isset($_SESSION["member_loggedin"]) || $_SESSION["member_loggedin"] !== true) {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Logged-in member ID (ALWAYS trust session)
$member_id = $_SESSION["member_id"];

// Validate URL parameter
$plot_id = intval($_GET['plot_id'] ?? 0);

// Prevent access if plot_id missing
if ($plot_id <= 0) {
    die("Invalid request: plot not found");
}

// Fetch installment schedule for this member & plot
$sql = "
    SELECT *
    FROM installpayment
    WHERE plot_id = :plot_id
      AND mem_id  = :member_id
    ORDER BY id ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":plot_id"   => $plot_id,
    ":member_id" => $member_id
]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate totals safely
$total_due = 0;
$total_paid = 0;

foreach ($records as $r) {
    $total_due  += floatval($r['dueamount']);
    $total_paid += floatval($r['paidamount']);
}

$outstanding = $total_due - $total_paid;
?>

<!doctype html>
<html lang="en">
<head>
    <title>Payment Ledger | Real Estate E-system</title>
    <?php include $_SERVER['DOCUMENT_ROOT'] . "/real_estate_esystem/admin/includes/headerLinks.php"; ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Header -->
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
        <div class="app-content-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-0">Payment Ledger</h3>
                <small class="text-muted">Installment schedule & payment history</small>
            </div>

            <a href="membership.php" class="btn btn-secondary btn-sm">← Back</a>
        </div>

        <!-- Page Content -->
        <div class="app-content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-body p-0">

                        <table class="table table-bordered table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Label</th>
                                    <th>Due Amount (PKR)</th>
                                    <th>Due Date</th>
                                    <th>Paid Amount (PKR)</th>
                                    <th>Paid Date</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php if (empty($records)) { ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        No installment schedule found.
                                    </td>
                                </tr>
                            <?php } else { 
                                $sr = 1;
                                foreach ($records as $row) { ?>
                                    <tr>
                                        <td><?= $sr++ ?></td>
                                        <td><?= htmlspecialchars($row['lab']) ?></td>
                                        <td><?= number_format(floatval($row['dueamount'])) ?></td>
                                        <td><?= htmlspecialchars($row['due_date_temp']) ?></td>
                                        <td><?= number_format(floatval($row['paidamount'])) ?></td>
                                        <td><?= htmlspecialchars($row['paid_date_temp']) ?></td>
                                    </tr>
                            <?php } } ?>
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- TOTAL SUMMARY BOX -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="mb-3">Summary</h5>

                        <p><strong>Total Due:</strong> PKR <?= number_format($total_due) ?></p>
                        <p><strong>Total Paid:</strong> PKR <?= number_format($total_paid) ?></p>
                        <p><strong>Outstanding Balance:</strong> 
                            <span class="text-danger">
                                PKR <?= number_format($outstanding) ?>
                            </span>
                        </p>
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
