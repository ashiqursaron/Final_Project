<?php
// filepath: c:\xampp\htdocs\Practice\Admin DashBoard\dashboard\get_users.php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
// echo $users;

echo json_encode($users);
$conn->close();
?>