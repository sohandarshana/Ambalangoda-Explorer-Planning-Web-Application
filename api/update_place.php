<?php
require_once "config.php";
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["id"])) {
    echo json_encode(["success" => false, "error" => "No ID provided"]);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE places SET
        name = ?,
        category_id = ?,
        distanceKm = ?,
        summary = ?,
        description = ?,
        imageUrl = ?,
        openingHours = ?,
        entryFee = ?,
        contact = ?,
        visitDurationMin = ?,
        lat = ?,
        lng = ?,
        bestTime = ?
        WHERE id = ?");

    $stmt->execute([
        $data["name"],
        $data["category_id"],
        $data["distanceKm"],
        $data["summary"] ?? "",
        $data["description"] ?? "",
        $data["imageUrl"] ?? "",
        $data["openingHours"] ?? "",
        $data["entryFee"] ?? "",
        $data["contact"] ?? "",
        $data["visitDurationMin"] ?? 60,
        $data["lat"] ?? 0,
        $data["lng"] ?? 0,
        $data["bestTime"] ?? "",
        $data["id"]
    ]);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>

