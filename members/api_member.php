<?php
header('Content-Type: application/json');
session_start();

require_once("../classes/Member.php");

$db = new mysqli("localhost", "root", "", "rdlpk_db1");
if ($db->connect_error) {
    echo json_encode(["success" => false, "message" => "DB connection failed: " . $db->connect_error]);
    exit;
}

$member = new Member($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

function esc($db, $val) {
    return "'" . $db->real_escape_string($val ?? '') . "'";
}

/**
 * AJAX: Get cities by country_id
 * GET api_member.php?action=get_cities&country_id=1
 */
if ($action === 'get_cities') {
    $country_id = (int)($_GET['country_id'] ?? 0);

    $res = $db->query("SELECT id, city_name FROM cities WHERE country_id = {$country_id} ORDER BY city_name ASC");
    $cities = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $cities[] = $row;
        }
    }
    echo json_encode(["success" => true, "data" => $cities]);
    exit;
}

/**
 * ADD / UPDATE MEMBER
 */
if ($action === 'add' || $action === 'update') {

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    $name          = $_POST['name'] ?? '';
    $username      = $_POST['username'] ?? '';
    $sodowo        = $_POST['sodowo'] ?? '';
    $title         = $_POST['title'] ?? '';
    $cnic          = $_POST['cnic'] ?? '';
    $address       = $_POST['address'] ?? '';
    $city_id       = $_POST['city_id'] ?? '';
    $phone         = $_POST['phone'] ?? '';
    $email         = $_POST['email'] ?? '';
    $country_id    = $_POST['country_id'] ?? '';
    $state         = $_POST['state'] ?? '';
    $nomineename   = $_POST['nomineename'] ?? '';
    $nomineecnic   = $_POST['nomineecnic'] ?? '';
    $rwa           = $_POST['rwa'] ?? '';
    $password      = $_POST['password'] ?? ''; // if empty on update, keep old
    $status        = $_POST['status'] ?? '';
    $fp            = $_POST['fp'] ?? '';
    $mtype         = $_POST['mtype'] ?? '';
    $login_status  = $_POST['login_status'] ?? '';
    $create_date   = $_POST['create_date'] ?? '';
    $dob           = $_POST['dob'] ?? '';
    $business_title = $_POST['business_title'] ?? '';

    // Handle image upload
    $imageName = null;
    $uploadDir = "../assets/img/member_images/";
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    // For update, load existing row
    $existing = null;
    if ($action === 'update' && $id > 0) {
        $existing = $member->getById($id);
        if (!$existing) {
            echo json_encode(["success" => false, "message" => "Member not found"]);
            exit;
        }
    }

    if (!empty($_FILES['image']['name'])) {
        $origName = $_FILES['image']['name'];
        $ext = pathinfo($origName, PATHINFO_EXTENSION);
        $safeName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', pathinfo($origName, PATHINFO_FILENAME));
        $imageName = time() . '_' . $safeName . '.' . $ext;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
            // delete old image on update
            if ($existing && !empty($existing['image'])) {
                $oldPath = $uploadDir . $existing['image'];
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }
        } else {
            echo json_encode(["success" => false, "message" => "Image upload failed"]);
            exit;
        }
    } else {
        // No new image; keep old on update
        if ($existing) {
            $imageName = $existing['image'];
        } else {
            $imageName = '';
        }
    }

    // If update and password empty => keep old
    if ($action === 'update' && $existing) {
        if (trim($password) === '') {
            $password = $existing['password'];
        }
    }

    if ($action === 'add') {

        $sql = "INSERT INTO member (
                    name, username, sodowo, title, cnic, image, address,
                    city_id, phone, email, country_id, state,
                    nomineename, nomineecnic, rwa,
                    password, status, fp, mtype, login_status,
                    create_date, dob, business_title
                ) VALUES (
                    " . esc($db, $name) . ",
                    " . esc($db, $username) . ",
                    " . esc($db, $sodowo) . ",
                    " . esc($db, $title) . ",
                    " . esc($db, $cnic) . ",
                    " . esc($db, $imageName) . ",
                    " . esc($db, $address) . ",
                    " . esc($db, $city_id) . ",
                    " . esc($db, $phone) . ",
                    " . esc($db, $email) . ",
                    " . esc($db, $country_id) . ",
                    " . esc($db, $state) . ",
                    " . esc($db, $nomineename) . ",
                    " . esc($db, $nomineecnic) . ",
                    " . esc($db, $rwa) . ",
                    " . esc($db, $password) . ",
                    " . esc($db, $status) . ",
                    " . esc($db, $fp) . ",
                    " . esc($db, $mtype) . ",
                    " . esc($db, $login_status) . ",
                    " . esc($db, $create_date) . ",
                    " . esc($db, $dob) . ",
                    " . esc($db, $business_title) . "
                )";

        if ($db->query($sql)) {
            echo json_encode(["success" => true, "message" => "Member added successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Add failed: " . $db->error]);
        }
        exit;
    }

    if ($action === 'update') {

        if (!$id) {
            echo json_encode(["success" => false, "message" => "Missing member ID for update"]);
            exit;
        }

        $sql = "UPDATE member SET
                    name          = " . esc($db, $name) . ",
                    username      = " . esc($db, $username) . ",
                    sodowo        = " . esc($db, $sodowo) . ",
                    title         = " . esc($db, $title) . ",
                    cnic          = " . esc($db, $cnic) . ",
                    image         = " . esc($db, $imageName) . ",
                    address       = " . esc($db, $address) . ",
                    city_id       = " . esc($db, $city_id) . ",
                    phone         = " . esc($db, $phone) . ",
                    email         = " . esc($db, $email) . ",
                    country_id    = " . esc($db, $country_id) . ",
                    state         = " . esc($db, $state) . ",
                    nomineename   = " . esc($db, $nomineename) . ",
                    nomineecnic   = " . esc($db, $nomineecnic) . ",
                    rwa           = " . esc($db, $rwa) . ",
                    password      = " . esc($db, $password) . ",
                    status        = " . esc($db, $status) . ",
                    fp            = " . esc($db, $fp) . ",
                    mtype         = " . esc($db, $mtype) . ",
                    login_status  = " . esc($db, $login_status) . ",
                    create_date   = " . esc($db, $create_date) . ",
                    dob           = " . esc($db, $dob) . ",
                    business_title = " . esc($db, $business_title) . "
                WHERE id = {$id} LIMIT 1";

        if ($db->query($sql)) {
            echo json_encode(["success" => true, "message" => "Member updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Update failed: " . $db->error]);
        }
        exit;
    }
}

/**
 * DELETE MEMBER
 */
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if (!$id) {
        echo json_encode(["success" => false, "message" => "Invalid ID"]);
        exit;
    }
    echo json_encode($member->delete($id));
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid action"]);
