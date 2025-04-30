<?php
// Database connection
$host = "192.168.29.111"; 
$dbname = "vk_institute"; 
$username = "reddy"; 
$password = "reddy";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$students = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = '%' . trim($_GET['search']) . '%';
    $sql = "SELECT e.enrollment_id, e.first_name, e.last_name, e.email, e.phone_number, c.course_name, i.institute_name
            FROM enrollment e
            JOIN courses c ON e.course_id = c.course_id
            JOIN institute i ON e.institute_id = i.institute_id
            WHERE e.first_name ILIKE :search OR e.last_name ILIKE :search
            ORDER BY e.last_name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; padding: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2>Students Page</h2>

<form method="GET" action="students.php">
    <input type="text" name="search" placeholder="Search Students" required>
    <button type="submit">Search</button>
</form>

<?php if (!empty($students)) : ?>
<table>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Course</th>
        <th>Institute</th>
    </tr>
    <?php foreach ($students as $student) : ?>
    <tr>
        <td><?= htmlspecialchars($student['first_name']) ?></td>
        <td><?= htmlspecialchars($student['last_name']) ?></td>
        <td><?= htmlspecialchars($student['email']) ?></td>
        <td><?= htmlspecialchars($student['phone_number']) ?></td>
        <td><?= htmlspecialchars($student['course_name']) ?></td>
        <td><?= htmlspecialchars($student['institute_name']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php elseif (isset($_GET['search'])) : ?>
    <p>No students found.</p>
<?php endif; ?>

</body>
</html>
