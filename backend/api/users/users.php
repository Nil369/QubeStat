<?php

// Allow CORS & Application headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../models/Users.models.php';
require_once __DIR__ . '/../../helpers/XML_encoder.php';

$method = $_SERVER['REQUEST_METHOD'];
$response = [];

try {
    switch ($method) {
        case 'GET':
            // Priority: ID > Search > All
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $user = getUserById($id);

                if ($user) {
                    $response = [
                        "status" => "success",
                        "message" => "User fetched with ID: $id",
                        "data" => $user
                    ];
                } else {
                    $response = [
                        "status" => "error",
                        "message" => "No user found with ID: $id"
                    ];
                }

            } elseif (isset($_GET['search'])) {
                $keyword = $_GET['search'];
                $users = searchUsers($keyword);
                $response = [
                    "status" => "success",
                    "message" => "Search results for '$keyword'",
                    "data" => $users
                ];

            } else {
                $users = getAllUsers();
                $response = [
                    "status" => "success",
                    "message" => "All users fetched.",
                    "data" => $users
                ];
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['username'], $data['email'], $data['password'], $data['first_name'], $data['last_name'])) {
                $response = [
                    "status" => "error",
                    "message" => "Missing required fields."
                ];
                break;
            }

            $created = createUser($data['username'], $data['email'], $data['password'], $data['first_name'], $data['last_name']);        

            $response = $created ? [
                "status" => "success",
                "message" => "User created successfully."
            ] : [
                "status" => "error",
                "message" => "Failed to create user."
            ];
            break;

        case 'PUT':
            parse_str($_SERVER['QUERY_STRING'], $queryParams);
            $id = $queryParams['id'] ?? null;

            if (!$id) {
                $response = [
                    "status" => "error",
                    "message" => "Missing user ID in query params"
                ];
                break;
            }

            $data = json_decode(file_get_contents("php://input"), true);
            $allowedFields = ['username', 'email', 'first_name', 'last_name'];

            $fieldsToUpdate = array_intersect_key($data, array_flip($allowedFields));

            if (empty($fieldsToUpdate)) {
                $response = [
                    "status" => "error",
                    "message" => "No valid fields to update"
                ];
                break;
            }

            $updated = updateUser($id, $fieldsToUpdate);

            $response = $updated ? [
                "status" => "success",
                "message" => "User updated successfully"
            ] : [
                "status" => "error",
                "message" => "Failed to update user"
            ];
            break;

        case 'DELETE':
            parse_str($_SERVER['QUERY_STRING'], $queryParams);
            $id = $queryParams['id'] ?? null;

            if (!$id) {
                $response = [
                    "status" => "error",
                    "message" => "Missing user ID"
                ];
                break;
            }

            $deleted = deleteUser($id);

            $response = $deleted ? [
                "status" => "success",
                "message" => "User deleted successfully"
            ] : [
                "status" => "error",
                "message" => "Failed to delete user"
            ];
            break;

        default:
            $response = [
                "status" => "error",
                "message" => "Unsupported request method."
            ];
            break;
    }
} catch (Throwable $e) {
    $response = [
        "status" => "error",
        "message" => "Server Error: " . $e->getMessage()
    ];
}

// Convert to XML if ?xml=true is passed
if (isset($_GET['xml']) && $_GET['xml'] === 'true') {
    header("Content-Type: application/xml");
    echo jsonToXml($response);
} else {
    echo json_encode($response, JSON_PRETTY_PRINT);
}
