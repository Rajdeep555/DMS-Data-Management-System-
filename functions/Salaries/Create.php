<link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet" />

<?php
// At the top of the file
error_log('Session data in Create.php: ' . print_r($_SESSION, true));

$table_name = 'salary_details';
$redirection_page = "index.php?module=Salaries&view=List";
$action_name = "module=Salaries&view=List";
$employee_id = $_GET['id'];

// For Displaying the table

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 50;
$offset = ($pageno - 1) * $no_of_records_per_page;

$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();

$total_rows = $sql->fetchColumn();
$total_pages = ceil($total_rows / $no_of_records_per_page);

$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['sid'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script type="text/javascript">';
    echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Salary details saved successfully"
    }).then((result) => {
        window.location.href = "index.php?module=Salaries&view=Select-Employee";
    });';
    echo '</script>';
} elseif (isset($_GET['eid'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script type="text/javascript">';
    echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Salary details updated successfully"
    }).then((result) => {
        window.location.href = "index.php?module=Salaries&view=Select-Employee";
    });';
    echo '</script>';
}

// In your session initialization file
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* margin: 20px; */
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px 5px 5px 5px;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
        }

        .footer {
            width: 100%;
        }

        .details,
        .salary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .salary-table {
            margin-top: 10px;
        }


        .details td,
        .salary-table td,
        .salary-table th {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .salary-table th {
            background-color: #f2f2f2;
            text-align: left;

        }

        .highlight {
            background-color: yellow;
        }

        .salary-table td:first-child {
            width: 19rem !important;
            text-align: left;
            font-weight: 400;
            font-family: 'Times New Roman', Times, serif;
            /* font-weight: bold; */
        }

        .salary-table td:nth-child(2) {
            text-align: center;
            font-weight: 400;
            font-family: 'Times New Roman', Times, serif;
        }

        .back-btn {
            background-color: #7366ff;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 0px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: rgba(115, 102, 255, 0.91);
        }

        .back-btn i {
            font-size: 18px;
        }

        input[type="number"] {
            border: 1px solid #ccc;
            border-radius: 0px;
            outline: none !important;
            box-shadow: none !important;
            padding: 5px 5px;
        }
    </style>
</head>

<body>
    <div class="container mb-5">
        <button onclick="goBack()" class="back-btn">
            <i class="ri-arrow-left-line"></i> Go Back
        </button>
        <div class="header">
            <b class="f-24 fw-bolder">MONSUT CHEM INDUSTRIES PVT LTD.</b><br>
            <b class="f-14 fw-bold font-none">V I P Road, Sixmile, Guwahati, Assam, India, Pin - 781022</b><br>
        </div>

        <span class="text-center d-block mt-3"><strong>Provision of Compensation</strong></span>
        <table class="details">
            <tr>
                <td>Name : <span class="fw-bold">
                        <?php
                        if (isset($_SESSION['salary_create_data']['employee_name'])) {
                            echo htmlspecialchars($_SESSION['salary_create_data']['employee_name']);
                        }
                        ?>
                    </span></td>
                <td>Emp No : <span class="fw-bold">
                        <?php
                        if (isset($_SESSION['salary_create_data']['employee_id'])) {
                            echo htmlspecialchars($_SESSION['salary_create_data']['employee_id']);
                        }
                        ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Designation : <span class="fw-bold">
                        <?php
                        if (isset($_SESSION['salary_create_data']['designation'])) {
                            echo htmlspecialchars($_SESSION['salary_create_data']['designation']);
                        }
                        ?>
                    </span>
                </td>
                <td><strong>Date of Join :</strong></td>
            </tr>
            <tr>
                <td>Function :</td>
                <td>Location :</td>
            </tr>
            <tr>
                <td class="fw-bold f-12" style="background-color:rgba(171, 193, 25, 0.81);">Number of Absent Days : &nbsp; &nbsp; <span class=""><input type="number" class="" style="width: 100px; display: inline-block; outline: none; border: 1px solid #ccc;" name="absent_days" id="absent_days" style="outline: none !important; box-shadow: none !important;"></span></td>
                <td class="fw-bold f-12">Month-Year : <span class="fw-bold">
                        <?php
                        if (isset($_SESSION['salary_create_data']['month']) && isset($_SESSION['salary_create_data']['year'])) {
                            $month = $_SESSION['salary_create_data']['month'];
                            $year = $_SESSION['salary_create_data']['year'];

                            $date = DateTime::createFromFormat('m-Y', $month . '-' . $year);
                            echo $date ? $date->format('M-Y') : '';
                        }
                        ?>
                    </span>
                </td>
            </tr>
        </table>

        <table class="salary-table">
            <tr>
                <th class="text-center"><strong class="text-decoration-underline">Details of Benefits / Components</strong></th>
                <th></th>
                <th>Per Month</th>
                <th>Per Annum</th>
            </tr>
            <tr>
                <td class="text-center f-12 "><strong class="text-decoration-underline">Salary Components</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Basic Pay</td>
                <td></td>
                <td id="basic_pay_monthly">0.00</td>
                <td id="basic_pay_annual">0.00</td>
            </tr>
            <tr>
                <td>House Rent Allowance ( 45 % )</td>
                <td></td>
                <td id="hra_monthly">0.00</td>
                <td id="hra_annual">0.00</td>
            </tr>
            <tr>
                <td>Children Education Allowance (10 %)</td>
                <td></td>
                <td id="cea_monthly">0.00</td>
                <td id="cea_annual">0.00</td>
            </tr>
            <tr>
                <td>Special Allowance ( 15 % )</td>
                <td></td>
                <td id="special_allowance_monthly">0.00</td>
                <td id="special_allowance_annual">0.00</td>
            </tr>
            <tr>
                <td><strong>Gross Salary</strong></td>
                <td>(A)</td>
                <td class="fw-bold" style="background-color: rgba(171, 193, 25, 0.81);">
                    <input type="number"
                        name="gross_salary"
                        id="gross_salary"
                        value="0.00"
                        onchange="calculateSalaryComponents(this.value)"
                        style="width: 100px; padding: 5px; border: 1px solid #ccc; outline: none;">
                </td>
                <td class="fw-bold" id="gross_salary_annual">0.00</td>
            </tr>
            <tr>
                <td class="text-center f-12 "><strong class="text-decoration-underline">Deductions</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Professional Tax</td>
                <td></td>
                <td id="professional_tax_monthly">0.00</td>
                <td id="professional_tax_annual">0.00</td>
            </tr>
            <tr>
                <td>Provident Fund - Employee Contribution</td>
                <td></td>
                <td id="pf_employee_monthly">0.00</td>
                <td id="pf_employee_annual">0.00</td>
            </tr>
            <tr>
                <td>Tax Deducted at Source (TDS) - New Tax Regime</td>
                <td></td>
                <td id="tds_monthly">0.00</td>
                <td id="tds_annual">0.00</td>
            </tr>
            <tr>
                <td class="text-center f-12 "><strong>Total</strong></td>
                <td>(B)</td>
                <td class="fw-bold" id="total_deductions_monthly">0.00</td>
                <td class="fw-bold" id="total_deductions_annual">0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class=""><strong>Net Payable ( A - B )</strong></td>
                <td>(C)</td>
                <td class="fw-bold" id="net_payable_monthly">0.00</td>
                <td class="fw-bold" id="net_payable_annual">0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><strong>Annual Benefits</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Leave Travel Assistance (LTA)*</td>
                <td></td>
                <td id="lta_monthly">0.00</td>
                <td id="lta_annual">0.00</td>
            </tr>
            <tr>
                <td>Annual Performance Pay ****</td>
                <td></td>
                <td id="annual_performance_monthly">0.00</td>
                <td id="annual_performance_annual">0.00</td>
            </tr>
            <tr>
                <td class="text-center f-12 "><strong>Total</strong></td>
                <td>(D)</td>
                <td class="fw-bold" id="total_annual_benefits_monthly">0.00</td>
                <td class="fw-bold" id="total_annual_benefits_annual">0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="fw-bold">Retiral Benefits/Contribution</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>PF Contribution** - Employer Contribution</td>
                <td></td>
                <td id="pf_employer_monthly">0.00</td>
                <td id="pf_employer_annual">0.00</td>
            </tr>
            <tr>
                <td>Gratuity***</td>
                <td></td>
                <td id="gratuity_monthly">0.00</td>
                <td id="gratuity_annual">0.00</td>
            </tr>
            <tr>
                <td class="text-center f-12 "><strong>Total</strong></td>
                <td>(E)</td>
                <td class="fw-bold" id="total_retiral_monthly">0.00</td>
                <td class="fw-bold" id="total_retiral_annual">0.00</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="fw-bold">Medical Benefits/Insurance</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Medical Insurance Premium</td>
                <td></td>
                <td id="medical_insurance_monthly">0.00</td>
                <td id="medical_insurance_annual">0.00</td>
            </tr>
            <tr>
                <td class="text-center f-12 "><strong>Total</strong></td>
                <td>(F)</td>
                <td class="fw-bold" id="total_medical_monthly">0.00</td>
                <td class="fw-bold" id="total_medical_annual">0.00</td>
            </tr>
            <tr>
                <td class="fw-bold">Fixed CTC ( A + D + E + F )</td>
                <td>(G)</td>
                <td class="fw-bold" id="fixed_ctc_monthly">0.00</td>
                <td class="fw-bold" id="fixed_ctc_annual">0.00</td>
            </tr>
            <tfoot>
                <tr>
                    <td colspan="4" class="f-12 fw-bold">
                        *Payment of LTA will be based on the Company's Policy / Schemes<br>
                        **Provident Fund shall be as per the Employees' Provident Funds & Miscellaneous Provisions Act, 1952<br>
                        ***Gratuity shall be paid as per the Payment of Gratuity Act, 1972<br>
                        <span class="fw-bolder f-14">****Performance Pay is based on Company's overall performance and employee's individual performance</span> <br>
                        Monthly / Annual figures shown above are rounded off to the nearest Rupee for calculation purposes
                    </td>
                </tr>
            </tfoot>
        </table>

        <form id="salaryForm" method="POST" action="index.php?module=Salaries&view=save_salary">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($_SESSION['salary_create_data']['employee_id']); ?>">
            <input type="hidden" name="month_year" value="<?php echo htmlspecialchars($_SESSION['salary_create_data']['month'] . '-' . $_SESSION['salary_create_data']['year']); ?>">
            <input type="hidden" name="gross_salary" id="hidden_gross_salary">
            <input type="hidden" name="absent_days" id="hidden_absent_days">

            <button type="submit" class="btn btn-primary mt-2 float-end w-25" id="submitBtn">
                <span class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status" aria-hidden="true"></span>
                <span id="submitText">Submit</span>
            </button>
        </form>
    </div>


    <script>
        function goBack() {
            window.history.back();
        }

        function calculateSalaryComponents(grossSalary) {
            // Get absent days
            const absentDays = parseFloat(document.getElementById('absent_days').value) || 0;

            // Calculate per day salary and deduction
            const perDaySalary = grossSalary / 30;
            const absentDeduction = perDaySalary * absentDays;

            // Adjust gross salary after absence deduction
            const adjustedGrossSalary = grossSalary - absentDeduction;

            // Rest of the calculations will use adjustedGrossSalary instead of grossSalary
            const basicPay = adjustedGrossSalary * 0.30;
            const hra = adjustedGrossSalary * 0.45;
            const cea = adjustedGrossSalary * 0.10;
            const specialAllowance = adjustedGrossSalary * 0.15;

            // Deductions Calculations
            const professionalTax = 208.00; // Fixed amount
            const pfEmployee = adjustedGrossSalary * 0.036; // 3.6% of adjusted gross
            const tds = 0; // No TDS as per requirement

            // Calculate total deductions
            const totalDeductions = professionalTax + pfEmployee + tds;

            // Calculate Net Payable (A - B)
            const netPayable = adjustedGrossSalary - totalDeductions;

            // Annual values
            const annualGrossSalary = adjustedGrossSalary * 12;
            const annualBasicPay = basicPay * 12;
            const annualHra = hra * 12;
            const annualCea = cea * 12;
            const annualSpecialAllowance = specialAllowance * 12;
            const annualProfessionalTax = professionalTax * 12;
            const annualPfEmployee = pfEmployee * 12;
            const annualTds = tds * 12;
            const annualTotalDeductions = totalDeductions * 12;
            const annualNetPayable = netPayable * 12;

            // Update Basic Components
            document.getElementById('basic_pay_monthly').textContent = formatCurrency(basicPay);
            document.getElementById('hra_monthly').textContent = formatCurrency(hra);
            document.getElementById('cea_monthly').textContent = formatCurrency(cea);
            document.getElementById('special_allowance_monthly').textContent = formatCurrency(specialAllowance);

            document.getElementById('basic_pay_annual').textContent = formatCurrency(annualBasicPay);
            document.getElementById('hra_annual').textContent = formatCurrency(annualHra);
            document.getElementById('cea_annual').textContent = formatCurrency(annualCea);
            document.getElementById('special_allowance_annual').textContent = formatCurrency(annualSpecialAllowance);
            document.getElementById('gross_salary_annual').textContent = formatCurrency(annualGrossSalary);

            // Update Deductions
            document.getElementById('professional_tax_monthly').textContent = formatCurrency(professionalTax);
            document.getElementById('pf_employee_monthly').textContent = formatCurrency(pfEmployee);
            document.getElementById('tds_monthly').textContent = formatCurrency(tds);
            document.getElementById('total_deductions_monthly').textContent = formatCurrency(totalDeductions);
            document.getElementById('net_payable_monthly').textContent = formatCurrency(netPayable);

            document.getElementById('professional_tax_annual').textContent = formatCurrency(annualProfessionalTax);
            document.getElementById('pf_employee_annual').textContent = formatCurrency(annualPfEmployee);
            document.getElementById('tds_annual').textContent = formatCurrency(annualTds);
            document.getElementById('total_deductions_annual').textContent = formatCurrency(annualTotalDeductions);
            document.getElementById('net_payable_annual').textContent = formatCurrency(annualNetPayable);

            // Annual Benefits Calculations
            const lta = adjustedGrossSalary * 0.025; // 2.50% of adjusted gross
            const annualPerformancePay = adjustedGrossSalary * 0.12; // 12% of adjusted gross
            const totalAnnualBenefits = lta + annualPerformancePay;

            // Retiral Benefits Calculations
            const pfEmployer = adjustedGrossSalary * 0.036; // 3.60% of adjusted gross (same as employee contribution)
            const gratuity = adjustedGrossSalary * 0.0144; // 1.44% of adjusted gross
            const totalRetiral = pfEmployer + gratuity;

            // Medical Benefits Calculations
            const medicalInsurance = adjustedGrossSalary * 0.012; // 1.20% of adjusted gross

            // Fixed CTC Calculation (A + D + E + F)
            const fixedCTC = adjustedGrossSalary + totalAnnualBenefits + totalRetiral + medicalInsurance;

            // Annual values calculations
            const annualLta = lta * 12;
            const annualPerformancePayYearly = annualPerformancePay * 12;
            const annualTotalBenefits = totalAnnualBenefits * 12;
            const annualPfEmployer = pfEmployer * 12;
            const annualGratuity = gratuity * 12;
            const annualTotalRetiral = totalRetiral * 12;
            const annualMedicalInsurance = medicalInsurance * 12;
            const annualFixedCTC = fixedCTC * 12;

            // Update Annual Benefits
            document.getElementById('lta_monthly').textContent = formatCurrency(lta);
            document.getElementById('annual_performance_monthly').textContent = formatCurrency(annualPerformancePay);
            document.getElementById('total_annual_benefits_monthly').textContent = formatCurrency(totalAnnualBenefits);

            document.getElementById('lta_annual').textContent = formatCurrency(annualLta);
            document.getElementById('annual_performance_annual').textContent = formatCurrency(annualPerformancePayYearly);
            document.getElementById('total_annual_benefits_annual').textContent = formatCurrency(annualTotalBenefits);

            // Update Retiral Benefits
            document.getElementById('pf_employer_monthly').textContent = formatCurrency(pfEmployer);
            document.getElementById('gratuity_monthly').textContent = formatCurrency(gratuity);
            document.getElementById('total_retiral_monthly').textContent = formatCurrency(totalRetiral);

            document.getElementById('pf_employer_annual').textContent = formatCurrency(annualPfEmployer);
            document.getElementById('gratuity_annual').textContent = formatCurrency(annualGratuity);
            document.getElementById('total_retiral_annual').textContent = formatCurrency(annualTotalRetiral);

            // Update Medical Benefits
            document.getElementById('medical_insurance_monthly').textContent = formatCurrency(medicalInsurance);
            document.getElementById('total_medical_monthly').textContent = formatCurrency(medicalInsurance);

            document.getElementById('medical_insurance_annual').textContent = formatCurrency(annualMedicalInsurance);
            document.getElementById('total_medical_annual').textContent = formatCurrency(annualMedicalInsurance);

            // Update Fixed CTC
            document.getElementById('fixed_ctc_monthly').textContent = formatCurrency(fixedCTC);
            document.getElementById('fixed_ctc_annual').textContent = formatCurrency(annualFixedCTC);
        }

        function formatCurrency(value) {
            return value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Add event listener for absent days input
        document.getElementById('absent_days').addEventListener('input', function() {
            const grossSalary = parseFloat(document.getElementById('gross_salary').value) || 0;
            calculateSalaryComponents(grossSalary);
        });

        document.getElementById('salaryForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Basic validation
            const grossSalary = document.getElementById('gross_salary').value;
            if (!grossSalary || grossSalary <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a valid salary amount'
                });
                return;
            }

            // Update hidden fields with current values
            document.getElementById('hidden_gross_salary').value = document.getElementById('gross_salary').value;
            document.getElementById('hidden_absent_days').value = document.getElementById('absent_days').value;

            // Show loader
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('submitSpinner');
            const submitText = document.getElementById('submitText');

            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            submitText.textContent = 'Processing...';

            // Wait for minimum 3 seconds before submitting
            setTimeout(() => {
                this.submit();
            }, 3000);
        });
    </script>
</body>

</html>