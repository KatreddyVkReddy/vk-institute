<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection script
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if POST data exists
    if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone_number'], $_POST['username'], $_POST['password'])) {
        // Get form data
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $username = $_POST['username'];
        $password = $_POST['password']; // In a real-world scenario, hash the password

        // Debugging: print form data to check if the data is being submitted
        // echo "<pre>";
        // print_r($_POST);  // Display form data
        // echo "</pre>";

        // Hash the password (for security purposes)
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert data into the students table
        $query = "INSERT INTO students (first_name, last_name, email, phone_number, username, password) 
                  VALUES ($1, $2, $3, $4, $5, $6)";

        // Execute the query using prepared statements
        $result = pg_query_params($conn, $query, array($first_name, $last_name, $email, $phone_number, $username, $hashed_password));

        if ($result) {
            // Success message (you can redirect to login page)
            echo "Sign Up Successful! <a href='login.html'>Click here to Log In</a>";
        } else {
            // Error message
            echo "Error: " . pg_last_error($conn);
        }
    } else {
        echo "Form data not received. Please check your form submission.";
    }
}

// Close the connection
close_connection($conn);
?>
