<?php
header("Content-Type: application/json");

$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){
    echo json_encode(["success"=>false]);
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT id, plot_size, size_cat_id, category_id FROM plots WHERE id=$id LIMIT 1";
$res = $db->query($sql)->fetch_assoc();

echo json_encode(["success"=>true,"data"=>$res]);
