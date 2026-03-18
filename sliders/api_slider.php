<?php
header("Content-Type: application/json");
session_start();

require_once("../classes/Slider.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die(json_encode(["success" => false, "message" => "DB Error: " . $db->connect_error]));
}

$slider = new Slider($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

$uploadDir = "../assets/img/slider_images/";
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

function uploadImage() {
    global $uploadDir;

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) return null;

    $file = $_FILES['image']['name'];
    $tmp  = $_FILES['image']['tmp_name'];

    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $newName = time() . "_" . rand(100, 999) . "." . $ext;

    if (move_uploaded_file($tmp, $uploadDir . $newName)) {
        return $newName;
    }

    return null;
}

if ($action === "add") {
    $image = uploadImage();
    echo json_encode($slider->add($_POST, $image));
    exit;
}

if ($action === "update") {
    $image = uploadImage();
    echo json_encode($slider->update($_POST, $image));
    exit;
}

if ($action === "delete") {
    $id = intval($_GET['id']);
    echo json_encode($slider->delete($id));
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
