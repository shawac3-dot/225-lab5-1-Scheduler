CREATE DATABASE IF NOT EXISTS scheduling_db;
USE scheduling_db;
CREATE TABLE employees (
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    position VARCHAR(50),
    hourly_rate DECIMAL(6,2) NOT NULL DEFAULT 15.00,
    overtime_rate DECIMAL(6,2) NOT NULL DEFAULT 22.50,
    hire_date DATE,
    status ENUM('Active','Inactive') DEFAULT 'Active'
);
CREATE TABLE shifts (
    shift_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT NOT NULL,
    shift_date DATE NOT NULL,
    clock_in DATETIME,
    clock_out DATETIME,
    hours_worked DECIMAL(5,2) DEFAULT 0,
    overtime_hours DECIMAL(5,2) DEFAULT 0,
    approved BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (emp_id) REFERENCES employees(emp_id) ON DELETE CASCADE
);
CREATE TABLE payroll (
    payroll_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_id INT NOT NULL,
    pay_period_start DATE NOT NULL,
    pay_period_end DATE NOT NULL,
    regular_hours DECIMAL(5,2) DEFAULT 0,
    overtime_hours DECIMAL(5,2) DEFAULT 0,
    gross_pay DECIMAL(8,2) DEFAULT 0,
    date_processed DATE DEFAULT (CURRENT_DATE),
    FOREIGN KEY (emp_id) REFERENCES employees(emp_id) ON DELETE CASCADE
);