<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $batch = $_POST['batch'];
    $degree = $_POST['degree'];
    $diploma = $_POST['diploma'];
    $mark_12 = $_POST['mark_12'];
    $mark_10 = $_POST['mark_10'];
    $contact = $_POST['contact'];
    $email_id = $_POST['email_id'];

    $sql = "INSERT INTO students (name, batch, degree, diploma, mark_12, mark_10, contact, email_id)
            VALUES ('$name', '$batch', '$degree', '$diploma', '$mark_12', '$mark_10', '$contact', '$email_id')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to thankyou page
        header("Location: thankyou.html");
        exit(); // always use exit after header redirects
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
