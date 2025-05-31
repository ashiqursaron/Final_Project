<?php
// filepath: c:\xampp\htdocs\Practice\Admin DashBoard\dashboard\delete_user.php
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

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $data['id']);

$stmt->execute();
echo json_encode(["message" => "User deleted successfully"]);
$stmt->close();
$conn->close();
?>