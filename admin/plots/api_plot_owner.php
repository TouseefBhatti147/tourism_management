<?php
header("Content-Type: application/json");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");

if ($db->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed"]);
    exit;
}

$plot_id = intval($_GET['plot_id'] ?? 0);

if ($plot_id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid plot ID"]);
    exit;
}

/* =====================================================
   1. FIND OWNER FROM memberplot TABLE
   ===================================================== */

$sqlOwner = "SELECT member_id FROM memberplot WHERE plot_id = ? LIMIT 1";
$stmt = $db->prepare($sqlOwner);

if (!$stmt) {
    echo json_encode([
        "success" => false,
        "message" => "Query Error (memberplot): " . $db->error
    ]);
    exit;
}

$stmt->bind_param("i", $plot_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode([
        "success" => false,
        "message" => "No owner found for this plot"
    ]);
    exit;
}

$ownerRow = $result->fetch_assoc();
$owner_id = intval($ownerRow['member_id']);


/* =====================================================
   2. FIND OWNER NAME FROM members TABLE
   ===================================================== */

$sqlMember = "SELECT name FROM member WHERE id = ? LIMIT 1";
$stmt2 = $db->prepare($sqlMember);

if (!$stmt2) {
    echo json_encode([
        "success" => false,
        "message" => "Query Error (member): " . $db->error
    ]);
    exit;
}

$stmt2->bind_param("i", $owner_id);
$stmt2->execute();
$res2 = $stmt2->get_result();

if ($res2->num_rows == 0) {
    echo json_encode([
        "success" => false,
        "message" => "Owner record missing in members table"
    ]);
    exit;
}

$member = $res2->fetch_assoc();


/* =====================================================
   SUCCESS RESPONSE
   ===================================================== */

echo json_encode([
    "success" => true,
    "owner_id" => $owner_id,
    "owner_name" => $member['name']
]);
exit;
