<?php
session_start();
require_once("../classes/MemberPlot.php");

// DB Connect
$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    die("DB Connection Failed");
}

$mpObj = new MemberPlot($db);
$action = $_POST['action'] ?? '';

function esc($db, $v){
    return $db->real_escape_string(trim($v ?? ''));
}

/* ============================================================
   DELETE
============================================================ */
if ($action == "delete") {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        $mpObj->delete($id);
    }
    header("Location: memberplot_list.php");
    exit;
}

/* ============================================================
   ADD / UPDATE
============================================================ */

if ($action == "add" || $action == "update") {

    $id         = intval($_POST['id'] ?? 0);
    $plot_id    = intval($_POST['plot_id'] ?? 0);
    $member_id  = intval($_POST['member_id'] ?? 0);
    $createDate = esc($db, $_POST['create_date'] ?? '');
    $noi        = intval($_POST['noi'] ?? 0);
    $insplan    = intval($_POST['insplan'] ?? 0);
    $uid        = intval($_POST['uid'] ?? 0);

    if ($plot_id <= 0) die("Select Plot");
    if ($member_id <= 0) die("Select Member");
    if ($insplan <= 0) die("Select Installment Plan");

    /* Fetch Plot Details */
    $sqlPlot = "
        SELECT 
            p.*, 
            proj.code AS project_code,
            sc.code AS size_code
        FROM plots p
        LEFT JOIN projects proj ON proj.id = p.project_id
        LEFT JOIN size_cat sc ON sc.id = p.size_cat_id
        WHERE p.id = $plot_id LIMIT 1
    ";

    $plotRes = $db->query($sqlPlot);
    if (!$plotRes) die("Plot Query Error: ".$db->error);

    $plot = $plotRes->fetch_assoc();
    if (!$plot) die("Plot Not Found");

    /* Plot Already Allotted? */
    if ($plot['status'] == "Allotted") {
        die("This plot is already allotted.");
    }

    /* Auto Membership Number */
    $generatedPlotNo = $plot['project_code'] . "-" . $plot['plot_detail_address'] . "-" . $plot['size_code'];

    /* ============================================================
       ADD RECORD
    ============================================================= */
    if ($action == "add") {

        $sql = "INSERT INTO memberplot
            (plot_id, member_id, create_date, noi, insplan, status, plotno, msno, uid)
            VALUES (?,?,?,?,?,'Allotted',?,?,?)";

        $stmt = $db->prepare($sql);

        $stmt->bind_param(
            "iisiissi",
            $plot_id,
            $member_id,
            $createDate,
            $noi,
            $insplan,
            $generatedPlotNo,
            $generatedPlotNo,
            $uid
        );

        if (!$stmt->execute()) {
            die("DB Error: ".$stmt->error);
        }

        $insert_id = $stmt->insert_id;

        /* Update Plot Status */
        $db->query("UPDATE plots SET status='Allotted' WHERE id=$plot_id");

        /* Generate Installment Schedule */
        $planRes = $db->query("SELECT * FROM installment_plan WHERE id=$insplan");
        $plan = $planRes->fetch_assoc();

        if ($plan) {
            $due_date = date('Y-m-d', strtotime($createDate));
            $total = intval($plan['tno']);

            for ($i = 1; $i <= $total; $i++) {

                $label = $plan['lab'.$i] ?? '';
                $amount = $plan[(string)$i] ?? '';

                $sqlPay = "
                    INSERT INTO installpayment
                    (plot_id, mem_id, lab, dueamount, due_date_temp)
                    VALUES (?,?,?,?,?)
                ";

                $stmt2 = $db->prepare($sqlPay);
                $stmt2->bind_param("iisss", $plot_id, $member_id, $label, $amount, $due_date);
                $stmt2->execute();

                $due_date = date('Y-m-d', strtotime("$due_date +$noi months"));
            }
        }

        /* Final Redirect */
        header("Location: memberplot_list.php");
        exit;
    }

    /* ============================================================
       UPDATE RECORD
    ============================================================= */
    if ($action == "update") {

        $data = [
            "id"        => $id,
            "plot_id"   => $plot_id,
            "member_id" => $member_id,
            "create_date" => $createDate,
            "noi"       => $noi,
            "insplan"   => $insplan,
            "status"    => "Allotted",
            "plotno"    => $generatedPlotNo,
            "msno"      => $generatedPlotNo
        ];

        $mpObj->update($data);

        header("Location: memberplot_list.php");
        exit;
    }
}

die("Invalid Action");
?>
