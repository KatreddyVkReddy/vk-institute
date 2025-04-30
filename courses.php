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

$courses = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = '%' . trim($_GET['search']) . '%';
    $sql = "SELECT * FROM courses WHERE course_name ILIKE :search ORDER BY course_name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Courses</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; padding: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2>Courses Page</h2>

<form method="GET" action="courses.php">
    <input type="text" name="search" placeholder="Search Courses" required>
    <button type="submit">Search</button>
</form>

<?php if (!empty($courses)) : ?>
<table>
    <tr>
        <th>Course Name</th>
        <th>Duration</th>
    </tr>
    <?php foreach ($courses as $course) : ?>
    <tr>
        <td><?= htmlspecialchars($course['course_name']) ?></td>
        <td><?= htmlspecialchars($course['course_duration']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php elseif (isset($_GET['search'])) : ?>
    <p>No courses found.</p>
<?php endif; ?>

</body>
</html>
