<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.html");
    exit();
}

include 'db.php';

// Initialize sorting parameters
$sortField = "mark_Dg"; // Default sort by Degree marks
$sortDirection = "DESC"; // Default sorting in descending order

$conditions = []; // Initialize the conditions for the WHERE clause

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['filter'])) {
    $fields = ['mark_Dg', 'mark_Di', 'mark_12', 'mark_10'];

    // Filter logic for marks (only single value, no min/max)
    foreach ($fields as $field) {
        if (isset($_GET["{$field}_filter"]) && is_numeric($_GET["{$field}_filter"])) {
            $value = (int) $_GET["{$field}_filter"];  // Ensure it's an integer
            $conditions[] = "$field = $value";  // Exact match for the mark
        }
    }

    // Sorting by selected field and direction
    if (isset($_GET['sortField']) && in_array($_GET['sortField'], $fields)) {
        $sortField = $_GET['sortField'];
    }

    if (isset($_GET['sortDirection']) && ($_GET['sortDirection'] == 'asc' || $_GET['sortDirection'] == 'desc')) {
        $sortDirection = strtoupper($_GET['sortDirection']);
    }
}

$where = count($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
$sql = "SELECT * FROM students $where ORDER BY $sortField $sortDirection";

// Ensure the query is safe before executing
if ($result = $conn->query($sql)) {
    // Query successful, we can proceed with displaying the data
} else {
    echo "Error: " . $conn->error;  // Show SQL error if the query fails
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 40px; background: #f0f2f5; }
    h2 { text-align: center; }
    form { text-align: center; margin-bottom: 30px; }
    input[type="number"] { width: 80px; padding: 5px; margin: 5px; }
    table { width: 100%; border-collapse: collapse; background: white; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #eee; }
    button { padding: 10px 20px; margin-top: 10px; }
  </style>
</head>
<body>

  <h2>Filter Student Records by Marks</h2>

  <form method="get">
    <input type="hidden" name="filter" value="1">
    
    <!-- Filter Inputs: Single value for each field -->
    Degree Marks: <input type="number" name="mark_Dg_filter" value="<?= htmlspecialchars($_GET['mark_Dg_filter'] ?? '') ?>"><br>
    Diploma Marks: <input type="number" name="mark_Di_filter" value="<?= htmlspecialchars($_GET['mark_Di_filter'] ?? '') ?>"><br>
    12th Marks: <input type="number" name="mark_12_filter" value="<?= htmlspecialchars($_GET['mark_12_filter'] ?? '') ?>"><br>
    10th Marks: <input type="number" name="mark_10_filter" value="<?= htmlspecialchars($_GET['mark_10_filter'] ?? '') ?>"><br>

    <!-- Sorting Inputs -->
    Sort by: 
    <select name="sortField">
      <option value="mark_Dg" <?= ($sortField == 'mark_Dg') ? 'selected' : ''; ?>>Degree Marks</option>
      <option value="mark_Di" <?= ($sortField == 'mark_Di') ? 'selected' : ''; ?>>Diploma Marks</option>
      <option value="mark_12" <?= ($sortField == 'mark_12') ? 'selected' : ''; ?>>12th Marks</option>
      <option value="mark_10" <?= ($sortField == 'mark_10') ? 'selected' : ''; ?>>10th Marks</option>
    </select>

    Direction: 
    <select name="sortDirection">
      <option value="asc" <?= ($sortDirection == 'ASC') ? 'selected' : ''; ?>>Ascending</option>
      <option value="desc" <?= ($sortDirection == 'DESC') ? 'selected' : ''; ?>>Descending</option>
    </select>

    <button type="submit">Filter & Sort</button>
  </form>

  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Contact</th>
      <th>Degree</th>
      <th>Diploma</th>
      <th>12th</th>
      <th>10th</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email_id']) ?></td>
        <td><?= htmlspecialchars($row['contact']) ?></td>
        <td><?= htmlspecialchars($row['mark_Dg']) ?></td>
        <td><?= htmlspecialchars($row['mark_Di']) ?></td>
        <td><?= htmlspecialchars($row['mark_12']) ?></td>
        <td><?= htmlspecialchars($row['mark_10']) ?></td>
      </tr>
    <?php endwhile; ?>
  </table>

</body>
</html>

<?php $conn->close(); ?>
