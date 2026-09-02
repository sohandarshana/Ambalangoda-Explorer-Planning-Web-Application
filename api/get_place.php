<?php
// api/get_place.php
header('Content-Type: application/json');
require_once 'config.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No ID provided"]);
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare('SELECT p.*, c.label as category_label, c.pill, c.chip, c.blurb as category_blurb 
                           FROM places p 
                           JOIN categories c ON p.category_id = c.id 
                           WHERE p.id = ?');
    $stmt->execute([$id]);
    $place = $stmt->fetch();

    if ($place) {
        $stmt = $pdo->prepare('SELECT highlight FROM place_highlights WHERE place_id = ?');
        $stmt->execute([$id]);
        $place['highlights'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        echo json_encode($place);
    } else {
        echo json_encode(["error" => "Place not found"]);
    }
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
