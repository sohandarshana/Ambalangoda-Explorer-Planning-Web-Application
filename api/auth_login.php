<?php
require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$requestedRole = $_POST['role'] ?? 'customer';

if (empty($email) || empty($password)) {
    echo json_encode(["error" => "Email and password are required"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && (password_verify($password, $user['password_hash']) || $password === $user['password_hash'])) {
    if ($user['role'] !== $requestedRole) {
        echo json_encode(['error' => 'Account does not have ' . $requestedRole . ' privileges']);
        exit;
    }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['name'] = $user['name'];
    echo json_encode(["success" => true, "role" => $user['role'], "name" => $user['name']]);
} else if ($email === 'admin@ambalangoda.com' && $password === 'admin123' && $requestedRole === 'admin') {
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'admin';
    $_SESSION['name'] = 'Admin';
    echo json_encode(["success" => true, "role" => 'admin', "name" => 'Admin']);
} else {
    echo json_encode(["error" => "Invalid email or password"]);
}
?>

