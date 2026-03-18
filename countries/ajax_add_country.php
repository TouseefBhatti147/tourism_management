<?php
// Include the database connection
    require("includes/db_connection.php");

// Set header to return JSON
header('Content-Type: application/json');

// We remove "$pdo = '';" so the $pdo from db_connection.php is used

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Check if $pdo was created successfully in db_connectio<?php
// Include the database connection
    require("../includes/db_connection.php"); // Updated path

// Set header to return JSON
header('Content-Type: application/json');

// We remove "$pdo = '';" so the $pdo from db_connection.php is used

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Check if $pdo was created successfully in db_connection.php
if (!$pdo) {
    $response['message'] = 'Database connection failed. Please check configuration.';
    echo json_encode($response);
    exit;
}

// Basic validation
if (empty($_POST['countryName'])) {
    $response['message'] = 'Country Name is required.';
    echo json_encode($response);
    exit;
}

$countryName = trim($_POST['countryName']);

// --- Database Insertion ---
try {
    // Using your new table and column names
    $sql = "INSERT INTO tbl_country (country) VALUES (?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$countryName]);

    // If we get here, the insert was successful
    $response['success'] = true;
    $response['message'] = 'Country added successfully!';

} catch (PDOException $e) {
    // Check for duplicate entry
    if ($e->errorInfo[1] == 1062) {
        $response['message'] = 'This country name already exists.';
    } else {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
}

// Send the final JSON response
echo json_encode($response);
exit;
?>
n.php
if (!$pdo) {
    $response['message'] = 'Database connection failed. Please check configuration.';
    echo json_encode($response);
    exit;
}

// Basic validation
if (empty($_POST['countryName'])) {
    $response['message'] = 'Country Name is required.';
    echo json_encode($response);
    exit;
}

$countryName = trim($_POST['countryName']);

// --- Database Insertion ---
try {
    // Using your new table and column names
    $sql = "INSERT INTO tbl_country (country) VALUES (?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$countryName]);

    // If we get here, the insert was successful
    $response['success'] = true;
    $response['message'] = 'Country added successfully!';

} catch (PDOException $e) {
    // Check for duplicate entry
    if ($e->errorInfo[1] == 1062) {
        $response['message'] = 'This country name already exists.';
    } else {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
}

// Send the final JSON response
echo json_encode($response);
exit;
?>

