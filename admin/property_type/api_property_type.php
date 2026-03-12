<?php
header("Content-Type: application/json");
session_start();
require_once("../classes/PropertyType.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$obj = new PropertyType($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    echo json_encode($obj->add($_POST));
    exit;
}

if ($action === 'update') {
    echo json_encode($obj->update($_POST));
    exit;
}

if ($action === 'delete') {
    $id = intval($_GET['id']);
    echo json_encode($obj->delete($id));
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
