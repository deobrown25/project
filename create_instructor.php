<?php
include 'db.php'; // Connects to your database

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $specialty = trim($_POST['specialty']);

    if (!empty($first_name) && !empty($last_name)) {
        try {
            $stmt = $conn->prepare("INSERT INTO Instructor (employee_id, first_name, last_name, specialty) VALUES (?, ?, ?, ?)");
            $id = rand(300, 999); // Random employee ID
            $stmt->bind_param("isss", $id, $first_name, $last_name, $specialty);

            if ($stmt->execute()) {
                $message = "Instructor added successfully!";
            } else {
                $message = "Error adding instructor: " . $conn->error;
            }

        } catch (Exception $e) {
            $message = "Exception: " . $e->getMessage();
        }

    } else {
        $message = "First and last name are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Instructors</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
        .message { color: green; margin-bottom: 10px; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Instructor List</h2>
<p>Retrieved at: <?php echo date("Y-m-d H:i:s"); ?></p>

<?php if (isset($message)) { echo "<p class='message'>{$message}</p>"; } ?>

<!-- Add Instructor Form -->
<h3>Add New Instructor</h3>
<form method="POST">
    First Name: <input type="text" name="first_name" required><br><br>
    Last Name: <input type="text" name="last_name" required><br><br>
    Specialty: <input type="text" name="specialty"><br><br>
    <input type="submit" name="add" value="Add Instructor">
</form>

<!-- Display All Instructors -->
<table>
    <tr>
        <th>Employee ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Specialty</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM Instructor ORDER BY last_name");
    if (!$result) { die("Error retrieving instructors: " . $conn->error); }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['employee_id']}</td>
            <td>{$row['first_name']}</td>
            <td>{$row['last_name']}</td>
            <td>{$row['specialty']}</td>
        </tr>";
    }
    ?>
</table>

</body>
</html>