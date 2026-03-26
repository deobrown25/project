<?php include 'db.php'; ?>

<form method="POST">
Classroom ID: <input name="id"><br>
New Room Number: <input name="room"><br>
<input type="submit">
</form>

<?php
if ($_POST) {
    $stmt = $conn->prepare("UPDATE Classroom SET room=? WHERE id=?");
    $stmt->bind_param("si", $_POST['room'], $_POST['id']);
    $stmt->execute();

    echo "Updated successfully!";
}
?>