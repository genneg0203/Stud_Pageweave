<?php
include 'db.php';

$name = $_POST['name'];
$batch = $_POST['batch'];
$degree = $_POST['degree'];
$diploma = $_POST['diploma'];
$mark_12 = $_POST['mark_12'];
$mark_10 = $_POST['mark_10'];
$contact = $_POST['contact'];
$email = $_POST['email'];

$stmt = $conn->prepare("INSERT INTO student_info (name, batch, degree, diploma, mark_12, mark_10, contact, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssddss", $name, $batch, $degree, $diploma, $mark_12, $mark_10, $contact, $email);

if ($stmt->execute()) {
    echo "Student added successfully.<br>";
    echo "<a href='index.html'>Add Another</a> | <a href='students.php'>View Students</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>



