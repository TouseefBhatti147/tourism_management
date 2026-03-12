<?php
header("Content-Type: application/json");
session_start();

require_once("../classes/SaleCenter.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$sc = new SaleCenter($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

$uploadDir = "../assets/img/sales_center_images/";
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

function uploadImg() {
    global $uploadDir;

    if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0)
        return null;

    $file = $_FILES['image']['name'];
    $tmp  = $_FILES['image']['tmp_name'];
    $ext  = pathinfo($file, PATHINFO_EXTENSION);

    $newName = time() . "_" . rand(1000,9999) . "." . $ext;

    move_uploaded_file($tmp, $uploadDir . $newName);

    return $newName;
}

if ($action === "add") {
    $img = uploadImg();
    echo json_encode($sc->add($_POST, $img));
    exit;
}

if ($action === "update") {
    $img = uploadImg();
    echo json_encode($sc->update($_POST, $img));
    exit;
}

if ($action === "delete") {
    $id = intval($_GET['id']);
    echo json_encode($sc->delete($id));
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
