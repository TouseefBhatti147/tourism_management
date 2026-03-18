<?php
session_start();

require_once '../includes/db_connection.php';
require_once '../classes/User.php';

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    die("DB connection failed");
}

$userObj = new User($pdo);
$action = $_POST['action'] ?? '';

// Correct Upload Directory
$uploadDir = realpath(__DIR__ . '/../assets/img/user_images');
if (!$uploadDir) {
    $uploadDir = __DIR__ . '/../assets/img/user_images';
}
$uploadDir .= '/';

function handleUserImage($uploadDir)
{
    $filename = $_POST['old_pic'] ?? '';

    if (!empty($_FILES['pic']['name'])) {
        $ext = strtolower(pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION));
        $safeName = 'user_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;

        $destination = $uploadDir . $safeName;

        if (!move_uploaded_file($_FILES['pic']['tmp_name'], $destination)) {
            die("Image upload failed.");
        }

        $filename = $safeName;
    }

    return $filename;
}

switch ($action) {

    case 'add':
        $pic = handleUserImage($uploadDir);

        $data = [
            'firstname'  => $_POST['firstname'] ?? '',
            'middelname' => $_POST['middelname'] ?? '',
            'lastname'   => $_POST['lastname'] ?? '',
            'sodowo'     => $_POST['sodowo'] ?? '',
            'email'      => $_POST['email'] ?? '',
            'mobile'     => $_POST['mobile'] ?? '',
            'username'   => $_POST['username'] ?? '',
            'password'   => $_POST['password'] ?? '',
            'status'     => $_POST['status'] ?? '1',
            'pic'        => $pic,
            'cnic'       => $_POST['cnic'] ?? '',
            'address'    => $_POST['address'] ?? '',
            'city_id'    => $_POST['city_id'] ?? '',
            'country_id' => $_POST['country_id'] ?? '',
        ];

        if ($userObj->create($data)) {
            header("Location: user_list.php?msg=User+added");
        } else {
            header("Location: form_user.php?error=Add+failed");
        }
        exit;

    case 'update':
        $pic = handleUserImage($uploadDir);

        $data = [
            'id'         => $_POST['id'] ?? 0,
            'firstname'  => $_POST['firstname'] ?? '',
            'middelname' => $_POST['middelname'] ?? '',
            'lastname'   => $_POST['lastname'] ?? '',
            'sodowo'     => $_POST['sodowo'] ?? '',
            'email'      => $_POST['email'] ?? '',
            'mobile'     => $_POST['mobile'] ?? '',
            'username'   => $_POST['username'] ?? '',
            'password'   => $_POST['password'] ?? '',
            'status'     => $_POST['status'] ?? '1',
            'pic'        => $pic,
            'cnic'       => $_POST['cnic'] ?? '',
            'address'    => $_POST['address'] ?? '',
            'city_id'    => $_POST['city_id'] ?? '',
            'country_id' => $_POST['country_id'] ?? '',
        ];

        if ($userObj->update($data)) {
            header("Location: user_list.php?msg=User+updated");
        } else {
            header("Location: form_user.php?id=" . (int)$data['id'] . "&error=Update+failed");
        }
        exit;

    case 'delete':
        $id = $_POST['id'] ?? 0;
        $userObj->delete($id);
        header("Location: user_list.php?msg=User+deleted");
        exit;

    default:
        header("Location: user_list.php?error=Invalid+action");
        exit;
}
