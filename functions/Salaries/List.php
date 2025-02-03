<link href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

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
</style>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="true">Salary Details</a>
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Salaries&view=Select-Employee" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Add Salary</a>
                        </div>
                    </nav>
                </div>
                <div class="card-body" style="padding: 0; min-height: 400px;">
                    <div class="row m-3">
                        <div class="col-sm-3">
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
                        <div class="col-sm-2">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri-calendar-check-line"></i>
                                </span>
                                <select class="form-control" id="year_filter">
                                    <option value="">Select Year</option>
                                    <?php
                                    $currentYear = date('Y');
                                    for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                        echo "<option value='$year'>$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ri-calendar-line"></i>
                                </span>
                                <select class="form-control" id="month_filter">
                                    <option value="">Select Month</option>
                                    <?php
                                    $months = array(
                                        "01" => "January",
                                        "02" => "February",
                                        "03" => "March",
                                        "04" => "April",
                                        "05" => "May",
                                        "06" => "June",
                                        "07" => "July",
                                        "08" => "August",
                                        "09" => "September",
                                        "10" => "October",
                                        "11" => "November",
                                        "12" => "December"
                                    );
                                    foreach ($months as $key => $month) {
                                        echo "<option value='$key'>$month</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="search_input" placeholder="Eg.Rajdeep Boruah">
                        </div>
                    </div>

                    <div class="table-responsive p-3">
                        <table class="table">
                            <thead>
                                <tr class="border-bottom-primary" style="font-size: 12px;">
                                    <th scope="col"><strong>ID</strong></th>
                                    <th scope="col" style="white-space: nowrap;"><strong>Employee ID & Name</strong></th>
                                    <th scope="col"><strong>Designation</strong></th>
                                    <th scope="col"><strong>Month-Year</strong></th>
                                    <th scope="col"><strong>Gross Salary<span class="">( Before deductions )</span></strong></th>
                                    <th scope="col"><strong>Created At</strong></th>
                                    <th scope="col"><strong>Action</strong></th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 12px;">
                                <?php
                                $i = 1;
                                if ($sql->rowCount() > 0) {
                                    foreach ($wlvd as $rows) {

                                        $field1 = $rows->id;
                                        $field2 = $rows->employee_id;
                                        $field3 = $rows->gross_salary;
                                        $field4 = $rows->month_year;
                                        $field5 = $rows->created_at;
                                        // fetching employee name and designation from users table
                                        $select_bookings = "SELECT * FROM `users` where status = 'Active' and user_unique_id='$field2'";
                                        $sql12 = $dbconn->prepare($select_bookings);
                                        $sql12->execute();
                                        $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($wlvd12 as $rows12);
                                        $employee_name = $rows12->user_fname . " " . $rows12->user_mname . " " . $rows12->user_lname;
                                        $employee_designation = $rows12->user_role;
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td>
                                                <a id="employee_name" style="text-decoration: none; color: blue;" href="index.php?module=Salaries&view=Viewing-Salary-Details&id=<?php echo $field1; ?>">
                                                    <?php echo $employee_name . " ( " . $field2 . " )"; ?>
                                                </a>
                                            </td>
                                            <td><?php echo $employee_designation; ?></td>
                                            <td><?php echo $field4; ?></td>
                                            <td><?php echo $field3; ?></td>
                                            <td><?php echo $field5; ?></td>
                                            <td class="text-center">
                                                <div class="action-menu">
                                                    <button class="btn btn-link p-0 action-menu-btn text-decoration-none" type="button">
                                                        <i class="ri-more-2-fill" style="font-size:18px; color: #000;"></i>
                                                    </button>
                                                    <div class="action-menu-content">
                                                        <a href="index.php?module=Salaries&view=Update&id=<?php echo $field1; ?>" style="color: #0d6efd;">
                                                            <i class="ri-edit-line me-2"></i>Edit
                                                        </a>
                                                        <a href="javascript:void(0)" onclick="handleDelete(<?php echo $field1; ?>)" style="color: #dc3545;">
                                                            <i class="ri-delete-bin-line me-2"></i>Delete
                                                        </a>
                                                        <a href="index.php?module=Salaries&view=Viewing-Salary-Details&id=<?php echo $field1; ?>&download=true" style="color: #198754;">
                                                            <i class="ri-download-line me-2"></i>Download
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php include('plugin/pagination.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->


<script>
    document.getElementById('designation_filter').addEventListener('change', filterResults);
    document.getElementById('month_filter').addEventListener('change', filterResults);
    document.getElementById('year_filter').addEventListener('change', filterResults);
    document.getElementById('search_input').addEventListener('keyup', filterResults);

    function filterResults() {
        let designation = document.getElementById('designation_filter').value;
        let month = document.getElementById('month_filter').value;
        let year = document.getElementById('year_filter').value;
        let search = document.getElementById('search_input').value;

        // Get all table rows
        let rows = document.querySelectorAll('table tbody tr:not(#noDataMessage)');
        let visibleRows = 0;

        rows.forEach(row => {
            let showRow = true;

            // Filter by designation if selected
            if (designation && !row.textContent.includes(designation)) {
                showRow = false;
            }

            // Filter by month and year if selected
            if (month || year) {
                let dateCell = row.querySelector('td:nth-child(4)').textContent.trim(); // Month-Year column
                let [dbMonth, dbYear] = dateCell.split('-');

                if (month && dbMonth !== month) {
                    showRow = false;
                }
                if (year && dbYear !== year) {
                    showRow = false;
                }
            }

            // Filter by search text
            if (search && !row.textContent.toLowerCase().includes(search.toLowerCase())) {
                showRow = false;
            }

            row.style.display = showRow ? '' : 'none';
            if (showRow) visibleRows++;
        });

        // Remove existing no data message if it exists
        const existingMessage = document.getElementById('noDataMessage');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Show "No data found" message if no visible rows
        if (visibleRows === 0) {
            const tbody = document.querySelector('table tbody');
            const noDataRow = document.createElement('tr');
            noDataRow.id = 'noDataMessage';
            noDataRow.innerHTML = `
                <td colspan="7" class="text-center py-4">
                    <div class="d-flex flex-column align-items-center">
                        <i class="ri-file-search-line mb-2" style="font-size: 24px; color: #6c757d;"></i>
                        <div style="color: #6c757d;">No records found</div>
                    </div>
                </td>
            `;
            tbody.appendChild(noDataRow);
        }
    }

    document.addEventListener('click', function(e) {
        const actionMenus = document.querySelectorAll('.action-menu-content');

        if (e.target.closest('.action-menu-btn')) {
            const menu = e.target.closest('.action-menu').querySelector('.action-menu-content');
            actionMenus.forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });
            menu.classList.toggle('show');
        } else {
            actionMenus.forEach(menu => menu.classList.remove('show'));
        }
    });

    function handleDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this record?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?module=Salaries&view=Delete&id=' + id;
            }
        });
    }
</script>