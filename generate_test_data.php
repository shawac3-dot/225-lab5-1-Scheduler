<?php
include('db_connect.php');
$employees = [['John','Smith','Plumber',20.00,30.00],['Mary','Jones','Apprentice',15.00,22.50],['Alice','Brown','Technician',18.00,27.00]];
foreach ($employees as $emp) {
    $stmt = $conn->prepare("INSERT INTO employees (first_name,last_name,position,hourly_rate,overtime_rate,status,hire_date) VALUES (?,?,?,?,?,'Active',CURDATE())");
    $stmt->bind_param("ssdd",$emp[0],$emp[1],$emp[2],$emp[3],$emp[4]);
    $stmt->execute();
}
$emp_ids = [];
$res = $conn->query("SELECT emp_id FROM employees");
while($row=$res->fetch_assoc()){$emp_ids[]=$row['emp_id'];}
for($i=0;$i<7;$i++){
    $shift_date=date('Y-m-d',strtotime("-$i days"));
    foreach($emp_ids as $emp_id){
        $clock_in_hour=rand(7,9);
        $clock_out_hour=$clock_in_hour+rand(6,9);
        $clock_in="$shift_date $clock_in_hour:00:00";
        $clock_out="$shift_date $clock_out_hour:00:00";
        $hours_worked=$clock_out_hour-$clock_in_hour;
        $overtime=max(0,$hours_worked-8);
        $stmt=$conn->prepare("INSERT INTO shifts (emp_id, shift_date, clock_in, clock_out, hours_worked, overtime_hours, approved) VALUES (?,?,?,?,?,?,1)");
        $stmt->bind_param("issddi",$emp_id,$shift_date,$clock_in,$clock_out,$hours_worked,$overtime);
        $stmt->execute();
    }
}
echo "✅ Test data generated successfully.\n";
?>