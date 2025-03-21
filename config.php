<?php
$servername = "localhost";
$username = "root"; // Change if needed
$password = "12345678"; // Change if needed
$dbname = "skillcrafters"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>