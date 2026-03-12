<?php
header('Content-Type: application/json');

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}

$project_id = $_GET['project_id'] ?? '';
$sector_id  = $_GET['sector_id'] ?? '';
$street_id  = $_GET['street_id'] ?? '';

$sql = "SELECT id, plot_detail_address, plot_size 
        FROM plots
        WHERE (status='' OR status IS NULL OR status!='Allotted')";

$params = [];
$types  = '';

if ($project_id !== '') {
    $sql      .= " AND project_id = ?";
    $params[] = $project_id;
    $types   .= 'i';
}
if ($sector_id !== '') {
    $sql      .= " AND sector_id = ?";
    $params[] = $sector_id;
    $types   .= 's';
}
if ($street_id !== '') {
    $sql      .= " AND street_id = ?";
    $params[] = $street_id;
    $types   .= 's';
}

$sql .= " ORDER BY id DESC";

$stmt = $db->prepare($sql);
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Query prepare failed']);
    exit;
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();

$data = [];
while ($row = $res->fetch_assoc()) {
    $data[] = [
        'id'                 => $row['id'],
        'plot_detail_address'=> $row['plot_detail_address'],
        'plot_size'          => $row['plot_size']
    ];
}

echo json_encode(['success' => true, 'data' => $data]);
exit;
