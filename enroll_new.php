<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "192.168.29.111"; 
$dbname = "vk_institute"; 
$username = "reddy"; 
$password = "reddy"; 

// Create connection
try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $institute_name = $_POST['institute_name'];
    $location = $_POST['location'];
    $course_name = $_POST['course_name'];
    $course_duration = $_POST['course_duration'];
    $admission_fees = $_POST['admission_fees'];
    $course_fees = $_POST['course_fees']; 

    try {
        // Step 1: Insert the institute data
        $sql_institute = "INSERT INTO institute (institute_name, location) VALUES (:institute_name, :location)";
        $stmt_institute = $conn->prepare($sql_institute);
        $stmt_institute->bindParam(':institute_name', $institute_name);
        $stmt_institute->bindParam(':location', $location);
        $stmt_institute->execute();
        $institute_id = $conn->lastInsertId();

        // Step 2: Insert the fees data
        $sql_fee = "INSERT INTO fees (admission_fees, course_fees) VALUES (:admission_fees, :course_fees)";
        $stmt_fee = $conn->prepare($sql_fee);
        $stmt_fee->bindParam(':admission_fees', $admission_fees);
        $stmt_fee->bindParam(':course_fees', $course_fees); 
        $stmt_fee->execute();
        $fees_id = $conn->lastInsertId();

        // Step 3: Insert the course data
        $sql_course = "INSERT INTO courses (course_name, course_duration) VALUES (:course_name, :course_duration)";
        $stmt_course = $conn->prepare($sql_course);
        $stmt_course->bindParam(':course_name', $course_name);
        $stmt_course->bindParam(':course_duration', $course_duration);
        $stmt_course->execute();
        $course_id = $conn->lastInsertId();

        // Step 4: Insert the enrollment data (linking the institute, fees, and course IDs)
        $sql_enrollment = "INSERT INTO enrollment (first_name, last_name, email, phone_number, institute_id, fees_id, course_id) 
                           VALUES (:first_name, :last_name, :email, :phone_number, :institute_id, :fees_id, :course_id)";
        $stmt_enrollment = $conn->prepare($sql_enrollment);
        $stmt_enrollment->bindParam(':first_name', $first_name);
        $stmt_enrollment->bindParam(':last_name', $last_name);
        $stmt_enrollment->bindParam(':email', $email);
        $stmt_enrollment->bindParam(':phone_number', $phone_number);
        $stmt_enrollment->bindParam(':institute_id', $institute_id);
        $stmt_enrollment->bindParam(':fees_id', $fees_id);
        $stmt_enrollment->bindParam(':course_id', $course_id);

        if ($stmt_enrollment->execute()) {
            echo "<script>alert('Enrollment successful!');</script>";
        } else {
            echo "<script>alert('Error during enrollment. Please try again later.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment - VK's Infinite Computer Solutions</title>
</head>
<body>
    <h2>Enrollment Form</h2>
    <form action="enroll.php" method="POST">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone_number" placeholder="Phone Number" required>
        <input type="text" name="institute_name" placeholder="Institute Name" required>
        <input type="text" name="location" placeholder="Location" required>
        <input type="text" name="course_name" placeholder="Course Name" required>
        <input type="text" name="course_duration" placeholder="Course Duration" required>
        <input type="number" name="admission_fees" placeholder="Admission Fees" required>
        <input type="number" name="course_fees" placeholder="Course Fees" required>
        <button type="submit">Enroll</button>
    </form>
</body>
</html>
