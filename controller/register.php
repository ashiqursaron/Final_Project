<?php
// filepath: c:\xampp\htdocs\project\controller\register.php

header('Content-Type: application/json');

require_once '../model/db_connection.php';

// // Database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "your_database_name";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
//     exit();
// }

// Get JSON data from request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data.']);
    exit();
}

// Prepare data
$firstName = $conn->real_escape_string($data['firstName']);
$lastName = $conn->real_escape_string($data['lastName']);
$username = $conn->real_escape_string($data['username']);
$email = $conn->real_escape_string($data['email']);
$phone = $conn->real_escape_string($data['phone']);
$dob = $conn->real_escape_string($data['dob']);
$password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash password
$profession = $conn->real_escape_string($data['profession']);
$gender = $conn->real_escape_string($data['gender']);
error_log("Gender received: " . $gender); // Debugging log
$userType = $conn->real_escape_string($data['userType']);
$profilePicture = null; // Placeholder for profile picture
$registrationTime = date('Y-m-d H:i:s');

// Insert data into database
$sql = "INSERT INTO users (first_name, last_name, username, email, phone, dob, password, profession, gender, user_type, profile_picture, registration_time)
        VALUES ('$firstName', '$lastName', '$username', '$email', '$phone', '$dob', '$password', '$profession', '$gender', '$userType', '$profilePicture', '$registrationTime')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'User registered successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>