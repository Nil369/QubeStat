<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../models/Users.models.php';
require_once __DIR__ . '/../../helpers/XML_encoder.php';
require_once __DIR__ . '/../../helpers/emails/verify-email.php';
require_once __DIR__ . '/../../helpers/send_mail.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['username'], $data['email'], $data['password'], $data['first_name'], $data['last_name'])) {
    $response = ["status" => "error", "message" => "Missing required fields"];
    
    if (isset($_GET['xml']) && $_GET['xml'] === 'true') {
        header("Content-Type: application/xml");
        echo jsonToXml($response);
    } else {
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    exit;
}

// Call the createUser function to register the user AND get the verification code
$registrationResult = createUser(
    $data['username'],
    $data['email'],
    $data['password'],
    $data['first_name'],
    $data['last_name']
);

if (!$registrationResult['success']) {
    $response = ["status" => "error", "message" => "Failed to create user."];
    
    if (isset($_GET['xml']) && $_GET['xml'] === 'true') {
        header("Content-Type: application/xml");
        echo jsonToXml($response);
    } else {
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    exit;
}

// Access the verification code from the registration result
$code = $registrationResult['verification_code'];

// Try to send verification email
$email = $data['email'];
$link = $_ENV["APP_BASE_URL"] . "users/users.php?code=$code";
$htmlBody = getVerificationEmailHTML($link);

$mailSent = sendMail($email, "Verify your email", $htmlBody);

if (!$mailSent) {
    $response = ["status" => "error", "message" => "Failed to send verification email."];
    
    if (isset($_GET['xml']) && $_GET['xml'] === 'true') {
        header("Content-Type: application/xml");
        echo jsonToXml($response);
    } else {
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    exit;
}

// If email sent successfully, you can optionally send a success message here
$response = ["status" => "success", "message" => "User registered successfully. Please check your email to verify your account."];

if (isset($_GET['xml']) && $_GET['xml'] === 'true') {
    header("Content-Type: application/xml");
    echo jsonToXml($response);
} else {
    echo json_encode($response, JSON_PRETTY_PRINT);
}

?>