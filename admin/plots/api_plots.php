<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once("../classes/Plot.php");

// --- DB connection ---
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "DB connection failed: " . $db->connect_error
    ]);
    exit;
}

$plotObj = new Plot($db);

$action = $_REQUEST['action'] ?? '';

switch ($action) {

    // ------------------------- ADD -------------------------
    case 'add':

        $data = [
            'project_id'          => (int)($_POST['project_id'] ?? 0),
            'sector_id'           => (int)($_POST['sector_id'] ?? 0),
            'street_id'           => (int)($_POST['street_id'] ?? 0),
            'plot_detail_address' => trim($_POST['plot_detail_address'] ?? ''),
            'plot_size'           => trim($_POST['plot_size'] ?? ''),
            'size_cat_id'         => (int)($_POST['size_cat_id'] ?? 0),
            'installment'         => (int)($_POST['installment'] ?? 0),
            'price'               => trim($_POST['price'] ?? ''),
            'basic_price'         => trim($_POST['basic_price'] ?? ''),
            'category_id'         => (int)($_POST['category_id'] ?? 0),
            'location'            => trim($_POST['location'] ?? ''),
            'plot_dimension'      => trim($_POST['plot_dimension'] ?? ''),
            'status'              => trim($_POST['status'] ?? '')
        ];

        // basic validation
        if (
            $data['project_id'] <= 0 ||
            $data['sector_id'] <= 0 ||
            $data['street_id'] <= 0 ||
            $data['plot_detail_address'] === '' ||
            $data['plot_size'] === '' ||
            $data['category_id'] <= 0 ||
            $data['status'] === ''
        ) {
            echo json_encode([
                "success" => false,
                "message" => "Please fill all required fields."
            ]);
            exit;
        }

        $ok = $plotObj->add($data);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Plot added successfully" : "Add failed"
        ]);
        exit;

    // ------------------------- UPDATE -------------------------
    case 'update':

        $data = [
            'id'                  => (int)($_POST['id'] ?? 0),
            'project_id'          => (int)($_POST['project_id'] ?? 0),
            'sector_id'           => (int)($_POST['sector_id'] ?? 0),
            'street_id'           => (int)($_POST['street_id'] ?? 0),
            'plot_detail_address' => trim($_POST['plot_detail_address'] ?? ''),
            'plot_size'           => trim($_POST['plot_size'] ?? ''),
            'size_cat_id'         => (int)($_POST['size_cat_id'] ?? 0),
            'installment'         => (int)($_POST['installment'] ?? 0),
            'price'               => trim($_POST['price'] ?? ''),
            'basic_price'         => trim($_POST['basic_price'] ?? ''),
            'category_id'         => (int)($_POST['category_id'] ?? 0),
            'location'            => trim($_POST['location'] ?? ''),
            'plot_dimension'      => trim($_POST['plot_dimension'] ?? ''),
            'status'              => trim($_POST['status'] ?? '')
        ];

        if ($data['id'] <= 0) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid plot ID."
            ]);
            exit;
        }

        $ok = $plotObj->update($data);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Plot updated successfully" : "Update failed"
        ]);
        exit;

    // ------------------------- DELETE -------------------------
    case 'delete':

        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
        $ok = $id ? $plotObj->delete($id) : false;

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Plot deleted successfully" : "Delete failed"
        ]);
        exit;

    // ------------------------- LOAD SECTORS -------------------
    case 'load_sectors':

        $projectId = $_GET['project_id'] ?? '';
        $res = $plotObj->getSectorsByProject($projectId);

        $rows = [];
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                // will contain: sector_id, sector_name
                $rows[] = $r;
            }
        }

        echo json_encode($rows);
        exit;

    // ------------------------- LOAD STREETS -------------------
    case 'load_streets':

        $sectorId = $_GET['sector_id'] ?? '';
        $res = $plotObj->getStreetsBySector($sectorId);

        $rows = [];
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                // will contain: id, street
                $rows[] = $r;
            }
        }

        echo json_encode($rows);
        exit;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Invalid action"
        ]);
        exit;
}
