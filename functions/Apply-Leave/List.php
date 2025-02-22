<?php

$table_name = 'leave_request';
$redirection_page = "index.php?module=Apply-Leave&view=List";
$action_name = "module=Apply-Leave&view=List";


$user_id = $_SESSION['user_id'];
$get_employee_id = "SELECT user_unique_id FROM users WHERE id = '$user_id'";
$sql = $dbconn->prepare($get_employee_id);
$sql->execute();
$employee_id = $sql->fetchColumn();




// For Displaying the table

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 30;
$offset = ($pageno - 1) * $no_of_records_per_page;


$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();


$total_rows = $sql->fetchColumn();
$total_pages = ceil($total_rows / $no_of_records_per_page);

// Add filtering options for status and date
// Modify the SQL query to include filtering
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';

$select_enquiry = "SELECT * FROM `$table_name` WHERE status = 'Active' AND employee_id = '$employee_id'";
if ($status_filter) {
    $select_enquiry .= " AND leave_status = :status";
}
if ($date_filter) {
    $select_enquiry .= " AND DATE(leave_date) = :date";
}

$select_enquiry .= " ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);

if ($status_filter) {
    $sql->bindParam(':status', $status_filter);
}
if ($date_filter) {
    $sql->bindParam(':date', $date_filter);
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
                <div class="card-header border-0" style="padding: 30px 30px 0px 30px;">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="true">Applied Leaves</a>
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Apply-Leave&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Apply Leave</a>
                        </div>
                    </nav>
                </div>
                <div class="table-responsive p-3">
                    <div class="filter-options mb-3" style="padding:12px;">
                        <form class="form-inline gap-3">
                            <div class="form-group" style="align-items: end;gap: 10px;">
                                <label for="statusFilter" class="mr-2">Status:</label>
                                <select id="statusFilter" class="form-control" onchange="filterTable()">
                                    <option value="">All</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Accepted">Accepted</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <!-- <div class="form-group" style="align-items: end; gap: 10px;">
                                <label for="dateInput" class="mr-2">Date:</label>
                                <input type="date" id="dateInput" class="form-control">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="filterTable()">Filter</button> -->
                        </form>
                    </div>
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col">Id</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Leave Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTable">
                            <?php
                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {
                                    $field1 = $rows->id;
                                    $field3 = $rows->title;
                                    $field4 = $rows->description;
                                    $field5 = $rows->leave_document;
                                    $field6 = $rows->leave_status;
                                    $field7 = $rows->leave_type;

                                    // Check for title and description length
                                    $title_display = (str_word_count($field3) > 3) ? implode(' ', array_slice(explode(' ', $field3), 0, 5)) . '... <a href="#" class="show-more" data-title="' . htmlspecialchars($field3) . '">show more</a>' : $field3;
                                    $description_display = (str_word_count($field4) > 3) ? implode(' ', array_slice(explode(' ', $field4), 0, 10)) . '... <a href="#" style="color: blue; letter-spacing: .5px;" class="show-more" data-description="' . htmlspecialchars($field4) . '">show more</a>' : $field4;
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><a href="<?php echo $field5; ?>" target="_blank">View</a></td>
                                        <td><?php echo $title_display; ?></td>
                                        <td><?php echo $description_display; ?></td>
                                        <td><?php echo $field7; ?></td>
                                        <td style="text-align: center;"><?=
                                                                        $field6 == 'Pending' ? '<span class="badge bg-warning">Pending</span>' : ($field6 == 'Accepted' ? '<span class="badge bg-success">Accepted</span>' : '<span class="badge bg-danger">Rejected</span>')
                                                                        ?></td>
                                        <td style="text-align: start;">
                                            <?php if ($field6 == 'Pending') { ?>
                                                <a href="index.php?module=Apply-Leave&view=Update&id=<?php echo $field1; ?>" class=""><i class="material-icons" style="font-size:18px; color: blue;">edit</i></a>
                                            <?php } else { ?>
                                                <i class="material-icons" style="font-size:18px; color: lightgray; cursor: not-allowed;">edit</i>
                                            <?php } ?>
                                            <a href="index.php?module=Apply-Leave&view=Delete&id=<?php echo $field1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');" class=""><i class="material-icons" style="font-size:18px; color: red; margin-left: 5px;">delete</i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                // No data found message
                                echo '<tr><td colspan="7" style="text-align: center;">No data found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php include('plugin/pagination.php'); ?>


                    <!-- Modal for showing full title and description -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Details</h5>
                                    <button type="button" class="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h6 id="modalTitle"></h6>
                                    <p id="modalDescription"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function filterTable() {
        const statusFilter = document.getElementById("statusFilter").value;
        const table = document.getElementById("employeeTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 0; i < tr.length; i++) {
            const tdStatus = tr[i].getElementsByTagName("td")[4]; // Assuming status is in the sixth column
            // console.log(tdStatus)

            if (tdStatus) {
                const statusValue = tdStatus.textContent || tdStatus.innerText;
                if (statusFilter === "" || statusValue === statusFilter) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Show modal when "show more" is clicked
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('show-more')) {
            e.preventDefault();
            const title = e.target.getAttribute('data-title');
            const description = e.target.getAttribute('data-description');

            if (title) {
                document.getElementById('modalTitle').innerText = title;
            }
            if (description) {
                document.getElementById('modalDescription').innerText = description;
            }

            $('#myModal').modal('show'); // Show the modal
        }

        // Custom close functionality for the modal
        if (e.target.classList.contains('close') || e.target.classList.contains('btn-secondary')) {
            $('#myModal').modal('hide'); // Hide the modal
        }
    });
</script>