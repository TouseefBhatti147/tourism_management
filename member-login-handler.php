<?php
session_start();
require_once "./admin/includes/db_connection.php";  

// Validate POST
if (!isset($_POST['email'], $_POST['password'])) {
    header("Location: login.php?error=missing");
    exit;
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

try {
    $pdo = Database::getConnection();

    // Fetch member record
    $stmt = $pdo->prepare("SELECT * FROM member WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($member) {

        // Validate password (plain text OR hashed)
        if ($password === $member['password'] || password_verify($password, $member['password'])) {

            // SET MEMBER SESSION VARIABLES
            $_SESSION["member_loggedin"] = true;
            $_SESSION["member_id"] = $member["id"];              // REQUIRED
            $_SESSION["member_name"] = $member["member_name"];   // OPTIONAL (for header)
            $_SESSION["member_email"] = $member["email"];  
            $_SESSION["member_name"] = $member["name"];
            // Redirect to client dashboard
            header("Location: /real_estate_esystem/client-dashboard.php");
            exit;
        }
    }

    // Login failed
    header("Location: login.php?error=invalid");
    exit;

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
