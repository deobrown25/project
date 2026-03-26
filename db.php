<?php
$conn = new mysqli("sql302.infinityfree.com", "	if0_41481531", "123schoolproject", "if0_41481531_school_db");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>