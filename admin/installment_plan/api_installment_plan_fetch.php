<?php
header('Content-Type: application/json');

// DB Connection
$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){
    echo json_encode(["success"=>false,"message"=>"DB connection failed"]);
    exit;
}

// Receive only size_cat_id
$size = $_GET['size_cat_id'] ?? '';

if($size == ""){
    echo json_encode(["success"=>false,"message"=>"size_cat_id required"]);
    exit;
}

$sql = "SELECT id, description, tno 
        FROM installment_plan 
        WHERE size_cat_id=? 
        ORDER BY id DESC";

$stmt = $db->prepare($sql);
$stmt->bind_param("i", $size);
$stmt->execute();
$res = $stmt->get_result();

$data=[];
while($r = $res->fetch_assoc()){
    $data[] = $r;
}

echo json_encode(["success"=>true,"data"=>$data]);
exit;
