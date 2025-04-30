<?php
// Include the database connection script
include('db_connection.php');

// Get data from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check if the student exists
$query = "SELECT * FROM students WHERE username = $1";
$result = pg_query_params($conn, $query, array($username));

// Fetch the user from the result
$user = pg_fetch_assoc($result);

// Check if the student exists and verify password
if ($user && password_verify($password, $user['password'])) {
    // Student found and password matched, log them in (session handling can be added here)
    session_start();
    $_SESSION['username'] = $username;
    header("Location: dashboard.html"); // Redirect to the dashboard page
} else {
    // Student not found or password mismatch, display an error message
    echo "Invalid username or password!";
}

// Close the connection (call the function defined in db_connection.php)
close_connection($conn);
?>
