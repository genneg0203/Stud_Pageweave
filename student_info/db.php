<?php
$servername = "localhost";
$username = "root"; // change if different
$password = "";     // change if different
$dbname = "student_info"; // replace with your DB name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
