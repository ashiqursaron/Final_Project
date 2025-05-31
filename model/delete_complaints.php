<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "weather_app");
$data = json_decode(file_get_contents("php://input"), true);
$days = intval($data['days']);
if ($days < 1) {
    echo json_encode(["error" => "Invalid number of days"]);
    exit;
}
$stmt = $conn->prepare("DELETE FROM complaints WHERE posted_date >= DATE_SUB(NOW(), INTERVAL ? DAY)");
$stmt->bind_param("i", $days);
$stmt->execute();
echo json_encode(["message" => "Deleted complaints from last $days days."]);
$conn->close();
?>