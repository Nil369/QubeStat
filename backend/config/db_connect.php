<?php

// Load Composer autoloader only once wherever this is included
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/load_env.php'; // Load environment variables


// Get DB details from .env
$hostname = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASS'];
$db_name  = $_ENV['DB_NAME'];



$conn = mysqli_connect($hostname, $username, $password, $db_name)
        or die("ERROR :: Failed to connect to DB!");

// echo "Connecting to DB...<br>";


// if($conn){
//     echo "<b style='color: green;'>Connected to Database successfully!</b><br>\n";
// }
// else{
//     echo "<b style='color: red;>ERROR :: </b> <em>Failed to connect to DB</em>";
//     die("Failed to connect to DB!") . mysqli_connect_error() . "</p><br>\n";
// }


?>
