<?php
include 'db.php'; // database connection

// ------------------------
// Functions
// ------------------------

// Fetch all students from database
function getAllStudents() {
    global $conn;
    try {
        $sql = "SELECT Student.student_id, first_name, last_name, street, city, state, zip, ClassStanding.class_name AS class, major 
                FROM Student 
                JOIN ClassStanding ON Student.class_standing = ClassStanding.id
                ORDER BY last_name";
        $result = $conn->query($sql);
        if (!$result) throw new Exception("Failed to fetch students: " . $conn->error);
        return $result;
    } catch (Exception $e) {
        echo "<p class='error'>Exception: " . $e->getMessage() . "</p>";
        return [];
    }
}

// Insert new student into database
function addStudent($id, $fname, $lname, $street, $city, $state, $zip, $class_id, $major) {
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO Student(student_id, first_name, last_name, street, city, state, zip, class_standing, major)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("issssssis", $id, $fname, $lname, $street, $city, $state, $zip, $class_id, $major);
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        echo "<p class='error'>Exception: " . $e->getMessage() . "</p>";
        return false;
    }
}

// ------------------------
// Handle form submission
// ------------------------
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $id = intval($_POST['student_id']);
    $fname = trim($_POST['first_name']);
    $lname = trim($_POST['last_name']);
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zip = trim($_POST['zip']);
    $class_id = intval($_POST['class_standing']);
    $major = trim($_POST['major']);

    if (!empty($fname) && !empty($lname)) {
        if (addStudent($id, $fname, $lname, $street, $city, $state, $zip, $class_id, $major)) {
            $message = "Student added successfully!";
        } else {
            $message = "Error adding student. Check debug messages.";
        }
    } else {
        $message = "First name and last name are required!";
    }
}

// Fetch students for display
$students = getAllStudents();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
        input[type=text], input[type=number], select { padding: 5px; margin: 5px; width: 200px; }
        input[type=submit] { padding: 5px 10px; }
        .message { color: green; }
        .error { color: red; }
    </style>
    <script>
        // JS form validation
        function validateForm() {
            let fname = document.forms["studentForm"]["first_name"].value.trim();
            let lname = document.forms["studentForm"]["last_name"].value.trim();
            if(fname === "" || lname === "") {
                alert("First and Last Name are required!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<h2>Students List</h2>
<p>Page retrieved at: <?php echo date("Y-m-d H:i:s"); ?></p>

<?php if($message) { echo "<p class='message'>{$message}</p>"; } ?>

<!-- Add Student Form -->
<h3>Add New Student</h3>
<form name="studentForm" method="POST" onsubmit="return validateForm();">
    Student ID: <input type="number" name="student_id" required><br>
    First Name: <input type="text" name="first_name" required><br>
    Last Name: <input type="text" name="last_name" required><br>
    Street: <input type="text" name="street"><br>
    City: <input type="text" name="city"><br>
    State: <input type="text" name="state"><br>
    ZIP: <input type="text" name="zip"><br>
    Class Standing:
    <select name="class_standing">
        <?php
        $classResult = $conn->query("SELECT * FROM ClassStanding");
        while ($row = $classResult->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['class_name']}</option>";
        }
        ?>
    </select><br>
    Major: <input type="text" name="major"><br>
    <input type="submit" name="add_student" value="Add Student">
</form>

<!-- Display Students -->
<table>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>ZIP</th>
        <th>Class</th>
        <th>Major</th>
    </tr>
    <?php
    foreach($students as $row) {
        echo "<tr>
            <td>{$row['student_id']}</td>
            <td>{$row['first_name']}</td>
            <td>{$row['last_name']}</td>
            <td>{$row['street']}</td>
            <td>{$row['city']}</td>
            <td>{$row['state']}</td>
            <td>{$row['zip']}</td>
            <td>{$row['class']}</td>
            <td>{$row['major']}</td>
        </tr>";
    }
    ?>
</table>

</body>
</html>