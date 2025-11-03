# Lab 5.1 — Employee Scheduling System

This project is a simple **PHP + MySQL Employee Scheduling System** for Lab 5.1.  
It allows you to manage employees, track clock-ins/outs, and calculate weekly payroll automatically.

---

## 📂 Project Structure

```
lab5.1/
│
├── db_connect.php        # MySQL connection setup
├── index.php             # Main navigation page
├── add_employee.php      # Add employees to the system
├── manage_shifts.php     # Clock in / Clock out system
├── payroll_report.php    # Weekly payroll calculation
├── styles.css            # Basic styling
└── database.sql          # MySQL database schema
```

---

## ⚙️ Installation Instructions

### 1️⃣ Requirements
- PHP 8+  
- MySQL (e.g., XAMPP, WAMP, or MAMP)  
- phpMyAdmin (optional for database setup)

### 2️⃣ Database Setup
1. Open phpMyAdmin or your SQL console.  
2. Create the database using the included SQL file:  
   ```sql
   SOURCE database.sql;
   ```
   or manually copy and paste the SQL code from `database.sql`.

3. Make sure your MySQL user credentials match those in `db_connect.php`  
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "scheduling_db";
   ```

---

## ▶️ Running the App
1. Place the project folder inside your server’s web root (e.g. `htdocs/lab5.1/` for XAMPP).  
2. Start Apache and MySQL from your XAMPP Control Panel.  
3. Open your browser and go to:  
   ```
   http://localhost/lab5.1/
   ```

You can now:
- ➕ Add employees  
- 🕒 Clock in / Clock out  
- 💰 View weekly payroll reports  

---

## 🧩 Database Design (3NF)

**Entities:**
- **Employees(emp_id, first_name, last_name, position, hourly_rate, overtime_rate, hire_date, status)**  
- **Shifts(shift_id, emp_id, shift_date, clock_in, clock_out, hours_worked, overtime_hours, approved)**  
- **Payroll(payroll_id, emp_id, pay_period_start, pay_period_end, regular_hours, overtime_hours, gross_pay, date_processed)**

**Dependencies (3NF):**
- emp_id → first_name, last_name, position, hourly_rate, overtime_rate  
- shift_id → emp_id, shift_date, clock_in, clock_out, hours_worked  
- payroll_id → emp_id, pay_period_start, pay_period_end, gross_pay  

Each table depends on its primary key only (no partial or transitive dependencies).

---

## 💡 Future Features
- Admin login system  
- Automated payroll export (CSV/PDF)  
- Shift scheduling calendar view  
- Attendance & overtime analytics  

---

**Author:** Austin Shaw  
**Course:** CIS 225 — Lab 5.1  
**Topic:** Employee Shift Scheduling & Payroll Management
