<link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet" />

<?php
session_start();

$table_name = 'salary_details';
$redirection_page = "index.php?module=Salaries&view=List";
$action_name = "module=Salaries&view=List";

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
        text: "Created successfully"
    });';
    echo '</script>';
} elseif (isset($_GET['eid'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script type="text/javascript">';
    echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Edited successfully"
    });';
    echo '</script>';
}

?>

<style>
    ::placeholder {
        color: rgb(132, 131, 131) !important;
    }

    .action-menu {
        position: relative;
        display: inline-block;
    }

    .action-menu-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        min-width: 160px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        z-index: 1000;
    }

    .action-menu-content a {
        color: #333;
        padding: 8px 16px;
        text-decoration: none;
        display: block;
        font-size: 14px;
    }

    .action-menu-content a:hover {
        background-color: #f5f5f5;
    }

    .show {
        display: block;
    }

    a#employee_name {
        display: inline-block;
        transition: transform 0.1s ease;
    }

    a#employee_name:hover {
        transform: scale(1.03);
    }

    .form-label {
        margin-bottom: 0.3rem;
        color: #333;
    }

    .input-group {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    }

    .btn-primary {
        margin-left: 5px;
    }

    .suggestions-box {
        position: absolute;
        width: calc(100% - 130px);
        /* Adjusting width to account for button */
        max-height: 200px;
        overflow-y: auto;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: none;
        z-index: 1000;
    }

    .suggestion-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .suggestion-item:hover {
        background-color: #f5f5f5;
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    .no-results {
        padding: 12px;
        color: #666;
        text-align: center;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
        font-style: italic;
    }

    .spinner-border {
        margin-right: 8px;
    }

    button:disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }
