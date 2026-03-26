<?php include 'db.php'; ?>

<form method="POST">
First Name: <input name="first_name" required><br>
Last Name: <input name="last_name" required><br>
City: <input name="city"><br>
Major: <input name="major"><br>
<input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $stmt = $conn->prepare("INSERT INTO Student 
        (student_id, first_name, last_name, city, major)
        VALUES (?, ?, ?, ?, ?)");

        $id = rand(200,999);

        $stmt->bind_param("issss", $id,
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['city'],
            $_POST['major']
        );

        $stmt->execute();

        echo "Student added successfully!";

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>