<?php
session_start();
header("Content-Type: application/json");

$db = new mysqli("localhost","root","","rdlpk_db1");
if ($db->connect_error){
    echo json_encode(["success"=>false,"message"=>"DB connection failed"]);
    exit;
}

require_once("../classes/Transfer.php");
$tr = new Transfer($db);

$action = $_POST['action'] ?? "";

/* DELETE */
if ($action == "delete") {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        $tr->delete($id);
        echo json_encode(["success"=>true,"message"=>"Deleted"]);
    }
    exit;
}

/* ADD TRANSFER */
if ($action == "add") {

    $plot_id    = intval($_POST['plot_id']);
    $from_id    = intval($_POST['transferfrom_id']);
    $to_id      = intval($_POST['transferto_id']);
    $uid        = intval($_POST['uid']);
    $date       = $_POST['create_date'];

    if ($plot_id <= 0 || $from_id <= 0 || $to_id <= 0) {
        echo json_encode(["success"=>false,"message"=>"Required fields missing"]);
        exit;
    }

    /* 1 — Add into transferplot table */
    $data = [
        "plot_id" => $plot_id,
        "transferfrom_id" => $from_id,
        "transferto_id" => $to_id,
        "uid" => $uid,
        "status" => "Transferred",
        "create_date" => $date
    ];

    $tr->add($data);

    /* 2 — Update owner inside memberplot */
    $db->query("UPDATE memberplot SET member_id=$to_id WHERE plot_id=$plot_id");

    echo json_encode(["success"=>true,"message"=>"Plot Transferred Successfully"]);
    exit;
}

echo json_encode(["success"=>false,"message"=>"Invalid Action"]);
exit;
