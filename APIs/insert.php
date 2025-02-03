<?php
require_once('../settings/database.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_name = $_POST['field1'] ?? null;
    $emp_code = $_POST['field2'] ?? null;
    $emp_netpay = $_POST['net_pay'] ?? null;

    // Check for required fields
    if (empty($emp_name) || empty($emp_code) || empty($emp_netpay)) {
        echo 'Error: Fields (Employee Name, Code, and Net Pay) are missing.';
        exit;
    }

    // Retrieve other fields
    $date_s = $_POST['date_s'] ?? null;
    $emp_payable_days = $_POST['field8'] ?? null;
    $emp_loss_paydays = $_POST['field9'] ?? null;
    $emp_basic_salary = $_POST['field17'] ?? null;
    $emp_home_allowance = $_POST['field19'] ?? null;
    $emp_edu_allowance = $_POST['field21'] ?? null;
    $emp_m_allowance = $_POST['field23'] ?? null;
    $emp_s_allowance = $_POST['field25'] ?? null;
    $emp_vm_allowance = $_POST['field27'] ?? null;
    $emp_subtotal = $_POST['sub_tot'] ?? null;
    $emp_p_tax = $_POST['field29'] ?? null;
    $emp_pf = $_POST['field30'] ?? null;
    $emp_esi = $_POST['field31'] ?? null;
    $emp_tds = $_POST['field32'] ?? null;
    $emp_d_subtotal = $_POST['field34'] ?? null;
    $emp_courfax = $_POST['field36'] ?? null;
    $emp_da = $_POST['field38'] ?? null;
    $emp_fare = $_POST['field40'] ?? null;
    $emp_tel = $_POST['field42'] ?? null;
    $emp_gross_pay = $_POST['field44'] ?? null;
    $status = 'active';

    try {
        // Prepare the SQL insert statement
        $insert = "INSERT INTO `salary_slip`(`s_employee_name`, `s_emp_code`, `s_emp_date`, `s_payable_days`, `s_loss_paydays`, `s_basic_salary`, `s_h_allowance`, `s_e_allowance`, `s_m_allowance`, `s_s_allowance`, `s_vm_allowance`, `s_subtotal`, `s_p_tax`, `s_pf`, `s_esi`, `s_tds`, `s_d_subtotal`, `s_courfax`, `s_da`, `s_fare`, `s_tel`, `s_gross_pay`, `s_net_pay`, `status`)
                    VALUES (:emp_name, :emp_code, :date_s, :emp_payable_days, :emp_loss_paydays, :emp_basic_salary, :emp_home_allowance, :emp_edu_allowance, :emp_m_allowance, :emp_s_allowance, :emp_vm_allowance, :emp_subtotal, :emp_p_tax, :emp_pf, :emp_esi, :emp_tds, :emp_d_subtotal, :emp_courfax, :emp_da, :emp_fare, :emp_tel, :emp_gross_pay, :emp_netpay, :status)";
        
        // Execute the statement
        $stmt = $dbconn->prepare($insert);
        $stmt->bindParam(':emp_name', $emp_name);
        $stmt->bindParam(':emp_code', $emp_code);
        $stmt->bindParam(':date_s', $date_s);
        $stmt->bindParam(':emp_payable_days', $emp_payable_days);
        $stmt->bindParam(':emp_loss_paydays', $emp_loss_paydays);
        $stmt->bindParam(':emp_basic_salary', $emp_basic_salary);
        $stmt->bindParam(':emp_home_allowance', $emp_home_allowance);
        $stmt->bindParam(':emp_edu_allowance', $emp_edu_allowance);
        $stmt->bindParam(':emp_m_allowance', $emp_m_allowance);
        $stmt->bindParam(':emp_s_allowance', $emp_s_allowance);
        $stmt->bindParam(':emp_vm_allowance', $emp_vm_allowance);
        $stmt->bindParam(':emp_subtotal', $emp_subtotal);
        $stmt->bindParam(':emp_p_tax', $emp_p_tax);
        $stmt->bindParam(':emp_pf', $emp_pf);
        $stmt->bindParam(':emp_esi', $emp_esi);
        $stmt->bindParam(':emp_tds', $emp_tds);
        $stmt->bindParam(':emp_d_subtotal', $emp_d_subtotal);
        $stmt->bindParam(':emp_courfax', $emp_courfax);
        $stmt->bindParam(':emp_da', $emp_da);
        $stmt->bindParam(':emp_fare', $emp_fare);
        $stmt->bindParam(':emp_tel', $emp_tel);
        $stmt->bindParam(':emp_gross_pay', $emp_gross_pay);
        $stmt->bindParam(':emp_netpay', $emp_netpay);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        // Return success message
        echo 'Record inserted successfully!';
    } catch (PDOException $e) {
        // Handle error
        echo 'Error inserting record: ' . $e->getMessage();
    }
} else {
    // Handle incorrect request method
    echo 'Invalid request method.';
}
?>
