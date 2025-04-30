<?php
// Database connection
$host = "192.168.29.238"; 
$dbname = "vk_institute"; 
$username = "vk"; 
$password = "reddy";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Fetch student data by name '123'
$student_name = '123'; // You can change this dynamically if needed

$sql = "SELECT e.first_name, e.last_name, e.email, e.phone_number, i.institute_name, i.location, c.course_name, c.course_duration, f.admission_fees, f.course_fees
        FROM enrollment e
        JOIN institute i ON e.institute_id = i.institute_id
        JOIN fees f ON e.fees_id = f.fees_id
        JOIN courses c ON e.course_id = c.course_id
        WHERE e.first_name = :student_name OR e.last_name = :student_name";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':student_name', $student_name);
$stmt->execute();

$student_data = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; padding: 20px; }
        h2 { color: #333; }
        p { font-size: 1.2em; color: #555; }
        strong { color: #333; }
    </style>
</head>
<body>

<?php
if ($student_data) {
    echo "<h2>Student Details</h2>";
    echo "<p><strong>First Name:</strong> " . $student_data['first_name'] . "</p>";
    echo "<p><strong>Last Name:</strong> " . $student_data['last_name'] . "</p>";
    echo "<p><strong>Email:</strong> " . $student_data['email'] . "</p>";
    echo "<p><strong>Phone Number:</strong> " . $student_data['phone_number'] . "</p>";
    echo "<p><strong>Institute Name:</strong> " . $student_data['institute_name'] . "</p>";
    echo "<p><strong>Location:</strong> " . $student_data['location'] . "</p>";
    echo "<p><strong>Course Name:</strong> " . $student_data['course_name'] . "</p>";
    echo "<p><strong>Course Duration:</strong> " . $student_data['course_duration'] . "</p>";
    echo "<p><strong>Admission Fees:</strong> " . $student_data['admission_fees'] . "</p>";
    echo "<p><strong>Course Fees:</strong> " . $student_data['course_fees'] . "</p>";
} else {
    echo "<p>No data found for the student.</p>";
}
?>

</body>
</html>
