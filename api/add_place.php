<?php
require_once 'config.php';

header('Content-Type: application/json');

\ = json_decode(file_get_contents('php://input'), true);

if (!isset(\['id'], \['name'], \['category_id'], \['distanceKm'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    \ = \->prepare('INSERT INTO places (id, name, category_id, distanceKm, summary, description, imageUrl, openingHours, entryFee, contact, visitDurationMin, lat, lng, bestTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    
    \->execute([
        \['id'], 
        \['name'], 
        \['category_id'], 
        \['distanceKm'],
        \['summary'] ?? '',
        \['description'] ?? '',
        \['imageUrl'] ?? '',
        \['openingHours'] ?? '',
        \['entryFee'] ?? '',
        \['contact'] ?? '',
        \['visitDurationMin'] ?? 60,
        \['lat'] ?? 0.0,
        \['lng'] ?? 0.0,
        \['bestTime'] ?? ''
    ]);
    
    echo json_encode(['success' => true]);
} catch (PDOException \) {
    echo json_encode(['success' => false, 'error' => \->getMessage()]);
}
?>
