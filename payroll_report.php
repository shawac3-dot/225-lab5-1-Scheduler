<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Payroll Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Weekly Payroll Report</h2>
<form method="get">
    <label>Week Ending:</label>
    <input type="date" name="week_end" value="<?php echo isset($_GET['week_end']) ? $_GET['week_end'] : date('Y-m-d'); ?>">
    <input type="submit" value="View Payroll">
</form>
<?php
$weekEnd = isset($_GET['week_end']) ? $_GET['week_end'] : date('Y-m-d');
$weekStart = date('Y-m-d', strtotime($weekEnd . ' -6 days'));
echo "<h3>Payroll for $weekStart → $weekEnd</h3>";
$sql = "
    SELECT e.emp_id, e.first_name, e.last_name, e.hourly_rate, e.overtime_rate, SUM(s.hours_worked) AS total_hours
    FROM employees e
    LEFT JOIN shifts s ON e.emp_id = s.emp_id AND s.shift_date BETWEEN '$weekStart' AND '$weekEnd'
    WHERE e.status = 'Active'
    GROUP BY e.emp_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='6'><tr><th>Employee</th><th>Regular Hours</th><th>Overtime Hours</th><th>Hourly Rate</th><th>Overtime Rate</th><th>Gross Pay</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $totalHours = $row['total_hours'] ?? 0;
        $regular = min($totalHours, 40);
        $overtime = max(0, $totalHours - 40);
        $gross = ($regular * $row['hourly_rate']) + ($overtime * $row['overtime_rate']);
        echo "<tr><td>{$row['first_name']} {$row['last_name']}</td><td>{$regular}</td><td>{$overtime}</td><td>\${$row['hourly_rate']}</td><td>\${$row['overtime_rate']}</td><td><b>$" . number_format($gross, 2) . "</b></td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No payroll data found.</p>";
}
?>
</body>
</html>