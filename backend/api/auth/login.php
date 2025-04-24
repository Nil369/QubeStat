<?php
session_start();
require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../models/Users.models.php';
require_once __DIR__ . '/../../helpers/emails/verify-email.php';
require_once __DIR__ . '/../../helpers/send_mail.php';
require_once __DIR__ . '/../../helpers/XML_encoder.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

// Assuming you have a function in Users.models.php to fetch user by email safely
$user = getUserByEmail($email, $conn);

$response = [];

if ($user && password_verify($password, $user['password'])) {
    if (!$user['is_verified']) {
        // Generate a new verification code
        $verificationCode = bin2hex(random_bytes(16));

        // Assuming you have a function in Users.models.php to update verification code safely
        $updateResult = updateUserVerificationCode($user['id'], $verificationCode, $conn);

        if ($updateResult) {
            // Send the verification email
            $link = $_ENV["APP_BASE_URL"] . "users/users.php?code=$verificationCode";
            $htmlBody = verificationEmailHTML($link);
            $mailSent = sendMail($email, "Verify your email", $htmlBody);

            if ($mailSent) {
                $response = ["status" => "pending_verification", "message" => "Email not verified. A new verification link has been sent to your email address."];
            } else {
                $response = ["status" => "error", "message" => "Email not verified. Failed to resend verification email."];
            }
        } else {
            $response = ["status" => "error", "message" => "Database error updating verification code."];
        }
    } else {
        $_SESSION['user_id'] = $user['id'];
        $response = ["status" => "success", "message" => "Login successful"];
    }
} else {
    $response = ["status" => "error", "message" => "Invalid credentials"];
}

if (isset($_GET['xml']) && $_GET['xml'] === 'true') {
    header("Content-Type: application/xml");
    echo jsonToXml($response);
} else {
    echo json_encode($response, JSON_PRETTY_PRINT);
}

?>