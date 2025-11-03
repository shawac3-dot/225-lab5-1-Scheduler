<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Clock In/Out</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Clock In / Clock Out</h2>
<table border="1" cellpadding="6">
<tr>
    <th>Employee</th>
    <th>Position</th>
    <th>Status</th>
    <th>Action</th>
</tr>
<?php
$dateToday = date('Y-m-d');
$result = $conn->query("SELECT * FROM employees WHERE status='Active'");
while ($row = $result->fetch_assoc()) {
    $emp_id = $row['emp_id'];
    $check = $conn->query("SELECT * FROM shifts WHERE emp_id=$emp_id AND shift_date='$dateToday' ORDER BY shift_id DESC LIMIT 1");
    $shift = $check->fetch_assoc();
    if (!$shift) {
        $status = "Not Clocked In";
        $action = "<form method='post'><input type='hidden' name='emp_id' value='$emp_id'><input type='submit' name='clock_in' value='Clock In'></form>";
    } elseif ($shift['clock_in'] && !$shift['clock_out']) {
        $status = "Clocked In at " . date('g:i A', strtotime($shift['clock_in']));
        $action = "<form method='post'><input type='hidden' name='emp_id' value='$emp_id'><input type='submit' name='clock_out' value='Clock Out'></form>";
    } else {
        $status = "Completed Shift (" . round($shift['hours_worked'], 2) . " hrs)";
        $action = "—";
    }
    echo "<tr><td>{$row['first_name']} {$row['last_name']}</td><td>{$row['position']}</td><td>$status</td><td>$action</td></tr>";
}
if (isset($_POST['clock_in'])) {
    $emp_id = $_POST['emp_id'];
    $now = date('Y-m-d H:i:s');
    $conn->query("INSERT INTO shifts (emp_id, shift_date, clock_in) VALUES ($emp_id, '$dateToday', '$now')");
    echo "<p>✅ Employee clocked in at $now</p>";
}
if (isset($_POST['clock_out'])) {
    $emp_id = $_POST['emp_id'];
    $now = date('Y-m-d H:i:s');
    $shift = $conn->query("SELECT * FROM shifts WHERE emp_id=$emp_id AND shift_date='$dateToday' ORDER BY shift_id DESC LIMIT 1")->fetch_assoc();
    if ($shift) {
        $in = strtotime($shift['clock_in']);
        $out = strtotime($now);
        $hours = round(($out - $in) / 3600, 2);
        $conn->query("UPDATE shifts SET clock_out='$now', hours_worked=$hours WHERE shift_id={$shift['shift_id']}");
        echo "<p>✅ Clocked out. Total hours: $hours</p>";
    }
}
?>
</table>
</body>
</html>