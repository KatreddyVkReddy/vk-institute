<?php
// Read database credentials from environment variables
$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$dbname = getenv("DB_NAME");
$user = getenv("DB_USER");
$password = getenv("DB_PASSWORD");

// Create connection string
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Try to connect
$conn = pg_connect($conn_string);

if ($conn) {
    echo "<h1>✅ Connected to PostgreSQL successfully!</h1>";
} else {
    echo "<h1>❌ Failed to connect to PostgreSQL!</h1>";
    echo "<pre>" . pg_last_error() . "</pre>";
}
?>
