<?php
header('Content-Type: application/json');
session_start();

require_once("../classes/Category.php");
require_once("../classes/Pagination.php");

// ✅ Database connection
$conn = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "DB connection failed: " . $conn->connect_error]);
    exit;
}

$category = new Category($conn);

// ✅ GET: Fetch paginated list
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $result = $category->getAll($limit, $offset);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $total = $category->countAll();
    $pages = ceil($total / $limit);

    echo json_encode(['success' => true, 'data' => $data, 'pages' => $pages]);
    exit;
}

// ✅ POST: Add, Update, Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $data = [
        'id'      => isset($_POST['id']) ? intval($_POST['id']) : null,
        'title'   => trim($_POST['title'] ?? ''),
        'name'    => trim($_POST['name'] ?? ''),
        'charges' => trim($_POST['charges'] ?? '')
    ];

    if ($action === 'add') {
        $success = $category->add($data);
        echo json_encode(['success' => $success, 'message' => $success ? '✅ Category added successfully.' : '❌ Failed to add category.']);
        exit;
    }

    if ($action === 'update') {
        $success = $category->update($data);
        echo json_encode(['success' => $success, 'message' => $success ? '✅ Category updated successfully.' : '❌ Failed to update category.']);
        exit;
    }

    if ($action === 'delete') {
        $success = $category->delete($data['id']);
        echo json_encode(['success' => $success, 'message' => $success ? '✅ Category deleted successfully.' : '❌ Failed to delete category.']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => '❌ Invalid action.']);
    exit;
}

echo json_encode(['success' => false, 'message' => '❌ Invalid request method.']);
?>
