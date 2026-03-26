<?php
include 'db.php'; // Connects to your database

// Handle update if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $crn = intval($_POST['crn']);
    $days = $_POST['days'];
    $time = $_POST['time'];

    if (!empty($days) && !empty($time)) {
        $stmt = $conn->prepare("UPDATE Course SET days=?, time=? WHERE crn=?");
        $stmt->bind_param("ssi", $days, $time, $crn);

        if ($stmt->execute()) {
            $message = "Course updated successfully!";
        } else {
            $message = "Error updating course: " . $conn->error;
        }
    } else {
        $message = "Days and time cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 90%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
        .message { color: green; margin-bottom: 10px; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Course List</h2>
<p>Retrieved at: <?php echo date("Y-m-d H:i:s"); ?></p>

<?php if(isset($message)) { echo "<p class='message'>{$message}</p>"; } ?>

<table>
    <tr>
        <th>CRN</th>
        <th>Instructor</th>
        <th>Classroom</th>
        <th>Days</th>
        <th>Time</th>
    </tr>
    <?php
    $sql = "SELECT Course.crn, Instructor.first_name, Instructor.last_name,
                   Classroom.building, Classroom.room, Course.days, Course.time
            FROM Course
            JOIN Instructor ON Course.instructor = Instructor.employee_id
            JOIN Classroom ON Course.classroom = Classroom.id";

    $result = $conn->query($sql);
    if (!$result) { die("Error retrieving courses: " . $conn->error); }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['crn']}</td>
        <td>{$row['first_name']} {$row['last_name']}</td>
        <td>{$row['building']} {$row['room']}</td>
        <td>{$row['days']}</td>
        <td>{$row['time']}</td>
        </tr>";
    }
    ?>
</table>

<h3>Update Course Days & Time</h3>
<form method="POST">
    CRN: <input type="number" name="crn" required>
    Days (e.g., MWF, TTH): <input type="text" name="days" required>
    Time (e.g., 10:00AM): <input type="text" name="time" required>
    <input type="submit" name="update" value="Update Course">
</form>

</body>
</html>