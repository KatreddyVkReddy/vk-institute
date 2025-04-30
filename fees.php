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

$fees_list = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = (float)$_GET['search'];
    $sql = "SELECT * FROM fees WHERE admission_fees = :search OR course_fees = :search ORDER BY fees_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search);
    $stmt->execute();
    $fees_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fees</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; padding: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2>Fees Page</h2>

<form method="GET" action="fees.php">
    <input type="number" name="search" step="0.01" placeholder="Search by Amount" required>
    <button type="submit">Search</button>
</form>

<?php if (!empty($fees_list)) : ?>
<table>
    <tr>
        <th>Admission Fees</th>
        <th>Course Fees</th>
    </tr>
    <?php foreach ($fees_list as $fee) : ?>
    <tr>
        <td><?= htmlspecialchars($fee['admission_fees']) ?></td>
        <td><?= htmlspecialchars($fee['course_fees']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php elseif (isset($_GET['search'])) : ?>
    <p>No matching fees found.</p>
<?php endif; ?>

</body>
</html>
