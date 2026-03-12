<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB Connection Failed: " . $db->connect_error);
}

$plot_id   = intval($_GET['plot_id'] ?? 0);
$member_id = intval($_GET['member_id'] ?? 0);

if ($plot_id <= 0 || $member_id <= 0) {
    die("Invalid request");
}

/* ============================
   Fetch Installment Schedule
===============================*/

$sql = "
    SELECT *
    FROM installpayment
    WHERE plot_id = $plot_id 
    AND mem_id = $member_id
    ORDER BY id ASC
";

$result = $db->query($sql);

if (!$result) {
    die("SQL Error: " . $db->error);
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Installment Schedule</title>
<link rel="stylesheet" href="../css/adminlte.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

<?php include("../includes/header.php"); ?>
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <?php include("../includes/sidebar.php"); ?>
</aside>

<main class="app-main">
<div class="app-content">

    <div class="app-content-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Installment Schedule</h3>
        <a href="memberplot_list.php" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-body p-0">

            <table class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Label</th>
                        <th>Due Amount</th>
                        <th>Due Date</th>
                        <th>Paid Amount</th>
                        <th>Paid Date</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                if ($result->num_rows > 0) {

                    $sr = 1;
                    while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $sr++ ?></td>
                        <td><?= htmlspecialchars($row['lab']) ?></td>
                        <td><?= htmlspecialchars($row['dueamount']) ?></td>
                        <td><?= htmlspecialchars($row['due_date_temp']) ?></td>
                        <td><?= htmlspecialchars($row['paidamount']) ?></td>
                        <td><?= htmlspecialchars($row['paid_date_temp']) ?></td>
                    </tr>

                <?php 
                    } 
                } else { 
                ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            No installment schedule found.
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
</main>

<?php include("../includes/footer.php"); ?>

</div>

</body>
</html>
