<?php
header("Content-Type: application/json");
session_start();

require_once("../classes/Country.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$country = new Country($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == "add") {
    echo json_encode($country->add($_POST));
    exit;
}

if ($action == "update") {
    echo json_encode($country->update($_POST));
    exit;
}

if ($action == "delete") {
    $id = intval($_GET['id']);
    echo json_encode($country->delete($id));
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
