<?php
$servername = "localhost";
$username = "webuser";
$password = "yourpassword";
$database = "mywebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected to MySQL successfully!";
?>
