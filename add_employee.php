<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Add Employee</h2>
<form method="post" action="">
    <label>First Name:</label><input type="text" name="first_name" required><br>
    <label>Last Name:</label><input type="text" name="last_name" required><br>
    <label>Position:</label><input type="text" name="position"><br>
    <label>Hourly Rate:</label><input type="number" step="0.01" name="hourly_rate" required><br>
    <label>Overtime Rate:</label><input type="number" step="0.01" name="overtime_rate" required><br>
    <label>Hire Date:</label><input type="date" name="hire_date"><br>
    <input type="submit" name="submit" value="Add Employee">
</form>
<?php
if (isset($_POST['submit'])) {
    $sql = "INSERT INTO employees (first_name, last_name, position, hourly_rate, overtime_rate, hire_date)
            VALUES ('{$_POST['first_name']}', '{$_POST['last_name']}', '{$_POST['position']}', 
                    {$_POST['hourly_rate']}, {$_POST['overtime_rate']}, '{$_POST['hire_date']}')";
    if ($conn->query($sql)) {
        echo "<p>✅ Employee added successfully!</p>";
    } else {
        echo "<p>❌ Error: " . $conn->error . "</p>";
    }
}
?>
</body>
</html>