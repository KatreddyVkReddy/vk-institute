<?php
// Database credentials
$host     = getenv("DB_HOST");
$port     = getenv("DB_PORT");
$dbname   = getenv("DB_NAME");
$user     = getenv("DB_USER");
$password = getenv("DB_PASS");

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
