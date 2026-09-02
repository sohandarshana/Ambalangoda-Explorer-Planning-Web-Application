<?php
// api/get_places.php
header('Content-Type: application/json');
require_once 'config.php';

try {
    // Get all places
    $stmt = $pdo->query('SELECT p.*, c.label as category_label, c.pill, c.chip 
                         FROM places p 
                         JOIN categories c ON p.category_id = c.id');
    $places = $stmt->fetchAll();
    
    // Get all highlights
    $stmt = $pdo->query('SELECT place_id, highlight FROM place_highlights');
    $allHighlights = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_COLUMN);

    foreach ($places as &$place) {
        $place['highlights'] = isset($allHighlights[$place['id']]) ? $allHighlights[$place['id']] : [];
    }

    echo json_encode($places);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
