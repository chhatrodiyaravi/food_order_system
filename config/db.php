<?php
<<<<<<< HEAD

// Load environment variables from .env file
require_once __DIR__ . '/env_loader.php';

=======
>>>>>>> 0d6c4840b28b5f5cc20de54d3139d2c149f02ca1
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_order_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
