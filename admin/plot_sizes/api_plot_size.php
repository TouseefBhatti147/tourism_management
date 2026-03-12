<?php
header('Content-Type: application/json');
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rdlpk_db1";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "❌ DB connection failed: " . $conn->connect_error]);
    exit;
}

require_once("../classes/PlotSize.php");
$plotSize = new PlotSize($conn);

$method = $_SERVER['REQUEST_METHOD'];
$limit = 10;

// === GET: Fetch data ===
if ($method === 'GET') {
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $search = $_GET['search'] ?? '';
    $offset = ($page - 1) * $limit;

    $result = $plotSize->getAll($limit, $offset, $search);
    $total = $plotSize->countAll($search);
    $totalPages = max(1, ceil($total / $limit));

    $data = [];
    if ($result) while ($row = $result->fetch_assoc()) $data[] = $row;

    echo json_encode([
        'success' => true,
        'data' => $data,
        'pagination' => [
            'total' => $total,
            'current' => $page,
            'total_pages' => $totalPages
        ]
    ]);
    exit;
}

// === POST: Add / Update / Delete ===
if ($method === 'POST') {
    $action = $_POST['action'] ?? '';

    // Delete
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        $res = $plotSize->delete($id);
        echo json_encode($res['success']
            ? ['success' => true, 'message' => '✅ Deleted successfully.']
            : ['success' => false, 'message' => '❌ Delete failed: ' . $res['error']]
        );
        exit;
    }

    // Add / Update
    $data = [
        'id' => intval($_POST['id'] ?? 0),
        'size' => trim($_POST['size'] ?? ''),
        'type' => trim($_POST['type'] ?? ''),
        'code' => trim($_POST['code'] ?? '')
    ];

    if ($data['size'] === '' || $data['type'] === '' || $data['code'] === '') {
        echo json_encode(['success' => false, 'message' => '❌ All fields are required.']);
        exit;
    }

    if ($action === 'add') {
        $res = $plotSize->add($data);
        echo json_encode($res['success']
            ? ['success' => true, 'message' => '✅ Record added successfully.']
            : ['success' => false, 'message' => '❌ Insert failed: ' . $res['error']]
        );
        exit;
    }

    if ($action === 'update') {
        $res = $plotSize->update($data);
        echo json_encode($res['success']
            ? ['success' => true, 'message' => '✅ Record updated successfully.']
            : ['success' => false, 'message' => '❌ Update failed: ' . $res['error']]
        );
        exit;
    }

    echo json_encode(['success' => false, 'message' => '❌ Invalid action.']);
    exit;
}

echo json_encode(['success' => false, 'message' => '❌ Invalid request method.']);
?>
