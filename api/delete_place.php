<?php
require_once 'config.php';

header('Content-Type: application/json');

\ = json_decode(file_get_contents('php://input'), true);

if (!isset(\['id'])) {
    echo json_encode(['success' => false, 'error' => 'No ID provided']);
    exit;
}

\ = \['id'];

try {
    \ = \->prepare('DELETE FROM places WHERE id = ?');
    \->execute([\]);
    echo json_encode(['success' => true]);
} catch (PDOException \) {
    echo json_encode(['success' => false, 'error' => \->getMessage()]);
}
?>
