<link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet" />

<?php
// At the top of the file
error_log('Session data in Create.php: ' . print_r($_SESSION, true));

$table_name = 'salary_details';
$redirection_page = "index.php?module=Salaries&view=List";
$action_name = "module=Salaries&view=List";
$employee_id = $_GET['id'];

// Add this query to get salary details
$salary_query = "SELECT * FROM `$table_name` WHERE id = :employee_id AND status = 'Active' ORDER BY id DESC LIMIT 1";
$stmt = $dbconn->prepare($salary_query);
$stmt->bindParam(':employee_id', $employee_id);
$stmt->execute();
$salary_details = $stmt->fetch(PDO::FETCH_ASSOC);
$gross_salary = $salary_details['gross_salary'] ?? 0;

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

// Add this at the top of the file, after the PHP opening tag
$show_download_overlay = isset($_GET['download']) && $_GET['download'] === 'true';

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
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px 5px 5px 5px;
        }

        .header {
            text-align: center;
            font-weight: bold;
        }

        .header b.f-24 {
            font-size: 18px;
            /* Reduced from 24px */
        }

        .header b.f-14 {
            font-size: 12px;
            /* Reduced from 14px */
        }

        .details,
        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            /* Reduced margin */
        }

        .details td,
        .salary-table td,
        .salary-table th {
            border: 1px solid #000;
            padding: 4px;
            /* Reduced padding */
            font-size: 11px;
            /* Smaller font size */
            line-height: 1.2;
            /* Reduced line height */
        }

        .salary-table th {
            background-color: #f2f2f2;
            text-align: left;
            font-size: 11px;
            /* Smaller font size */
        }

        .salary-table td:first-child {
            width: 16rem !important;
            /* Reduced width */
            text-align: left;
            font-weight: 400;
            font-family: 'Times New Roman', Times, serif;
        }

        .salary-table td:nth-child(2) {
            width: 40px;
            /* Fixed width for second column */
            text-align: center;
        }

        .salary-table td:nth-child(3),
        .salary-table td:nth-child(4) {
            width: 100px;
            /* Fixed width for amount columns */
            text-align: right;
            padding-right: 8px;
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
            margin-bottom: 10px;
            /* Reduced margin */
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

        /* Add these new styles */
        .download-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .download-message {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .download-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #7366ff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Specific adjustments for PDF generation */
        @media print {
            .container {
                padding: 10px 2px 2px 2px;
                border: none;
            }

            .salary-table td,
            .salary-table th {
                padding: 3px;
            }

            .f-12 {
                font-size: 10px !important;
            }

            .f-14 {
                font-size: 11px !important;
            }
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            table-layout: fixed;
        }

        .salary-table td,
        .salary-table th {
            border: 1px solid #000;
            padding: 4px;
            font-size: 11px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .salary-table td:first-child {
            width: 45%;
        }

        .salary-table td:nth-child(2) {
            width: 10%;
            text-align: center;
        }

        .salary-table td:nth-child(3) {
            width: 22%;
            text-align: right;
        }

        .salary-table td:nth-child(4) {
            width: 23%;
            text-align: right;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if ($show_download_overlay): ?>
        <div class="download-overlay">
            <div class="download-message">
                <div class="download-spinner"></div>
                <p>Downloading...</p>
            </div>
        </div>
    <?php endif; ?>

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
                <td class="fw-bold f-12" style="background-color:rgba(171, 193, 25, 0.81);">Number of Absent Days : &nbsp; &nbsp;
                    <input type="number" class="fw-bold" value="<?php echo isset($salary_details['absent_days']) ? $salary_details['absent_days'] : '0'; ?>" onchange="updateAbsentDays(this.value)">
                </td>
                <td class="fw-bold f-12">Month-Year : <span class="fw-bold">
                        <?php
                        $month_year = isset($salary_details['month_year']) ? $salary_details['month_year'] : '';
                        list($month, $year) = explode('-', $month_year);
                        $currentYear = date('Y');
                        $currentMonth = date('m');
                        $currentDate = date('d');

                        // Determine the max date based on the current date
                        if ($currentDate > 25) {
                            // If today is after the 25th, allow selection of next month
                            $maxDate = date('Y-m', strtotime('first day of next month'));
                        } else {
                            // Otherwise, restrict to the current month
                            $maxDate = date('Y-m', strtotime('last day of this month'));
                        }
                        ?>
                        <input type="month" id="month_year" name="month_year" value="<?php echo htmlspecialchars($year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT)); ?>" max="<?php echo $maxDate; ?>" onchange="updateMonthYear(this.value)">
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
                    <input type="number" id="gross_salary" value="<?php echo $gross_salary ? $gross_salary : 0; ?>" onchange="calculateSalaryComponents(this.value)">
                </td>
                <td class="fw-bold" id="gross_salary_annual">
                    <?php echo number_format($gross_salary * 12, 2); ?>
                </td>
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

        <form id="salaryForm" method="POST" action="index.php?module=Salaries&view=Update-Salary" onsubmit="return false;">
            <!-- <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>"> -->
            <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($employee_id); ?>">
            <input type="hidden" name="month_year" value="<?php echo htmlspecialchars($salary_details['month_year']); ?>">
            <input type="hidden" name="gross_salary" id="hidden_gross_salary">
            <input type="hidden" name="absent_days" id="hidden_absent_days">
            <input type="hidden" name="hidden_month_year" id="hidden_month_year">
            <button type="submit" class="btn btn-info mt-2 float-end w-25" id="updateBtn" onclick="submitForm()">
                Update
            </button>
        </form>
    </div>


    <script>
        function goBack() {
            window.history.back();
        }

        function updateAbsentDays(absentDays) {
            // Call calculateSalaryComponents with the current gross salary
            const grossSalaryElement = document.getElementById('gross_salary');
            const grossSalary = parseFloat(grossSalaryElement.value) || 0;
            calculateSalaryComponents(grossSalary);
        }

        function calculateSalaryComponents(grossSalary) {
            // Get absent days from the displayed value
            const absentDaysText = document.querySelector('td[style*="background-color:rgba(171, 193, 25, 0.81)"] input').value.trim();
            const absentDays = parseFloat(absentDaysText) || 0;

            // Calculate per day salary and deduction
            const perDaySalary = grossSalary / 30;
            const absentDeduction = perDaySalary * absentDays;

            // Adjust gross salary after absence deduction
            const adjustedGrossSalary = grossSalary - absentDeduction;

            // Basic Components (using adjustedGrossSalary)
            const basicPay = adjustedGrossSalary * 0.30;
            const hra = adjustedGrossSalary * 0.45;
            const cea = adjustedGrossSalary * 0.10;
            const specialAllowance = adjustedGrossSalary * 0.15;

            // Update Basic Components
            updateValue('basic_pay_monthly', basicPay);
            updateValue('basic_pay_annual', basicPay * 12);
            updateValue('hra_monthly', hra);
            updateValue('hra_annual', hra * 12);
            updateValue('cea_monthly', cea);
            updateValue('cea_annual', cea * 12);
            updateValue('special_allowance_monthly', specialAllowance);
            updateValue('special_allowance_annual', specialAllowance * 12);

            // Update Gross Salary display
            updateValue('gross_salary', adjustedGrossSalary);
            updateValue('gross_salary_annual', adjustedGrossSalary * 12);

            // Deductions
            const professionalTax = 208.00;
            const pfEmployee = Math.min(adjustedGrossSalary * 0.036, 1800);
            const tds = 0;

            // Update Deductions
            updateValue('professional_tax_monthly', professionalTax);
            updateValue('professional_tax_annual', professionalTax * 12);
            updateValue('pf_employee_monthly', pfEmployee);
            updateValue('pf_employee_annual', pfEmployee * 12);
            updateValue('tds_monthly', tds);
            updateValue('tds_annual', tds * 12);

            const totalDeductions = professionalTax + pfEmployee + tds;
            updateValue('total_deductions_monthly', totalDeductions);
            updateValue('total_deductions_annual', totalDeductions * 12);

            // Net Payable
            const netPayable = adjustedGrossSalary - totalDeductions;
            updateValue('net_payable_monthly', netPayable);
            updateValue('net_payable_annual', netPayable * 12);

            // Annual Benefits
            const lta = adjustedGrossSalary * 0.025;
            const annualPerformancePay = adjustedGrossSalary * 0.12;

            updateValue('lta_monthly', lta);
            updateValue('lta_annual', lta * 12);
            updateValue('annual_performance_monthly', annualPerformancePay);
            updateValue('annual_performance_annual', annualPerformancePay * 12);

            const totalAnnualBenefits = lta + annualPerformancePay;
            updateValue('total_annual_benefits_monthly', totalAnnualBenefits);
            updateValue('total_annual_benefits_annual', totalAnnualBenefits * 12);

            // Retiral Benefits
            const pfEmployer = Math.min(adjustedGrossSalary * 0.036, 1800);
            const gratuity = adjustedGrossSalary * 0.0144;

            updateValue('pf_employer_monthly', pfEmployer);
            updateValue('pf_employer_annual', pfEmployer * 12);
            updateValue('gratuity_monthly', gratuity);
            updateValue('gratuity_annual', gratuity * 12);

            const totalRetiral = pfEmployer + gratuity;
            updateValue('total_retiral_monthly', totalRetiral);
            updateValue('total_retiral_annual', totalRetiral * 12);

            // Medical Benefits
            const medicalInsurance = adjustedGrossSalary * 0.012;
            updateValue('medical_insurance_monthly', medicalInsurance);
            updateValue('medical_insurance_annual', medicalInsurance * 12);
            updateValue('total_medical_monthly', medicalInsurance);
            updateValue('total_medical_annual', medicalInsurance * 12);

            // Fixed CTC
            const fixedCTC = adjustedGrossSalary + totalAnnualBenefits + totalRetiral + medicalInsurance;
            updateValue('fixed_ctc_monthly', fixedCTC);
            updateValue('fixed_ctc_annual', fixedCTC * 12);
        }

        // Helper function to update values
        function updateValue(elementId, value) {
            const element = document.getElementById(elementId);
            if (element) {
                element.textContent = formatCurrency(value);
            }
        }

        function formatCurrency(value) {
            return value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // Initialize calculations when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const grossSalaryElement = document.getElementById('gross_salary');
            if (grossSalaryElement) {
                const grossSalary = parseFloat(grossSalaryElement.value) || 0;
                calculateSalaryComponents(grossSalary);
            }
        });

        // function generatePDF() {
        //     const element = document.querySelector('.container');
        //     const backBtn = element.querySelector('.back-btn');
        //     backBtn.style.display = 'none';

        //     const loadingMessage = document.querySelector('.download-message p');

        //     const opt = {
        //         margin: [5, 5, 5, 5],
        //         filename: `salary_slip_${new Date().toISOString().slice(0,10)}.pdf`,
        //         image: {
        //             type: 'jpeg',
        //             quality: 0.98
        //         },
        //         html2canvas: {
        //             scale: 2,
        //             useCORS: true,
        //             logging: true,
        //             scrollX: 0,
        //             scrollY: 0,
        //             windowWidth: document.documentElement.offsetWidth,
        //             windowHeight: document.documentElement.offsetHeight
        //         },
        //         jsPDF: {
        //             unit: 'mm',
        //             format: 'a4',
        //             orientation: 'portrait'
        //         }
        //     };

        //     html2pdf().from(element).set(opt)
        //         .toPdf()
        //         .get('pdf')
        //         .then((pdf) => {
        //             loadingMessage.textContent = 'Generating PDF...';
        //         })
        //         .save()
        //         .then(() => {
        //             loadingMessage.textContent = 'Download Complete!';
        //             setTimeout(() => {
        //                 backBtn.style.display = 'flex';
        //                 document.querySelector('.download-overlay')?.remove();
        //                 // Add redirect after download completes
        //                 window.location.href = 'index.php?module=Salaries&view=List';
        //             }, 1000);
        //         })
        //         .catch(err => {
        //             loadingMessage.textContent = 'Error generating PDF. Please try again.';
        //             console.error('PDF Generation Error:', err);
        //             setTimeout(() => {
        //                 backBtn.style.display = 'flex';
        //                 document.querySelector('.download-overlay')?.remove();
        //                 // Also redirect on error after showing error message
        //                 window.location.href = 'index.php?module=Salaries&view=List';
        //             }, 2000);
        //         });
        // }

        // Update the download overlay code
        <?php if ($show_download_overlay): ?>
            // document.addEventListener('DOMContentLoaded', function() {
            //     setTimeout(function() {
            //         generatePDF();
            //     }, 3000);
            // });
        <?php endif; ?>

        function submitForm() {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update the salary details?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the values of hidden inputs before submission
                    document.getElementById('hidden_gross_salary').value = document.getElementById('gross_salary').value;
                    document.getElementById('hidden_absent_days').value = document.querySelector('td[style*="background-color:rgba(171, 193, 25, 0.81)"] input').value;

                    // Ensure the month-year input value is captured
                    const monthYearInput = document.getElementById('month_year');
                    if (monthYearInput) {
                        const [year, month] = monthYearInput.value.split('-'); // Split the value into year and month
                        document.getElementById('hidden_month_year').value = `${month}-${year}`; // Format as MM-YYYY
                    }

                    const form = document.getElementById('salaryForm');
                    const formData = new FormData(form);
                    // console.log('Form Data:', Array.from(formData.entries()));

                    fetch(form.action, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.text())
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Salary details updated successfully!'
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error updating the salary details.'
                            });
                        });
                }
            });
        }
    </script>
</body>

</html>