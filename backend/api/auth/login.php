<?php
session_start();
require_once __DIR__ . '/../../config/db_connect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$result = $conn->query("SELECT * FROM users WHERE email = '$email'");
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    if (!$user['is_verified']) {
        echo json_encode(["status" => "error", "message" => "Email not verified"]);
    } else {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(["status" => "success", "message" => "Login successful"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
}

?>