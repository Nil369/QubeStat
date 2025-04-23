<?php
require_once __DIR__ . '/../config/db_connect.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? '';
$new_password = password_hash($data['new_password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
$stmt->bind_param("ss", $new_password, $token);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Password reset successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid or expired token"]);
}

?>