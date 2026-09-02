<?php
require_once 'config.php';

if (!isset(<?php
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['name'], $data['category_id'], $data['distanceKm'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO places (id, name, category_id, distanceKm, summary, description, imageUrl, openingHours, entryFee, contact, visitDurationMin, lat, lng, bestTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    $stmt->execute([
        $data['id'],
        $data['name'],
        $data['category_id'],
        $data['distanceKm'],
        $data['summary'] ?? '',
        $data['description'] ?? '',
        $data['imageUrl'] ?? '',
        $data['openingHours'] ?? '',
        $data['entryFee'] ?? '',
        $data['contact'] ?? '',
        $data['visitDurationMin'] ?? 60,
        $data['lat'] ?? 0.0,
        $data['lng'] ?? 0.0,
        $data['bestTime'] ?? ''
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

SESSION['role']) || <?php
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['name'], $data['category_id'], $data['distanceKm'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO places (id, name, category_id, distanceKm, summary, description, imageUrl, openingHours, entryFee, contact, visitDurationMin, lat, lng, bestTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    $stmt->execute([
        $data['id'],
        $data['name'],
        $data['category_id'],
        $data['distanceKm'],
        $data['summary'] ?? '',
        $data['description'] ?? '',
        $data['imageUrl'] ?? '',
        $data['openingHours'] ?? '',
        $data['entryFee'] ?? '',
        $data['contact'] ?? '',
        $data['visitDurationMin'] ?? 60,
        $data['lat'] ?? 0.0,
        $data['lng'] ?? 0.0,
        $data['bestTime'] ?? ''
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

SESSION['role'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Unauthorized. Admin access required."]);
    exit;
}
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'], $data['name'], $data['category_id'], $data['distanceKm'])) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO places (id, name, category_id, distanceKm, summary, description, imageUrl, openingHours, entryFee, contact, visitDurationMin, lat, lng, bestTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    $stmt->execute([
        $data['id'],
        $data['name'],
        $data['category_id'],
        $data['distanceKm'],
        $data['summary'] ?? '',
        $data['description'] ?? '',
        $data['imageUrl'] ?? '',
        $data['openingHours'] ?? '',
        $data['entryFee'] ?? '',
        $data['contact'] ?? '',
        $data['visitDurationMin'] ?? 60,
        $data['lat'] ?? 0.0,
        $data['lng'] ?? 0.0,
        $data['bestTime'] ?? ''
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>


