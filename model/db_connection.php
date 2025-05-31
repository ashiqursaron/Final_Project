<?php
// filepath: c:\xampp\htdocs\project\controller\db_connection.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}
?>