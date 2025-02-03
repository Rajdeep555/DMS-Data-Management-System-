<?php

$table_name = 'leave_report';
$redirection_page = "index.php?module=Leave-Output-Report&view=List";
$action_name = "module=Leave-Output-Report&view=List";

// For Displaying the table
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 7;
$offset = ($pageno - 1) * $no_of_records_per_page;

$select_enquiry = "SELECT * FROM `$table_name` WHERE status = 'Active' ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<style>
    table {
        width: 100%;
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
            <div class="table-responsive p-3">
                <button class="btn btn-primary mb-3" id="addLeaveButton" onclick="redirectToCreate()">
                    <i class="fas fa-plus"></i> Add New Leave Report
                </button>
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">SL NO</th>
                            <th rowspan="2" style="width: 300px;">NAME OF THE EMPLOYEE</th>
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
                        ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td style="width: 300px;"><?php echo $rows->employee_name; ?></td>
                                    <td style="width: 200px;"><?php echo $rows->employee_id; ?></td>
                                    <td style="width: 220px;"><?php echo $rows->department; ?></td>
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

<script>
    function redirectToCreate() {
        window.location.href = "index.php?module=Leave-Output-Report&view=Create";
    }
</script>