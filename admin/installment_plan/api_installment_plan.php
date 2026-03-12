<?php
header('Content-Type: application/json');
session_start();

// DIRECT DB connection (No db_connect.php required)
$db = new mysqli("localhost","root","","rdlpk_db1");
if($db->connect_error){
    echo json_encode(["success"=>false,"message"=>"Database connection failed"]);
    exit;
}

require_once("../classes/InstallmentPlan.php");
$planObj = new InstallmentPlan($db);

$action = $_POST['action'] ?? $_GET['action'] ?? "";

/*==================  ADD NEW  ==================*/
if($action=="add"){

    $id          = 0;
    $project_id  = $_POST['project_id'] ?? 0;
    $size_cat_id = $_POST['size_cat_id'] ?? 0;
    $p_type      = $_POST['p_type'] ?? 0;
    $description = $_POST['description'] ?? "";
    $tno         = $_POST['tno'] ?? 0;
    $tamount     = $_POST['tamount'] ?? 0;

    $set = " INSERT INTO installment_plan (project_id,size_cat_id,p_type,description,tno,tamount) 
             VALUES ('$project_id','$size_cat_id','$p_type','$description','$tno','$tamount')";

    if($db->query($set)){
        $id = $db->insert_id;

        // Insert installment values 1–62
        for($i=1; $i<=62; $i++){
            $lab  = $_POST["lab$i"] ?? '';
            $amt  = $_POST["amount$i"] ?? '';
            if($lab!='' || $amt!=''){
                $db->query("UPDATE installment_plan SET lab$i='$lab', `$i`='$amt' WHERE id=$id");
            }
        }

        echo json_encode(["success"=>true,"message"=>"Installment Plan Added Successfully"]);
    }
    else{ echo json_encode(["success"=>false,"message"=>"Insert failed"]); }
    exit;
}

/*==================  UPDATE  ==================*/
if($action=="update"){

    $id = $_POST['id'] ?? 0;
    if(!$id){ echo json_encode(["success"=>false,"message"=>"Invalid ID"]); exit; }

    $db->query("UPDATE installment_plan SET 
        project_id='$_POST[project_id]',
        size_cat_id='$_POST[size_cat_id]',
        p_type='$_POST[p_type]',
        description='$_POST[description]',
        tno='$_POST[tno]',
        tamount='$_POST[tamount]'
        WHERE id=$id");

    for($i=1;$i<=62;$i++){
        $lab = $_POST["lab$i"] ?? '';
        $amt = $_POST["amount$i"] ?? '';
        $db->query("UPDATE installment_plan SET lab$i='$lab', `$i`='$amt' WHERE id=$id");
    }

    echo json_encode(["success"=>true,"message"=>"Installment Plan Updated"]);
    exit;
}

/*==================  FETCH FOR MEMBER-PLOT  ==================*/
if(isset($_GET['size_cat_id'])){

    $size = $_GET['size_cat_id'];
    $ptype = $_GET['p_type'] ?? "";

    $q = $db->query("SELECT id,description,tno FROM installment_plan 
                     WHERE size_cat_id='$size' ORDER BY id DESC");

    $data=[];
    while($r=$q->fetch_assoc()) $data[]=$r;

    echo json_encode(["success"=>true,"data"=>$data]);
    exit;
}

echo json_encode(["success"=>false,"message"=>"Invalid action request"]);
?>
