<?php
include 'db.php';

$validFields = ['mark_Dg', 'mark_Di', 'mark_12', 'mark_10'];
$validDirections = ['asc', 'desc'];

$conditions = [];
foreach ($validFields as $field) {
    if (isset($_POST[$field . '_filter']) && is_numeric($_POST[$field . '_filter'])) {
        $value = $_POST[$field . '_filter'];
        $conditions[] = "$field >= $value";
    }
}

$where = count($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// Sorting
$sortField = $_POST['sortField'] ?? 'mark_Dg';
$sortDirection = strtolower($_POST['sortDirection'] ?? 'desc');

if (!in_array($sortField, $validFields)) $sortField = 'mark_Dg';
if (!in_array($sortDirection, $validDirections)) $sortDirection = 'desc';

$orderBy = "ORDER BY $sortField " . strtoupper($sortDirection);
$sql = "SELECT * FROM stud_info $where $orderBy";
$result = $conn->query($sql);

// Display results
if ($result && $result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Degree (CGPA)</th>
                <th>Diploma</th>
                <th>12th</th>
                <th>10th</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".htmlspecialchars($row['id'])."</td>
                <td>".htmlspecialchars($row['name'])."</td>
                <td>".htmlspecialchars($row['email_id'])."</td>
                <td>".htmlspecialchars($row['contact'])."</td>
                <td>".htmlspecialchars($row['mark_Dg'])."</td>
                <td>".htmlspecialchars($row['mark_Di'])."</td>
                <td>".htmlspecialchars($row['mark_12'])."</td>
                <td>".htmlspecialchars($row['mark_10'])."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found.</p>";
}
?>
