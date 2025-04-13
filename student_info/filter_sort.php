<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "student_info"; // make sure your DB name is correct

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$degree = $_POST['degree'];
$diploma = $_POST['diploma'];
$mark_12 = $_POST['mark_12'];
$mark_10 = $_POST['mark_10'];
$sort_by = $_POST['sort_by'];
$direction = $_POST['direction'];

$where = [];
if (!empty($degree)) $where[] = "degree >= '$degree'";
if (!empty($diploma)) $where[] = "diploma >= '$diploma'";
if (!empty($mark_12)) $where[] = "mark_12 >= '$mark_12'";
if (!empty($mark_10)) $where[] = "mark_10 >= '$mark_10'";

$whereClause = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";
$sql = "SELECT * FROM students $whereClause ORDER BY $sort_by $direction";
$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error . "<br>SQL: " . $sql);
}


if ($result->num_rows > 0) {
    echo "<table><tr><th>Name</th><th>degree</th><th>diploma</th><th>mark_12</th><th>mark_10</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['degree']}</td>
                <td>{$row['diploma']}</td>
                <td>{$row['mark_12']}</td>
                <td>{$row['mark_10']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found.</p>";
}

// Done button (always shown)
echo "<form action='thankyou.php' method='post'>
        <button type='submit' style='padding: 10px 20px; font-size: 16px; background: green; color: white; border: none; cursor: pointer;'>Done</button>
      </form>";

echo "</div>";

$conn->close();
?>