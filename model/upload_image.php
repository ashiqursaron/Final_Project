
<?php
header('Content-Type: application/json');
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}
if (isset($_FILES['image'])) {
    $fileName = uniqid() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $fileName;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        echo json_encode(["success" => true, "path" => $targetFile]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to upload image"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded"]);
}
?>
