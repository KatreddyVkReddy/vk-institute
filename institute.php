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

$institutes = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = '%' . trim($_GET['search']) . '%';
    $sql = "SELECT * FROM institute WHERE institute_name ILIKE :search OR location ILIKE :search ORDER BY institute_name";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':search', $search);
    $stmt->execute();
    $institutes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Institutes</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; text-align: center; padding: 20px; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2>Institutes Page</h2>

<form method="GET" action="institutes.php">
    <input type="text" name="search" placeholder="Search Institutes or Locations" required>
    <button type="submit">Search</button>
</form>

<?php if (!empty($institutes)) : ?>
<table>
    <tr>
        <th>Institute Name</th>
        <th>Location</th>
    </tr>
    <?php foreach ($institutes as $institute) : ?>
    <tr>
        <td><?= htmlspecialchars($institute['institute_name']) ?></td>
        <td><?= htmlspecialchars($institute['location']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php elseif (isset($_GET['search'])) : ?>
    <p>No institutes found.</p>
<?php endif; ?>

</body>
</html>
