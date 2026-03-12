<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../classes/MemberPlot.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}

$mpObj  = new MemberPlot($db);
$search = $_GET['q'] ?? '';

$res = $mpObj->getAllForExport(['search' => $search]);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=memberplots.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Project</th>
        <th>Sector</th>
        <th>Street</th>
        <th>Plot Size</th>
        <th>Member</th>
        <th>MS No</th>
        <th>NOI</th>
        <th>Installment Plan</th>
        <th>Status</th>
        <th>Assigned By</th>
        <th>Create Date</th>
      </tr>";

if ($res) {
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['id'])."</td>";
        echo "<td>".htmlspecialchars($row['project_name'] ?? '')."</td>";
        echo "<td>".htmlspecialchars($row['sector_name'] ?? '')."</td>";
        echo "<td>".htmlspecialchars($row['street_name'] ?? '')."</td>";
        echo "<td>".htmlspecialchars($row['plot_size'] ?? '')."</td>";
        echo "<td>".htmlspecialchars($row['member_name'] ?? $row['member_id'])."</td>";
        echo "<td>".htmlspecialchars($row['msno'])."</td>";
        echo "<td>".htmlspecialchars($row['noi'])."</td>";
        echo "<td>".htmlspecialchars($row['insplan'])."</td>";
        echo "<td>".htmlspecialchars($row['status'])."</td>";
        echo "<td>".htmlspecialchars($row['assigned_user'] ?? $row['uid'])."</td>";
        echo "<td>";
        if (!empty($row['create_date'])) {
            echo htmlspecialchars(date("Y-m-d H:i", strtotime($row['create_date'])));
        }
        echo "</td>";
        echo "</tr>";
    }
}
echo "</table>";
exit;
