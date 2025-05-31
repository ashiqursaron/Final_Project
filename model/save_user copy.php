<?php
// filepath: w:\Saron AIUB Related Documents\8th Semester (17 Credits)\Web Technologies\Web_Technologies_Final_Term_Project\Saron\Admin_Dashboard_For_Weather_App\responsive-admin-dashboard\php\save_user.php

header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get data from AJAX request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && $data['id'] !== "") {
    // Update user
    $sql = "UPDATE users SET 
            user_type = '{$data['user_type']}', 
            picture = '{$data['picture']}', 
            full_name = '{$data['full_name']}', 
            age = '{$data['age']}', 
            gender = '{$data['gender']}', 
            email = '{$data['email']}', 
            phone_number = '{$data['phone_number']}', 
            profession = '{$data['profession']}', 
            username = '{$data['username']}', 
            password = '{$data['password']}', 
            start_date = '{$data['start_date']}' 
            WHERE id = {$data['id']}";
} else {
    // Insert new user
    $sql = "INSERT INTO users (user_type, picture, full_name, age, gender, email, phone_number, profession, username, password, start_date) 
            VALUES (
                '{$data['user_type']}', 
                '{$data['picture']}', 
                '{$data['full_name']}', 
                '{$data['age']}', 
                '{$data['gender']}', 
                '{$data['email']}', 
                '{$data['phone_number']}', 
                '{$data['profession']}', 
                '{$data['username']}', 
                '{$data['password']}', 
                '{$data['start_date']}'
            )";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>