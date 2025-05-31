<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "weather_app");
$res = $conn->query("SELECT complaints.id, users.first_name AS name, complaints.type, complaints.message, complaints.posted_date 
                     FROM complaints 
                     JOIN users ON complaints.user_id = users.id 
                     ORDER BY complaints.posted_date DESC");
$rows = [];
while ($row = $res->fetch_assoc()) $rows[] = $row;
echo json_encode($rows);
$conn->close();
?>