<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once __DIR__ . '/../../helpers/XML_encoder.php';

// Destroy session and clear cookie
session_unset();
session_destroy();
setcookie("auth_session", "", time() - 3600, "/", "", false, true);

$response = ["status" => "success", "message" => "Logout successful"];

if (isset($_GET['xml']) && $_GET['xml'] === 'true') {
    header("Content-Type: application/xml");
    echo jsonToXml($response);
} else {
    echo json_encode($response, JSON_PRETTY_PRINT);
}

?>