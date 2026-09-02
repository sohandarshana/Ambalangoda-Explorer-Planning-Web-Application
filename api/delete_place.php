<?php
require_once 'config.php';

if (!isset(<?php
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'No ID provided']);
    exit;
}

$id = $data['id'];

try {
    $stmt = $pdo->prepare('DELETE FROM places WHERE id = ?');
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

SESSION['role']) || <?php
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'No ID provided']);
    exit;
}

$id = $data['id'];

try {
    $stmt = $pdo->prepare('DELETE FROM places WHERE id = ?');
    $stmt->execute([$id]);
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

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'No ID provided']);
    exit;
}

$id = $data['id'];

try {
    $stmt = $pdo->prepare('DELETE FROM places WHERE id = ?');
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>


