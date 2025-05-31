
<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['first_name']) || !isset($data['last_name']) || !isset($data['username']) || !isset($data['email']) || !isset($data['phone']) || !isset($data['dob']) || !isset($data['password']) || !isset($data['profession']) || !isset($data['gender']) || !isset($data['user_type']) || !isset($data['registration_time'])) {
    die(json_encode(["error" => "Missing required fields"]));
}

// Hash the password before storing
$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

// Ensure profile_picture is never empty
if (empty($data['profile_picture'])) {
    $data['profile_picture'] = "user.png";
}

$sql = "INSERT INTO users (first_name, last_name, username, email, phone, dob, password, profession, gender, user_type, profile_picture, registration_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssss",
    $data['first_name'],
    $data['last_name'],
    $data['username'],
    $data['email'],
    $data['phone'],
    $data['dob'],
    $data['password'],
    $data['profession'],
    $data['gender'],
    $data['user_type'],
    $data['profile_picture'],
    $data['registration_time']
);

if ($stmt->execute()) {
    echo json_encode(["message" => "User added successfully"]);
} else {
    echo json_encode(["error" => "Failed to add user", "sql_error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>