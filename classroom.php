<?php
include 'db.php'; // Connects to your database

// Handle update if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $room = $_POST['room'];

    if (!empty($room)) {
        $stmt = $conn->prepare("UPDATE Classroom SET room=? WHERE id=?");
        $stmt->bind_param("si", $room, $id);

        if ($stmt->execute()) {
            $message = "Room updated successfully!";
        } else {
            $message = "Error updating room: " . $conn->error;
        }
    } else {
        $message = "Room number cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Classrooms</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
        .message { color: green; margin-bottom: 10px; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Classroom List</h2>
<p>Retrieved at: <?php echo date("Y-m-d H:i:s"); ?></p>

<?php if(isset($message)) { echo "<p class='message'>{$message}</p>"; } ?>

<table>
    <tr>
        <th>ID</th>
        <th>Building</th>
        <th>Floor</th>
        <th>Room</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM Classroom");
    if (!$result) { die("Error retrieving classrooms: " . $conn->error); }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['building']}</td>
        <td>{$row['floor']}</td>
        <td>{$row['room']}</td>
        </tr>";
    }
    ?>
</table>

<h3>Update Room Number</h3>
<form method="POST">
    Classroom ID: <input type="number" name="id" required>
    New Room Number: <input type="text" name="room" required>
    <input type="submit" name="update" value="Update Room">
</form>

</body>
</html>