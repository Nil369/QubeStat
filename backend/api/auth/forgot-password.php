<?php
require_once __DIR__ . '/../config/db_connect.php';
require_once __DIR__ . '/../helpers/send_email.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';

$token = bin2hex(random_bytes(16));
$conn->query("UPDATE users SET reset_token = '$token' WHERE email = '$email'");

$link = "http://localhost/auth/reset-password.php?token=$token";
sendMail($email, "Password Reset", "Click to reset your password: $link");

echo json_encode(["status" => "success", "message" => "Reset link sent"]);

?>