<?php
include('db_connect.php');
$conn->query("DELETE FROM shifts");
$conn->query("DELETE FROM payroll");
$conn->query("DELETE FROM employees");
echo "✅ Test data removed successfully.\n";
?>