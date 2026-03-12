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
    echo json_encode([
        'success' => false,
        'message' => "❌ Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$limit  = 10; // records per page

// ======================================================
// ✅ GET: Fetch streets (with optional filters + paging)
// ======================================================
if ($method === 'GET') {
    $page      = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset    = ($page - 1) * $limit;
    $projectId = isset($_GET['project_id']) ? intval($_GET['project_id']) : 0;
    $sectorId  = isset($_GET['sector_id']) ? intval($_GET['sector_id']) : 0;

    $whereParts = [];

    if ($projectId > 0) {
        $whereParts[] = "s.project_id = $projectId";
    }
    if ($sectorId > 0) {
        // ✅ sector_id is INT in streets & sectors
        $whereParts[] = "s.sector_id = $sectorId";
    }

    $where = '';
    if (!empty($whereParts)) {
        $where = 'WHERE ' . implode(' AND ', $whereParts);
    }

    // --- Count total matching rows ---
    $countSql = "SELECT COUNT(*) AS total FROM streets s $where";
    $countRes = $conn->query($countSql);
    $total    = ($countRes && $row = $countRes->fetch_assoc()) ? (int)$row['total'] : 0;
    $totalPages = $total > 0 ? ceil($total / $limit) : 1;

    // --- Fetch data with JOINs + pagination ---
    $sql = "
        SELECT
            s.id,
            s.project_id,
            s.sector_id,
            s.street,
            s.create_date,
            p.project_name,
            sec.sector_name
        FROM streets s
        LEFT JOIN projects p ON s.project_id = p.id
        LEFT JOIN sectors  sec ON s.sector_id = sec.sector_id
        $where
        ORDER BY s.id DESC
        LIMIT $limit OFFSET $offset
    ";

    $result = $conn->query($sql);
    $data   = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode([
        'success'    => true,
        'data'       => $data,
        'pagination' => [
            'total'       => $total,
            'current'     => $page,
            'total_pages' => $totalPages
        ]
    ]);
    exit;
}

// ======================================
// ✅ POST: Add / Update / Delete street
// ======================================
if ($method === 'POST') {
    $action = $_POST['action'] ?? '';

    // --- Delete ---
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            echo json_encode([
                'success' => false,
                'message' => '❌ Invalid street ID.'
            ]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM streets WHERE id = ?");
        if (!$stmt) {
            echo json_encode([
                'success' => false,
                'message' => '❌ SQL Prepare Error: ' . $conn->error
            ]);
            exit;
        }

        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();

        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Street deleted successfully.' : '❌ Failed to delete street.'
        ]);
        exit;
    }

    // --- Common fields for Add / Update ---
    $id         = intval($_POST['id'] ?? 0);
    $project_id = intval($_POST['project_id'] ?? 0);
    $sector_id  = intval($_POST['sector_id'] ?? 0); // ✅ INT
    $street     = trim($_POST['street'] ?? '');

    if ($project_id <= 0 || $sector_id <= 0 || $street === '') {
        echo json_encode([
            'success' => false,
            'message' => '❌ Please fill all required fields (project, sector, street).'
        ]);
        exit;
    }

    $now = date('Y-m-d H:i:s');

    // --- Add ---
    if ($action === 'add') {
        $stmt = $conn->prepare("
            INSERT INTO streets (project_id, sector_id, street, create_date, modify_date)
            VALUES (?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            echo json_encode([
                'success' => false,
                'message' => '❌ SQL Prepare Error: ' . $conn->error
            ]);
            exit;
        }

        $stmt->bind_param("iisss", $project_id, $sector_id, $street, $now, $now);
        $success = $stmt->execute();
        $stmt->close();

        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Street added successfully.' : '❌ Failed to add street.'
        ]);
        exit;
    }

    // --- Update ---
    if ($action === 'update') {
        if ($id <= 0) {
            echo json_encode([
                'success' => false,
                'message' => '❌ Invalid street ID for update.'
            ]);
            exit;
        }

        $stmt = $conn->prepare("
            UPDATE streets
            SET project_id = ?, sector_id = ?, street = ?, modify_date = ?
            WHERE id = ?
        ");

        if (!$stmt) {
            echo json_encode([
                'success' => false,
                'message' => '❌ SQL Prepare Error: ' . $conn->error
            ]);
            exit;
        }

        $stmt->bind_param("iissi", $project_id, $sector_id, $street, $now, $id);
        $success = $stmt->execute();
        $stmt->close();

        echo json_encode([
            'success' => $success,
            'message' => $success ? '✅ Street updated successfully.' : '❌ Failed to update street.'
        ]);
        exit;
    }

    echo json_encode([
        'success' => false,
        'message' => '❌ Invalid action.'
    ]);
    exit;
}

// ❌ Invalid method
echo json_encode([
    'success' => false,
    'message' => '❌ Invalid request method.'
]);
?>
