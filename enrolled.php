<?php
include 'db.php'; // Connects to your database
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enrolled Students</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 95%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h2>Enrolled Students</h2>
<p>Retrieved at: <?php echo date("Y-m-d H:i:s"); ?></p>

<table>
    <tr>
        <th>Student ID</th>
        <th>Student Name</th>
        <th>CRN</th>
        <th>Course Days</th>
        <th>Course Time</th>
        <th>Classroom</th>
    </tr>

<?php
$sql = "SELECT Enrolled.student, Student.first_name, Student.last_name,
               Course.crn, Course.days, Course.time,
               Classroom.building, Classroom.room
        FROM Enrolled
        JOIN Student ON Enrolled.student = Student.student_id
        JOIN Course ON Enrolled.course = Course.crn
        JOIN Classroom ON Course.classroom = Classroom.id
        ORDER BY Student.last_name";

$result = $conn->query($sql);

if (!$result) {
    die("Error retrieving enrolled data: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['student']}</td>
        <td>{$row['first_name']} {$row['last_name']}</td>
        <td>{$row['crn']}</td>
        <td>{$row['days']}</td>
        <td>{$row['time']}</td>
        <td>{$row['building']} {$row['room']}</td>
    </tr>";
}
?>

</table>

</body>
</html>