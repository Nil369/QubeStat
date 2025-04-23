<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../helpers/XML_encoder.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username'], $data['email'], $data['password'], $data['first_name'], $data['last_name'])) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

$apiUrl = 'http://localhost/QubeStat/backend/api/users/users.php';
$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/json",
        'content' => json_encode($data)
    ]
];
$response = file_get_contents($apiUrl, false, stream_context_create($options));
$result = json_decode($response, true);

if ($result['status'] === 'success') {
    $code = bin2hex(random_bytes(16));
    $conn->query("UPDATE users SET verification_code = '$code' WHERE email = '{$data['email']}'");
    $link = "http://localhost/QubeStat/backend/api/users/users.php?code=$code";
    sendMail($data['email'], "Verify your email", "Click here to verify: $link");
}

echo json_encode($result);

?>