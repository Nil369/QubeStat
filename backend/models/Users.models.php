<?php
require_once __DIR__ . '/../config/db_connect.php';

// CREATE
function createUser($username, $email, $password, $first_name, $last_name) {
    global $conn;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // (5 's' for 5 string values)
    mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hash, $first_name, $last_name);

    return mysqli_stmt_execute($stmt);
}

// READ (all)
function getAllUsers() {
    global $conn;
    $sql = "SELECT id, username, email, first_name, last_name, role, status, created_at, updated_at FROM users";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// READ (ID)
function getUserById($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT id, username, email, first_name, last_name, role, status, created_at, updated_at FROM users WHERE id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
}

// SEARCH user by username or email
function searchUsers($keyword) {
    global $conn;
    $keyword = mysqli_real_escape_string($conn, $keyword);
    $sql = "SELECT id, username, email, first_name, last_name, role, status, created_at, updated_at 
            FROM users 
            WHERE username LIKE '%$keyword%' OR email LIKE '%$keyword%'";
    $result = mysqli_query($conn, $sql);

    $users = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}

// UPDATE
function updateUser($id, $fields) {
    global $conn;

    $setParts = [];
    $values = [];

    foreach ($fields as $key => $value) {
        $setParts[] = "$key = ?";
        $values[] = $value;
    }

    if (empty($setParts)) return false;

    $sql = "UPDATE users SET " . implode(', ', $setParts) . " WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind dynamic values
    $types = str_repeat("s", count($values)) . "i"; // s for each value, i for ID
    $values[] = $id;

    mysqli_stmt_bind_param($stmt, $types, ...$values);
    return mysqli_stmt_execute($stmt);
}


// DELETE
function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
?>
