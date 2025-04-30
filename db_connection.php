<?php
// Database credentials
$host = "192.168.29.111"; // PostgreSQL host
$port = "5432";
$dbname = "vk_institute"; // PostgreSQL database name
$user = "reddy"; // PostgreSQL username
$password = "reddy"; // PostgreSQL password

// Establishing a connection to PostgreSQL
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    // If connection fails, display an error
    die("Connection failed: " . pg_last_error());
} else {
    // If connection succeeds, return the connection resource
    echo "Connected to the database successfully!";
}

// Function to close the connection
function close_connection($conn) {
    pg_close($conn);
}
?>
