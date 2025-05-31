<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "weather_app");
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['user_id'], $data['type'], $data['message'])) {
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}
$stmt = $conn->prepare("INSERT INTO complaints (user_id, type, message) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $data['user_id'], $data['type'], $data['message']);
if ($stmt->execute()) {
    echo json_encode(["message" => "Complaint added"]);
} else {
    echo json_encode(["error" => "Failed to add complaint"]);
}
$conn->close();
?>