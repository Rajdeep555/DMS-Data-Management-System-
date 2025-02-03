<?php
session_start();
include '../settings/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $employee_id = $_POST['employee_id'];
        $month_year = $_POST['month_year'];
        $gross_salary = $_POST['gross_salary'];
        $absent_days = $_POST['absent_days'];
        $hidden_month_year = $_POST['hidden_month_year'];

        $sql = "UPDATE salary_details 
                SET gross_salary = :gross_salary, absent_days = :absent_days, month_year = :hidden_month_year, updated_at = NOW() 
                WHERE id = :employee_id AND month_year = :month_year";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute([
            ':employee_id' => $employee_id,
            ':month_year' => $month_year,
            ':gross_salary' => $gross_salary,
            ':absent_days' => $absent_days,
            ':hidden_month_year' => $hidden_month_year
        ]);

        // Redirect with success parameter
        header("Location: index.php?module=Salaries&view=Update&success=true");
        exit;
    } catch (PDOException $e) {
        error_log('Database Error: ' . $e->getMessage());
        header('Location: index.php?module=Salaries&view=Update&error=1');
        exit;
    }
}
