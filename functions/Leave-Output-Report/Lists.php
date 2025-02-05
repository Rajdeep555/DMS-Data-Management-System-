<?php

$table_name = 'leave_report';
$redirection_page = "index.php?module=Leave-Output-Report&view=List";
$action_name = "module=Leave-Output-Report&view=List";
$year = $_GET['year'];

// For Displaying the table
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 7;
$offset = ($pageno - 1) * $no_of_records_per_page;

$select_enquiry = "SELECT * FROM `$table_name` WHERE status = 'Active' AND leave_year = $year ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<style>
    /* Ensure the table fits within the PDF */
    .table-responsive {
        overflow-x: auto;
        /* Allow horizontal scrolling */
    }

    table {
        width: 100%;
        /* Ensure the table takes full width */
        border-collapse: collapse;
        font-size: 12px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="ms-2">
                <input type="text" id="searchInput" placeholder="Search by Employee Name" onkeyup="liveSearch()" class="form-control mb-3">
                <button class="btn btn-success mb-3" id="downloadButton" onclick="downloadReport()">
                    <i class="fas fa-download"></i> Download Report
                </button>
                <button class="btn btn-primary mb-3" id="addLeaveButton" onclick="redirectToCreate()">
                    <i class="fas fa-plus"></i> Add New Leave Report
                </button>
            </div>
            <div class="table-responsive p-3">

                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">SL NO</th>
                            <th rowspan="2" style="width: 300px; display: static;">NAME OF THE EMPLOYEE</th>
                            <th rowspan="2" style="width: 200px;">EMPLOYEE CODE</th>
                            <th rowspan="2" style="width: 220px;">DEPARTMENT</th>
                            <th colspan="3">SL/CL</th>
                            <th colspan="3">EL</th>
                            <th colspan="3">LOP</th>
                            <th colspan="3">MATERNITY LEAVE</th>
                        </tr>
                        <tr>
                            <th>ELIGIBLE</th>
                            <th>USED</th>
                            <th>BALANCE</th>
                            <th>ELIGIBLE</th>
                            <th>USED</th>
                            <th>BALANCE</th>
                            <th>ELIGIBLE</th>
                            <th>USED</th>
                            <th>BALANCE</th>
                            <th>ELIGIBLE</th>
                            <th>USED</th>
                            <th>BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($sql->rowCount() > 0) {
                            foreach ($wlvd as $rows) {
                                // Fetch employee details from the users table
                                $user_query = "SELECT * FROM users WHERE user_unique_id = :employee_id AND status = 'Active'";
                                $user_stmt = $dbconn->prepare($user_query);
                                $user_stmt->execute([':employee_id' => $rows->employee_id]);
                                $user = $user_stmt->fetch(PDO::FETCH_OBJ);

                                $fullName = $user->user_fname . ' ' . $user->user_mname . ' ' . $user->user_lname;
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td style="width: 300px; white-space: nowrap;"><?php echo $fullName; ?></td>
                                    <td style="width: 200px;"><?php echo $rows->employee_id; ?></td>
                                    <td style="width: 220px;"><?php echo $user ? $user->user_role : 'N/A'; ?></td>

                                    <td><?php echo $rows->sl_eligible; ?></td>
                                    <td><?php echo $rows->sl_used; ?></td>
                                    <td><?php echo $rows->sl_balance; ?></td>
                                    <td><?php echo $rows->el_eligible; ?></td>
                                    <td><?php echo $rows->el_used; ?></td>
                                    <td><?php echo $rows->el_balance; ?></td>
                                    <td><?php echo $rows->lop_eligible; ?></td>
                                    <td><?php echo $rows->lop_used; ?></td>
                                    <td><?php echo $rows->lop_balance; ?></td>
                                    <td><?php echo $rows->mat_eligible; ?></td>
                                    <td><?php echo $rows->mat_used; ?></td>
                                    <td><?php echo $rows->mat_balance; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='16'>No data found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function redirectToCreate() {
        window.location.href = "index.php?module=Leave-Output-Report&view=Create";
    }

    function liveSearch() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.querySelector('table tbody');
        const rows = table.getElementsByTagName('tr');
        let noDataFound = true; // Flag to check if any data is found

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let found = false;
            for (let j = 0; j < cells.length; j++) {
                // Check if the search term matches either employee name or employee code
                if (cells[j].textContent.toLowerCase().includes(filter) && (j === 1 || j === 2)) {
                    found = true;
                    break;
                }
            }
            rows[i].style.display = found ? '' : 'none';
            if (found) {
                noDataFound = false; // Data found, set flag to false
            }
        }

        // Show "No data found" message if no rows are displayed
        const noDataRow = document.createElement('tr');
        noDataRow.innerHTML = "<td colspan='16'>No data found</td>";
        if (noDataFound) {
            table.appendChild(noDataRow);
        } else {
            // Remove "No data found" row if data is present
            const existingNoDataRow = table.querySelector('tr:has(td[colspan="16"])');
            if (existingNoDataRow) {
                existingNoDataRow.remove();
            }
        }
    }

    function downloadReport() {
        const table = document.querySelector('table'); 
        let csv = [];
        const rows = table.querySelectorAll('tr');

        for (let i = 0; i < rows.length; i++) {
            const row = [],
                cols = rows[i].querySelectorAll('td, th');

            for (let j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText); 
            }
            csv.push(row.join(',')); 
        }


        const csvFile = new Blob([csv.join('\n')], {
            type: 'text/csv'
        });
        const downloadLink = document.createElement('a');
        downloadLink.href = URL.createObjectURL(csvFile);
        downloadLink.download = 'leave_report.csv'; 
        document.body.appendChild(downloadLink);
        downloadLink.click(); 
        document.body.removeChild(downloadLink); 
    }
</script>