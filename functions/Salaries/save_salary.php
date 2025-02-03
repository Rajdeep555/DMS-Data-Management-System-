<?php
session_start();
include '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $employee_id = $_POST['employee_id'];
        $month_year = $_POST['month_year'];
        $gross_salary = $_POST['gross_salary'];
        $absent_days = $_POST['absent_days'];

        $sql = "INSERT INTO salary_details (employee_id, month_year, gross_salary, absent_days, status, created_at) 
                VALUES (:employee_id, :month_year, :gross_salary, :absent_days, 'Active', NOW())";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute([
            ':employee_id' => $employee_id,
            ':month_year' => $month_year,
            ':gross_salary' => $gross_salary,
            ':absent_days' => $absent_days
        ]);

        header('Location: index.php?module=Salaries&view=Create&sid=1');
        exit;
    } catch (PDOException $e) {
        error_log('Database Error: ' . $e->getMessage());
        header('Location: index.php?module=Salaries&view=Create&error=1');
        exit;
    }
}
