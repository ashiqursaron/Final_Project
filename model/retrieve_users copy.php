<?php
// filepath: w:\Saron AIUB Related Documents\8th Semester (17 Credits)\Web Technologies\Web_Technologies_Final_Term_Project\Saron\Admin_Dashboard_For_Weather_App\responsive-admin-dashboard\php\retrieve_users.php

header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch user data
$sql = "SELECT * FROM users"; // Replace 'users' with your table name
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>