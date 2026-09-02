<?php
// api/get_categories.php
header('Content-Type: application/json');
require_once 'config.php';

try {
    $stmt = $pdo->query('SELECT * FROM categories');
    $categories = $stmt->fetchAll();
    echo json_encode($categories);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
