<?php
header("Content-Type: application/json");
session_start();

require_once("../classes/News.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
$news = new News($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == "add") {
    echo json_encode($news->add($_POST));
    exit;
}

if ($action == "update") {
    echo json_encode($news->update($_POST));
    exit;
}

if ($action == "delete") {
    $id = intval($_GET['id']);
    echo json_encode($news->delete($id));
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
