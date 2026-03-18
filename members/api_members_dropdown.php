<?php
header('Content-Type: application/json');

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}

$sql = "SELECT id, name, username FROM member ORDER BY name";
$res = $db->query($sql);

$data = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $data[] = [
            'id'       => $row['id'],
            'name'     => $row['name'],
            'username' => $row['username']
        ];
    }
}

echo json_encode(['success' => true, 'data' => $data]);
exit;