</style>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link btn btn-lg " href="index.php?module=Salaries&view=List" aria-selected="true">Salary Details</a>
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="index.php?module=Salaries&view=Select-Employee" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Add Salary</a>
                        </div>
                    </nav>
                </div>
                <div class="card-body" style="padding: 0; min-height: 400px;">
                    <div class="row m-4">
                        <div class="col-12 mb-3">
                            <label for="designation_filter" class="form-label fw-bold">Designation:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri-user-settings-line"></i>
                                </span>
                                <select class="form-control" id="designation_filter">
                                    <option value="">Select Designation</option>
                                    <?php
                                    $select_designation = "SELECT DISTINCT user_role FROM users WHERE status='Active' AND user_role != 'Admin'";
                                    $stmt = $dbconn->prepare($select_designation);
                                    $stmt->execute();
                                    $designations = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($designations as $designation) {
                                        echo "<option value='" . $designation->user_role . "'>" . $designation->user_role . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="search_input" class="form-label fw-bold">Employee Name:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri-search-line"></i>
                                </span>
                                <input type="text" class="form-control" id="search_input"
                                    placeholder="Start typing employee name..."
                                    oninput="showSuggestions(this.value)">
                            </div>
                            <div id="suggestions-container" class="suggestions-box"></div>
                        </div>

                        <div id="additional-fields" style="display: none;">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="year_filter" class="form-label fw-bold">Year:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-calendar-line"></i>
                                        </span>
                                        <select class="form-control" id="year_filter" onchange="updateMonths()">
                                            <option value="">Select Year</option>
                                            <?php
                                            $current_year = date('Y');
                                            for ($year = $current_year; $year > $current_year - 5; $year--) {
                                                echo "<option value='$year'>$year</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="month_filter" class="form-label fw-bold">Month:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ri-calendar-line"></i>
                                        </span>
                                        <select class="form-control" id="month_filter">
                                            <option value="">Select Month</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="button" onclick="validateAndSubmit()">
                                    Go Ahead
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<script>
    const months = {
        1: 'January',
        2: 'February',
        3: 'March',
        4: 'April',
        5: 'May',
        6: 'June',
        7: 'July',
        8: 'August',
        9: 'September',
        10: 'October',
        11: 'November',
        12: 'December'
    };

    function updateMonths() {
        const yearSelect = document.getElementById('year_filter');
        const monthSelect = document.getElementById('month_filter');
        const selectedYear = yearSelect.value;
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth() + 1;

        // Clear existing options
        monthSelect.innerHTML = '<option value="">Select Month</option>';

        if (!selectedYear) return;

        // If selected year is current year, show months up to current month
        // Otherwise show all months
        const maxMonth = (selectedYear == currentYear) ? currentMonth : 12;

        for (let i = 1; i <= maxMonth; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = months[i];
            monthSelect.appendChild(option);
        }
    }

    // Initialize months on page load
    document.addEventListener('DOMContentLoaded', updateMonths);

    let allEmployees = <?php
                        $select_employees = "SELECT DISTINCT user_fname, user_mname, user_lname, user_role, user_unique_id FROM users WHERE status='Active'";
                        $stmt = $dbconn->prepare($select_employees);
                        $stmt->execute();
                        $employees = $stmt->fetchAll(PDO::FETCH_OBJ);
                        $employeeData = array_map(function ($employee) {
                            return [
                                'name' => trim($employee->user_fname . " " . $employee->user_mname . " " . $employee->user_lname),
                                'id' => $employee->user_unique_id,
                                'designation' => $employee->user_role,
                                'display' => trim($employee->user_fname . " " . $employee->user_mname . " " . $employee->user_lname) . " (" . $employee->user_unique_id . ")"
                            ];
                        }, $employees);
                        echo json_encode($employeeData);
                        ?>;

    let filteredEmployees = allEmployees; // Initialize with all employees

    document.getElementById('designation_filter').addEventListener('change', function() {
        const selectedDesignation = this.value;
        document.getElementById('search_input').value = '';

        // Show all employees if no designation selected
        filteredEmployees = selectedDesignation ?
            allEmployees.filter(emp => emp.designation === selectedDesignation) :
            allEmployees;

        document.getElementById('suggestions-container').style.display = 'none';
    });

    let searchTimeout = null;

    function showSuggestions(value) {
        const container = document.getElementById('suggestions-container');
        const designation = document.getElementById('designation_filter').value;

        // Clear previous timeout
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        // Set new timeout
        searchTimeout = setTimeout(() => {
            container.innerHTML = '';

            if (!value.trim()) {
                container.style.display = 'none';
                return;
            }

            const matchingEmployees = filteredEmployees
                .filter(employee =>
                    employee.display.toLowerCase().includes(value.toLowerCase())
                );

            if (matchingEmployees.length > 0) {
                matchingEmployees.forEach(employee => {
                    const div = document.createElement('div');
                    div.className = 'suggestion-item';
                    div.textContent = employee.display;
                    div.onclick = function() {
                        selectEmployee(employee);
                    };
                    container.appendChild(div);
                });
                container.style.display = 'block';
            } else {
                // Show "No employee found" message
                const noResults = document.createElement('div');
                noResults.className = 'no-results';
                noResults.textContent = 'No employee found';
                container.appendChild(noResults);
                container.style.display = 'block';
            }
        }, 200); // 200ms delay
    }

    document.addEventListener('click', function(e) {
        const container = document.getElementById('suggestions-container');
        const searchInput = document.getElementById('search_input');
        if (e.target !== searchInput) {
            container.style.display = 'none';
        }
    });

    function selectEmployee(employee) {
        document.getElementById('search_input').value = employee.display;
        document.getElementById('suggestions-container').style.display = 'none';
        document.getElementById('additional-fields').style.display = 'block';
    }

    function validateAndSubmit() {
        const goAheadButton = document.querySelector('button[onclick="validateAndSubmit()"]');

        // Show loader and disable button
        goAheadButton.disabled = true;
        goAheadButton.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Processing...
        `;

        const searchValue = document.getElementById('search_input').value;
        const designation = document.getElementById('designation_filter').value;
        const year = document.getElementById('year_filter').value;
        const month = document.getElementById('month_filter').value;
        const timestamp = Math.floor(Date.now() / 1000);

        let errorMessage = [];

        if (!designation) errorMessage.push("Please select designation");
        if (!searchValue) errorMessage.push("Please select an employee");
        if (!year) errorMessage.push("Please select a year");
        if (!month) errorMessage.push("Please select a month");

        if (errorMessage.length > 0) {
            // Reset button state on validation error
            goAheadButton.disabled = false;
            goAheadButton.innerHTML = 'Go Ahead';

            Swal.fire({
                icon: 'warning',
                title: 'Required Fields',
                html: errorMessage.join('<br>'),
                confirmButtonColor: '#3085d6',
            });
            return false;
        }

        const selectedEmployee = filteredEmployees.find(emp => emp.display === searchValue);

        if (!selectedEmployee) {
            // Reset button state on invalid selection
            goAheadButton.disabled = false;
            goAheadButton.innerHTML = 'Go Ahead';

            Swal.fire({
                icon: 'error',
                title: 'Invalid Selection',
                text: 'Please select a valid employee from the suggestions',
                confirmButtonColor: '#3085d6',
            });
            return false;
        }

        const formData = new FormData();
        formData.append('employee_id', selectedEmployee.id);
        formData.append('month', month);
        formData.append('year', year);

        // console.log('Checking salary existence for:', {
        //     employee_id: selectedEmployee.id,
        //     month: month,
        //     year: year
        // });

        // First check if salary record exists
        fetch('functions/Salaries/check-salary-exists.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                // console.log('Raw response:', text);
                try {
                    const jsonData = JSON.parse(text);
                    // console.log('Parsed JSON:', jsonData);
                    return jsonData;
                } catch (e) {
                    // console.error('JSON parsing error:', e);
                    // console.error('Response text was:', text);
                    throw new Error('सर्वर से अमान्य प्रतिक्रिया: ' + text);
                }
            })
            .then(data => {
                if (data.exists) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Record Already Exists',
                        text: 'A salary record already exists for this employee for the selected month and year.',
                        confirmButtonColor: '#3085d6',
                    });
                    return null;
                } else {
                    // Prepare salary creation data
                    const salaryFormData = new FormData();
                    salaryFormData.append('employee_id', selectedEmployee.id);
                    salaryFormData.append('employee_name', selectedEmployee.name);
                    salaryFormData.append('designation', designation);
                    salaryFormData.append('month', month);
                    salaryFormData.append('year', year);
                    salaryFormData.append('timestamp', timestamp);

                    // Log FormData entries
                    // console.log('FormData contents:');
                    for (let pair of salaryFormData.entries()) {
                        // console.log(pair[0] + ': ' + pair[1]);
                    }

                    // Log the actual fetch request
                    // console.log('Sending request to:', 'functions/Salaries/store-salary-data.php');

                    // Create salary record with additional debugging
                    return fetch('functions/Salaries/store-salary-data.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                employee_id: selectedEmployee.id,
                                employee_name: selectedEmployee.name,
                                designation: designation,
                                month: month,
                                year: year,
                                timestamp: timestamp
                            })
                        })
                        .then(response => {
                            // console.log('Response status:', response.status);
                            // console.log('Response headers:', response.headers);
                            return response.text();
                        })
                        .then(text => {
                            // console.log('Raw response text:', text);
                            return JSON.parse(text);
                        });
                }
            })
            .then(data => {
                if (!data) return; // Skip if record exists

                // console.log('Store salary result:', data);

                if (data.success) {
                    window.location.href = 'index.php?module=Salaries&view=Create';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error || 'Failed to create salary record. Please try again.',
                        confirmButtonColor: '#3085d6',
                    });
                }
            })
            .catch(error => {
                console.error('Error in salary process:', error);
                // Reset button state on error
                goAheadButton.disabled = false;
                goAheadButton.innerHTML = 'Go Ahead';

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred: ' + error.message,
                    confirmButtonColor: '#3085d6',
                });
            });
    }

    // Add event listener for the Go Ahead button
    document.addEventListener('DOMContentLoaded', function() {
        const goAheadButton = document.querySelector('button[onclick="validateAndSubmit()"]');
        if (goAheadButton) {
            goAheadButton.addEventListener('click', function(e) {
                e.preventDefault();
                validateAndSubmit();
            });
        }
    });

    // Make sure SweetAlert2 is included
</script>

<!-- Add SweetAlert2 CSS and JS if not already included -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>