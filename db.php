<?php
// /config/db.php

$host = 'localhost';  // Database host
$dbname = 'grading-system';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password (empty for XAMPP default)

$conn = mysqli_connect($host, $username, $password, $dbname);

// Check the database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
