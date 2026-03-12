<?php
header('Content-Type: application/json');
session_start();

// --- Database connection ---
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rdlpk_db1";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "❌ Database connection failed: " . $conn->connect_error]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$limit = 10;

// ✅ --- GET: Fetch sectors (with optional project filter + pagination) ---
if ($method === 'GET') {
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($page - 1) * $limit;
    $projectId = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;

    $where = "";
    if ($projectId > 0) {
        $where = "WHERE s.project_id = $projectId";
    }

    // --- Count total rows ---
    $countQuery = "SELECT COUNT(*) as total FROM sectors s $where";
    $countResult = $conn->query($countQuery);
    $total = ($countResult && $row = $countResult->fetch_assoc()) ? (int)$row['total'] : 0;
    $totalPages = ceil($total / $limit);

    // --- Fetch data with pagination ---
    $query = "
        SELECT 
            s.sector_id AS sector_id, s.project_id, s.sector_name, s.details, s.details,
            p.project_name 
        FROM sectors s
        LEFT JOIN projects p ON s.project_id = p.id
        $where
        ORDER BY s.sector_id DESC
        LIMIT $limit OFFSET $offset
    ";

    $result = $conn->query($query);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

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

// ✅ --- POST: Handle Add / Update / Delete ---
if ($method === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- Delete ---
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => '❌ Invalid ID.']);
            exit;
        }
        $stmt = $conn->prepare("DELETE FROM sectors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => $success, 'message' => $success ? '✅ Sector deleted successfully.' : '❌ Failed to delete sector.']);
        exit;
    }

    // --- Add / Update common fields ---
    $project_id = intval($_POST['project_id'] ?? 0);
    $sector_name  = trim($_POST['sector_name'] ?? '');
    $details = trim($_POST['details'] ?? '');

    if (empty($project_id) || empty($sector_name)) {
        echo json_encode(['success' => false, 'message' => '❌ Please fill all required fields.']);
        exit;
    }

    // --- Add new sector ---
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO sectors (project_id, sector_name, details) VALUES (?, ?, ?)");
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => '❌ SQL Prepare Error: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param("iss", $project_id, $sector_name, $details);
        $success = $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => $success, 'message' => $success ? '✅ Sector added successfully.' : '❌ Failed to add sector.']);
        exit;
    }

    // --- Update existing sector ---
    if ($action === 'update') {
        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => '❌ Invalid sector ID.']);
            exit;
        }
        $stmt = $conn->prepare("UPDATE sectors SET project_id=?, sector_name=?, details=? WHERE id=?");
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => '❌ SQL Prepare Error: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param("issi", $project_id, $sector_name, $details, $id);
        $success = $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => $success, 'message' => $success ? '✅ Sector updated successfully.' : '❌ Failed to update sector.']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => '❌ Invalid action.']);
    exit;
}

// ❌ Invalid method
echo json_encode(['success' => false, 'message' => '❌ Invalid request method.']);
///////////////////////////////


?>
