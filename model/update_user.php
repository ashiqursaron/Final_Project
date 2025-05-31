<?php
header('Content-Type: application/json');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data['id']) || !isset($data['first_name']) || !isset($data['last_name'])) {
    die(json_encode(["error" => "Missing required fields"]));
}

// Hash the password if it is provided
if (isset($data['password']) && !empty($data['password'])) {
    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
}

// Update user in the database
$sql = "UPDATE users SET 
            profile_picture = ?, 
            first_name = ?, 
            last_name = ?, 
            dob = ?, 
            gender = ?, 
            email = ?, 
            phone = ?, 
            profession = ?, 
            username = ?, 
            password = ?, 
            user_type = ? 
        WHERE id = ?";

// $sql = "UPDATE users SET 
//             profile_picture = NULL, 
//             first_name = 'Sefuda', 
//             last_name = ?, 
//             dob = ?, 
//             gender = ?, 
//             email = ?, 
//             phone = ?, 
//             profession = ?, 
//             username = ?, 
//             password = ?, 
//             user_type = ? 
//         WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssssssssssi",
    $data['profile_picture'],
    $data['first_name'],
    $data['last_name'],
    $data['dob'],
    $data['gender'],
    $data['email'],
    $data['phone'],
    $data['profession'],
    $data['username'],
    $data['password'],
    $data['user_type'],
    $data['id']
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update user"]);
}

$stmt->close();
$conn->close();
?>