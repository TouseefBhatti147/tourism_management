<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

require_once '../includes/db_connection.php';
require_once '../classes/User.php';

$response = ["success" => false, "message" => "Invalid login."];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode($response);
    exit;
}

$username = trim($_POST['username'] ?? "");
$password = trim($_POST['password'] ?? "");

if ($username === "" || $password === "") {
    $response["message"] = "Please enter username and password.";
    echo json_encode($response);
    exit;
}

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    $response["message"] = "Database connection failed.";
    echo json_encode($response);
    exit;
}

$userObj = new User($pdo);

$user = $userObj->login($username, $password);

if ($user) {
    $_SESSION["loggedin"] = true;
    $_SESSION["user_id"]  = $user["id"];
    $_SESSION["username"] = $user["username"];

    $response["success"] = true;
    $response["message"] = "Login successful!";
} else {
    $response["message"] = "Invalid username or password.";
}

echo json_encode($response);
exit;
