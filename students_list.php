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

// Fetch all enrolled students with their details
$sql = "SELECT e.enrollment_id, e.first_name, e.last_name, e.email, e.phone_number, c.course_name, i.institute_name
        FROM enrollment e
        JOIN courses c ON e.course_id = c.course_id
        JOIN institute i ON e.institute_id = i.institute_id
        ORDER BY e.last_name";

$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List - VK's Infinite Computer Solutions</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; padding: 20px; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h2>Student List</h2>

<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Course</th>
        <th>Institute</th>
        <th>Action</th>
    </tr>

    <?php
    if ($students) {
        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>" . $student['first_name'] . "</td>";
            echo "<td>" . $student['last_name'] . "</td>";
            echo "<td>" . $student['email'] . "</td>";
            echo "<td>" . $student['phone_number'] . "</td>";
            echo "<td>" . $student['course_name'] . "</td>";
            echo "<td>" . $student['institute_name'] . "</td>";
            echo "<td><a href='view_student.php?student_id=" . $student['student_id'] . "'>View Details</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No students found.</td></tr>";
    }
    ?>
</table>

</body>
</html>
