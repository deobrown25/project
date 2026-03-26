<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
<title>Instructors</title>
</head>
<body>

<h2>Instructors List</h2>
<p>Retrieved at: <?php echo date("Y-m-d H:i:s"); ?></p>

<table border="1">
<tr>
<th>ID</th><th>Name</th><th>Specialty</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM Instructor");

while($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['employee_id']}</td>
    <td>{$row['first_name']} {$row['last_name']}</td>
    <td>{$row['last_name']}</td>
    <td>{$row['specialty']}</td>
    </tr>";
}
?>

</table>
</body>
</html>