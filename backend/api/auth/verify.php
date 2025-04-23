<?php
require_once __DIR__ . '/../config/db_connect.php';

$code = $_GET['code'] ?? '';

if ($code === '') {
    echo json_encode(["status" => "error", "message" => "Missing code"]);
    exit;
}

$stmt = $conn->prepare("UPDATE users SET is_verified = 1, verification_code = NULL WHERE verification_code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["status" => "success", "message" => "Email verified"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid code"]);
}

?>