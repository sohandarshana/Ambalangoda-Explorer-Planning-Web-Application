<?php
require_once 'config.php';
header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        "loggedIn" => true, 
        "user_id" => $_SESSION['user_id'], 
        "role" => $_SESSION['role'],
        "name" => $_SESSION['name']
    ]);
} else {
    echo json_encode(["loggedIn" => false]);
}
?>
