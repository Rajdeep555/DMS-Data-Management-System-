<?php
// Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$table_name = 'travel_log';
$redirection_page = "index.php?module=Market-Report&view=List";
$action_name = "module=Market-Report&view=List";
$employee_id = $_GET['emp_id'];
$isFromAdmin = !empty($employee_id);
if (empty($employee_id)) {
    $user_id = $_SESSION['user_id'];

    $select_user = "SELECT * FROM `users` WHERE id = :user_id";
    $sql = $dbconn->prepare($select_user);
    $sql->bindParam(':user_id', $user_id);
    $sql->execute();
    $user = $sql->fetchAll(PDO::FETCH_OBJ);
    foreach ($user as $rows);
    $user_unique_id = $rows->user_unique_id;
} else {
    $user_id = $employee_id;
    $user_unique_id = $employee_id;
}
// echo $user_id;

if ($isFromAdmin) {
    $user_id = $employee_id;
} else {
    $user_id = $user_unique_id;
}

// For Displaying the table

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 50;
$offset = ($pageno - 1) * $no_of_records_per_page;
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : null;
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : null;

$select_enquiry = "SELECT COUNT(*) FROM `$table_name` WHERE status = 'Active'";
if ($isFromAdmin) {
    $select_enquiry .= " AND employee_id = :employee_id";
} else {
    $select_enquiry .= " AND employee_id = :user_unique_id";
}


if ($from_date && $to_date) {
    $select_enquiry .= " AND date BETWEEN :from_date AND :to_date";
}
$sql = $dbconn->prepare($select_enquiry);
if ($isFromAdmin) {
    $sql->bindParam(':employee_id', $employee_id);
} else {
    $sql->bindParam(':user_unique_id', $user_unique_id);
}
if ($from_date && $to_date) {
    $sql->bindParam(':from_date', $from_date);
    $sql->bindParam(':to_date', $to_date);
}
$sql->execute();
$total_rows = $sql->fetchColumn();
$total_pages = ceil($total_rows / $no_of_records_per_page);
$select_enquiry = "SELECT * FROM `$table_name` WHERE status = 'Active'";
if (!empty($user_unique_id)) {
    $select_enquiry .= " AND employee_id = :employee_id";
}
if ($from_date && $to_date) {
    $select_enquiry .= " AND date BETWEEN :from_date AND :to_date";
}
$select_enquiry .= " ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);
if (!empty($user_unique_id)) {
    $sql->bindParam(':employee_id', $user_unique_id);
}
if ($from_date && $to_date) {
    $sql->bindParam(':from_date', $from_date);
    $sql->bindParam(':to_date', $to_date);
}
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


<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="true">All Reports</a>
                            <a class="nav-item nav-link btn btn-lg" href="index.php?module=Market-Report&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Report</a>
                        </div>
                    </nav>
                </div>

                <!-- Add date filter form -->
                <form method="GET" action="index.php" class="mb-3">
                    <div class="row">
                        <!-- Hidden Fields for Correct Redirection -->
                        <input type="hidden" name="module" value="Market-Report">
                        <input type="hidden" name="view" value="List">
                        <input type="hidden" name="emp_id" value="<?php echo $employee_id; ?>">

                        <div class="col-md-3 mb-2" style="margin-left: 30px;">
                            <label for="from_date" class="form-label">From Date:</label>
                            <input type="date" id="from_date" name="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="to_date" class="form-label">To Date:</label>
                            <input type="date" id="to_date" name="to_date" class="form-control" required>
                        </div>
                        <div class="col-md-2 mb-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                        <div class="col-md-3 mb-2 d-flex align-items-end">
                            <button id="download_report" class="btn btn-success d-flex align-items-center gap-1">
                                <i class="material-icons" style="font-size:13px;">download</i> Download Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="border-bottom-primary">
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Opening KM</th>
                            <th scope="col">Closing KM</th>
                            <th scope="col">KM Travelled</th>
                            <th scope="col">No. of farm visit</th>
                            <th scope="col">No. retailer visit</th>
                            <th scope="col">Collection</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($sql->rowCount() > 0) {
                            foreach ($wlvd as $rows) {
                                $field1 = $rows->id;
                                $field2 = $rows->name;
                                $field3 = $rows->date;
                                $field4 = $rows->opening_km;
                                $field5 = $rows->closing_km;
                                $field6 = $rows->km_travel;
                                $field7 = $rows->no_of_farm_visits;
                                $field8 = $rows->no_of_retailer_visits;
                                $field9 = $rows->collection;
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $i++; ?></th>
                                    <td><?php echo htmlspecialchars($field2); ?></td>
                                    <td style="white-space: nowrap;"><?php echo date('d-m-Y', strtotime($field3)); ?></td>
                                    <td><?php echo htmlspecialchars($field4); ?></td>
                                    <td><?php echo htmlspecialchars($field5); ?></td>
                                    <td><?php echo htmlspecialchars($field6); ?></td>
                                    <td><?php echo htmlspecialchars($field7); ?></td>
                                    <td><?php echo htmlspecialchars($field8); ?></td>
                                    <td><?php echo htmlspecialchars($field9); ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-start align-items-center" style="gap: 10px;">

                                            <a href="index.php?module=Market-Report&view=Update&id=<?php echo $field1; ?>" class="me-2">
                                                <i class="material-icons" style="font-size:18px;color:blue;">edit</i>
                                            </a>

                                            <a href="index.php?module=Market-Report&view=Delete&id=<?php echo $field1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');">
                                                <i class="material-icons" style="font-size:18px;color:red;">delete</i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

                <?php include('plugin/pagination.php'); ?>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Container-fluid Ends-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('download_report').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default behavior

        let downloadBtn = document.getElementById('download_report');

        // Show loading state
        downloadBtn.innerHTML = '<i class="material-icons" style="font-size:13px;">hourglass_empty</i> Downloading...';
        downloadBtn.disabled = true;

        // Clone the table to modify for PDF
        let tableClone = document.querySelector('.table-responsive').cloneNode(true);

        // Remove the "Action" column
        let actionHeaders = tableClone.querySelectorAll("th:nth-child(10)");
        let actionCells = tableClone.querySelectorAll("td:nth-child(10)");
        actionHeaders.forEach(header => header.remove());
        actionCells.forEach(cell => cell.remove());

        // Generate PDF
        html2pdf()
            .set({
                margin: 10,
                filename: 'Travel_Report.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    orientation: 'landscape'
                }
            })
            .from(tableClone)
            .save()
            .then(() => {
                // Restore button state after download
                downloadBtn.innerHTML = '<i class="material-icons" style="font-size:13px;">download</i> Download Report';
                downloadBtn.disabled = false;
            })
            .catch(() => {
                // Handle errors and restore button
                downloadBtn.innerHTML = '<i class="material-icons" style="font-size:13px;">download</i> Download Report';
                downloadBtn.disabled = false;
                alert("Error: Unable to generate PDF.");
            });
    });
</script>