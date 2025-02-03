<?php
require_once('../settings/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = isset($_POST['month']) ? $_POST['month'] : null;
    $year = isset($_POST['year']) ? $_POST['year'] : null;
    $userId = isset($_POST['userID']) ? $_POST['userID'] : null;

    $date = $month . '_' . $year;

    $getUser = "SELECT * FROM `users` WHERE id = :userId AND status = 'Active'";
    $stmt = $dbconn->prepare($getUser);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);

    if ($res !== false) {
        $userUnique = $res->user_unique_id;
        $business_unit = $res->user_business_unit;
        // $cost_center = $res->user_cost_center;
        $bank = $res->user_bank_name;
        $accountNo = $res->user_bank_acc_no;
        $pf = $res->user_pf_no;
        $uan = $res->user_uan_no;
        $user_role = $res->user_role;


        $getAllData = "SELECT * FROM `salary_slip` WHERE s_emp_code = :userUnique AND status = 'active' AND s_emp_date='$date'";
        $stmtSalary = $dbconn->prepare($getAllData);
        $stmtSalary->bindParam(':userUnique', $userUnique, PDO::PARAM_STR);
        $stmtSalary->execute();

        $salarySlips = $stmtSalary->fetchAll(PDO::FETCH_OBJ);

        if (count($salarySlips) > 0) {
            $styles = '
            <style>
                .table-responsive {
            overflow-x: auto;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
            transition: background-color 0.3s ease-in-out;
        }
        /* Section headers */
        .section-header {
            background-color: #f6dd98;
            font-weight: bold;
        }
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animated-table {
            animation: fadeInUp 1s ease-in-out;
        }

           table thead tr{
            border:1px soild #0c0d0f;
        }
            </style>';

            foreach ($salarySlips as $slip) {
                echo $styles;
                echo '
               <div class="payslip-container mt-5 mb-5" style="width:96%;">

               <div style="width:150px; height:150px; margin:auto;">
               <img style="height:100%; width:100%; object-fit:cover;" src="./lgo.jpg">
               </div>

    <h2 class="text-center mb-4">Salary Slip - ' . $date . '</h2>

    <div class="table-responsive">
        <table class="table table-bordered animated-table">
            <thead>
                <!-- Main Headings -->
                <tr class="section-header">
                    <th colspan="3">Pay Slip: ' . $date . '</th>
                    <th colspan="1">Payable days: ' . $slip->s_payable_days . '</th>
                    <th colspan="2">Loss of pay days: ' . $slip->s_loss_paydays . '</th>
                </tr>
            </thead>

            <tbody>
                <!-- Employee Information Section -->
                
                <tr style="">
                    <td>Employee Name</td>
                    <td colspan="2">' . $slip->s_employee_name . ' (' . $slip->s_emp_code  . ')</td>
                    <td>Bank Name</td>
                    <td colspan="2">' . $bank . '</td>
                </tr>
                <tr>
                    <td>Employee Code</td>
                    <td colspan="2">' . $userUnique . '</td>
                    <td>Bank Account Number</td>
                    <td colspan="2">' . $accountNo . '</td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td colspan="2">SALES</td>
                    <td>PF No.</td>
                    <td colspan="2">' . $pf . '</td>
                </tr>
                <tr>
                    <td>Designation</td>
                    <td colspan="2">' . $user_role . '</td>
                    <td>UAN No.</td>
                    <td colspan="2">' . $uan . '</td>
                </tr>
                <tr>
                    <td>Business Unit</td>
                    <td colspan="2">' . $business_unit . '</td>
                    <td>ESI No.</td>
                    <td colspan="2">' . $res->user_esi_no . '</td>
                </tr>
                <tr>
                    <td>Cost Center</td>
                    <td colspan="2">' . $res->user_cost_center . '</td>
                    <td>PAN No.</td>
                    <td colspan="2">' . $res->user_pan_no . '</td>
                </tr>
                <tr>
                    <td>Date of Join</td>
                    <td colspan="2">' . $res->user_date_of_join . '</td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>

        <div class="table-responsive">
            <table class="table table-bordered animated-table">
                <!-- Earnings and Deductions Headers -->
                <thead>
                    <tr class="section-header">
                        <th colspan="3">Earnings</th>
                        <th colspan="2">Deductions</th>
                    </tr>
                    <tr>
                        <!-- Subheaders under Earnings -->
                        <th>Component</th>
                        <th>Actual Amount</th>
                        <th>Paid Amount</th>
                        <!-- Subheaders under Deductions -->
                        <th>Component</th>
                        <th>Paid Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Earnings and Deductions Rows -->
                    <tr>
                        <!-- Earnings -->
                        <td>Consolidated Basic Salary</td>
                        <td>₹' . $slip->s_basic_salary . '</td>
                        <td> ₹' . $slip->s_basic_salary . '</td>
                        <!-- Deductions -->
                        <td>Professional Tax</td>
                        <td>₹' . $slip->s_p_tax . '</td>
                    </tr>
                    <tr>
                        <td>House Rent Allowance</td>
                        <td>₹' . $slip->s_h_allowance . '</td>
                        <td>₹' . $slip->s_h_allowance . '</td>
                        <td>PF</td>
                        <td>₹' . $slip->s_pf . '</td>
                    </tr>
                    <tr>
                        <td>Education Allowance</td>
                        <td>₹' . $slip->s_e_allowance . '</td>
                        <td>₹' . $slip->s_e_allowance . '</td>
                        <td>ESI</td>
                        <td>₹' . $slip->s_esi . '</td>
                        
                    </tr>
                    <tr>
                        <td>Medical Allowance</td>
                        <td>₹' . $slip->s_m_allowance . '</td>
                        <td>₹' . $slip->s_m_allowance . '</td>
                        <td>TDS</td>
                        <td>₹3,178</td>
                    </tr>
                    <tr>
                        <td>Conveyance Allowance</td>
                        <td>₹0</td>
                        <td>₹0</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Special Allowance</td>
                        <td>₹' . $slip->s_s_allowance . '</td>
                        <td>₹' . $slip->s_s_allowance . '</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Vehicle Maintenance Allowance</td>
                        <td>₹' . $slip->s_vm_allowance . '</td>
                        <td>₹' . $slip->s_vm_allowance . '</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>Sub Total</strong></td>
                        <td style="text-align: right;"><strong>₹' . $slip->s_subtotal . '</strong></td>
                        <td style="text-align: right;"><strong>₹' . $slip->s_subtotal . '</strong></td>
                        <td style="text-align: right;"><strong>Sub Total</strong></td>
                        <td style="text-align: right;"><strong>₹' . $slip->s_d_subtotal . '</strong></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 20px;">Others</td>
                        <td></td>
                        <td ></td>
                        <td style="font-weight: bold; font-size: 20px;">Others</td>
                        <td ></td>
                    </tr>
                    <tr>
                        <td>COURFAX</td>
                        <td>₹' . $slip->s_courfax . '</td>
                        <td>₹' . $slip->s_courfax . '</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>DA </td>
                        <td>₹' . $slip->s_da . '</td>
                        <td>₹' . $slip->s_da . '</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>FARE</td>
                        <td>₹' . $slip->s_fare . '</td>
                        <td>₹' . $slip->s_fare . '</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Incentive</td>
                        <td>₹' . $slip->s_tell . '</td>
                        <td>₹' . $slip->s_tell . '</td>
                        <td></td>
                        <td></td>
                    </tr>
                   
    
                    <!-- Totals for Earnings and Deductions -->
                    <tr class="sub-header">
                        <td style="text-align: right;"><strong>Sub Total</strong></td>
                        <td><strong>0</strong></td>
                        <td><strong>₹55,629</strong></td>
                        <td style="text-align: right;"><strong>Sub Total</strong></td>
                        <td><strong>₹0</strong></td>
                    </tr>
                    <tr class="sub-header">
                        <td style="text-align: right;"><strong>Gross Pay</strong></td>
                        <td><strong>₹' . $slip->s_net_pay . '</strong></td>
                        <td><strong>₹' . $slip->s_net_pay . '</strong></td>
                        <td style="text-align: right;"><strong>Gross Deductions</strong></td>
                        <td><strong>₹' . $slip->s_d_subtotal . '</strong></td>
                    </tr>
    
                    <!-- Net Pay Section -->
                    <tr class="section-header">
                        
                    </tr>
                    <tr class="table-success">
                        <td colspan="3" style="text-align: right;"><strong>Net Pay</strong></td>
                        <td colspan="2"><strong>₹' . $slip->s_net_pay . '</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
              
                ';
            }
        } else {
            echo '<div class="alert alert-warning">No salary slips found for this month.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">User not found or inactive.</div>';
    }
}
