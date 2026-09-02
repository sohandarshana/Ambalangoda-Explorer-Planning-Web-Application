<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "error" => "POST only"]);
    exit;
}

if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    echo json_encode(["success" => false, "error" => "No image uploaded"]);
    exit;
}

$allowed = ["image/jpeg", "image/png", "image/webp", "image/gif"];
$mime    = mime_content_type($_FILES["image"]["tmp_name"]);

if (!in_array($mime, $allowed)) {
    echo json_encode(["success" => false, "error" => "Only JPG, PNG, WEBP images allowed"]);
    exit;
}

$ext      = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
$filename = uniqid("place_", true) . "." . $ext;
$dest     = dirname(__DIR__) . "/uploads/" . $filename;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $dest)) {
    echo json_encode(["success" => true, "filename" => "uploads/" . $filename]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to save file"]);
}
?>
