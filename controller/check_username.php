<?php
// filepath: c:\xampp\htdocs\project\controller\check_username.php

header('Content-Type: application/json');

// Include database connection
require_once '../model/db_connection.php';

// // Database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "your_database_name";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     echo json_encode(['available' => false, 'message' => 'Database connection failed.']);
//     exit();
// }

// Get JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['username'])) {
    echo json_encode(['available' => false, 'message' => 'Invalid data.']);
    exit();
}

$username = $conn->real_escape_string($data['username']);

// Check username availability
$sql = "SELECT id FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(['available' => false, 'message' => 'Username is already taken.']);
} else {
    echo json_encode(['available' => true, 'message' => 'Username is available.']);
}

$conn->close();
?>