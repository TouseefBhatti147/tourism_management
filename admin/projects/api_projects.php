<?php
session_start();
header('Content-Type: application/json');

require_once("../classes/Project.php");

// DB CONNECTION
$conn = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => "DB Connection Failed"]);
    exit;
}

$projectObj = new Project($conn);
$action     = $_POST['action'] ?? '';
$id         = intval($_POST['id'] ?? 0);

/**
 * Upload a single file AND store it in:
 * admin/assets/img/projects/
 * DB will store only the filename (e.g. project_123.jpg)
 */
function uploadSingleFile(string $inputName): string
{
    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $file = $_FILES[$inputName];

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = uniqid($inputName . "_") . "." . $ext;

    // Correct physical path
    $folder = realpath(__DIR__ . "/../assets/img/projects/");

    if ($folder === false) {
        $folder = __DIR__ . "/../assets/img/projects/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
    }

    $destination = $folder . "/" . $newName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $newName; // store only file name
    }

    return "";
}

/* =========================================================
   ADD PROJECT
========================================================= */

if ($action === "add") {

    $projectImage = uploadSingleFile("projectImages");
    $projectMap   = uploadSingleFile("projectMap");

    if ($projectImage === "" || $projectMap === "") {
        echo json_encode(['success' => false, 'message' => "Image or Map upload failed"]);
        exit;
    }

    $data = [
        'project_name'    => $_POST['projectName'],
        'teaser'          => $_POST['teaser'],
        'project_url'     => $_POST['project_url'],
        'project_details' => $_POST['project_details'],
        'status'          => intval($_POST['status']),
        'project_images'  => $projectImage,
        'project_map'     => $projectMap
    ];

    echo json_encode($projectObj->addProject($data));
    exit;
}

/* =========================================================
   UPDATE PROJECT
========================================================= */

if ($action === "update") {

    if ($id <= 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid Project ID']);
        exit;
    }

    $current = $projectObj->getProject($id);
    if (!$current['success']) {
        echo json_encode(['success'=>false,'message'=>'Project not found']);
        exit;
    }

    $old = $current['data'];

    $newImage = uploadSingleFile("projectImages");
    $newMap   = uploadSingleFile("projectMap");

    $finalImage = $newImage !== "" ? $newImage : $old['project_images'];
    $finalMap   = $newMap !== "" ? $newMap : $old['project_map'];

    $data = [
        'project_name'    => $_POST['projectName'],
        'teaser'          => $_POST['teaser'],
        'project_url'     => $_POST['project_url'],
        'project_details' => $_POST['project_details'],
        'status'          => intval($_POST['status']),
        'project_images'  => $finalImage,
        'project_map'     => $finalMap
    ];

    echo json_encode($projectObj->updateProject($id, $data, $old, $newImage !== "", $newMap !== ""));
    exit;
}

/* =========================================================
   DELETE PROJECT
========================================================= */

if ($action === "delete") {

    if ($id <= 0) {
        echo json_encode(['success'=>false,'message'=>'Invalid Project ID']);
        exit;
    }

    echo json_encode($projectObj->deleteProject($id));
    exit;
}

/* =========================================================
   GET ALL PROJECTS
========================================================= */

echo json_encode($projectObj->getAllProjects());
exit;
