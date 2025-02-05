<?php

$table_name = 'leave_request';
$redirection_page = "index.php?module=Leave-Request&view=List";
$action_name = "module=Leave-Request&view=List";



// For Displaying the table

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 7;
$offset = ($pageno - 1) * $no_of_records_per_page;


$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();


$total_rows = $sql->fetchColumn();
$total_pages = ceil($total_rows / $no_of_records_per_page);

$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' AND leave_status = 'Rejected' order by id desc LIMIT $offset, $no_of_records_per_page";
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



<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link  btn btn-lg " href="index.php?module=Leave-Request&view=List" aria-selected="true">Pending</a>
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Leave-Request&view=Accepted" aria-selected="false">Accepted</a>
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="false">Rejected</a>
                        </div>
                    </nav>
                </div>

                <div class="table-responsive p-3">
                    <!-- Add search input for live search -->
                    <input type="text" style="margin: 12px;" class="form-control w-50" id="searchInput" placeholder="Search by Employee Name" onkeyup="filterTable()">
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col">Id</th>
                                <th scope="col" style="white-space: nowrap;">Employee Name & ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">From - To</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTable">
                            <tr id="noDataRow" style="display: none;">
                                <td colspan="7" style="text-align: center; color: red;">No data found</td>
                            </tr>
                            <?php
                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {

                                    $field1 = $rows->id;
                                    $field2 = $rows->employee_id;
                                    $select_bookings = "SELECT * FROM `users` where status = 'Active' AND user_unique_id='$field2'";
                                    $sql12 = $dbconn->prepare($select_bookings);
                                    $sql12->execute();
                                    $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($wlvd12 as $rows12);
                                    $full_name = $rows12->user_fname . " " . $rows12->user_mname . " " . $rows12->user_lname;

                                    $field3 = $rows->title;
                                    $field4 = $rows->description;
                                    $field5 = $rows->leave_document;
                                    $field6 = $rows->date_from;
                                    $field7 = $rows->date_to;

                                    // Check title and description length
                                    $titleWords = explode(' ', $field3);
                                    $descriptionWords = explode(' ', $field4);
                                    $showMore = (count($titleWords) > 1 && count($descriptionWords) > 1);
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><?php echo $full_name . " (" . $field2 . ")"; ?></td>
                                        <td>
                                            <a href="index.php?module=Image-View&view=Image&id=<?php echo $field1; ?>">
                                                View
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $showMore ? implode(' ', array_slice($titleWords, 0, 1)) . '... <a href="#" data-toggle="modal" data-target="#modal' . $field1 . '">Show more</a>' : $field3; ?>
                                        </td>
                                        <td>
                                            <?php echo $showMore ? implode(' ', array_slice($descriptionWords, 0, 1)) . '... <a href="#" data-toggle="modal" data-target="#modal' . $field1 . '">Show more</a>' : $field4; ?>
                                        </td>
                                        <td>
                                            <?php echo date('d-m-Y', strtotime($field6)); ?> -<br> <?php echo date('d-m-Y', strtotime($field7)); ?>
                                        </td>
                                        <td>
                                            <div style="display: flex; justify-content: center; align-items: baseline; gap: 7px;">
                                                <a id="acceptLeaveBtn<?php echo $field1; ?>" onclick="acceptLeave(<?php echo $field1; ?>, this)" data-toggle="tooltip" title="Accept">
                                                    <i class="material-icons" style="font-size:18px; color:green; margin-left: 2px; cursor:pointer;">check_circle</i>
                                                </a>
                                                <!-- <a href="index.php?module=Module&view=Reject&id=<?php echo $field1; ?>" data-toggle="tooltip" title="Reject"><i class="material-icons" style="font-size:18px; color:orange; margin-left: 2px;">cancel</i></a> -->
                                                <!-- <a href="index.php?module=Module&view=Update&id=<?php echo $field1; ?>"><i class="material-icons" style="font-size:18px; color:blue;">edit</i></a> -->
                                                <a href="index.php?module=Leave-Request&view=Delete&id=<?php echo $field1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');"><i class="material-icons" style="font-size:18px; color:red; margin-left: 2px;">delete</i></a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal<?php echo $field1; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel<?php echo $field1; ?>" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel<?php echo $field1; ?>">Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Title:</strong> <?php echo $field3; ?></p>
                                                    <p><strong>Description:</strong> <?php echo $field4; ?></p>
                                                    <!-- <p><strong>Document:</strong> <a href="<?php echo $field5; ?>">View Document</a></p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

<script>
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("employeeTable");
        const tr = table.getElementsByTagName("tr");
        let hasVisibleRows = false;

        for (let i = 1; i < tr.length; i++) { // Start from 1 to skip the "No data found" row
            const td = tr[i].getElementsByTagName("td")[0]; // Assuming employee name is in the second column
            if (td) {
                const txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    hasVisibleRows = true;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Show or hide the "No data found" row
        document.getElementById("noDataRow").style.display = hasVisibleRows ? "none" : "";
    }

    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        // Ensure modals work
        $('.modal').on('show.bs.modal', function(e) {
            const target = $(e.relatedTarget);
            const modal = $(this);
            // You can add any additional logic here if needed
        });
    });

    function acceptLeave(id, button) {
        // Disable the button to prevent multiple clicks
        button.onclick = null; // Remove the click event
        button.style.pointerEvents = 'none'; // Disable pointer events
        button.style.opacity = '0.5'; // Optional: change opacity to indicate it's disabled

        // Start AJAX request
        $.ajax({
            url: './APIs/Accept-Leave.php',
            type: 'POST',
            data: {
                id: id
            },
            success: function(response) {
                // Show success alert
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Leave accepted successfully",
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Reload the page
                    }
                });
            },
            error: function(xhr, status, error) {
                // Show error alert
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Something went wrong, please try again"
                });
            },
            complete: function() {
                // Re-enable the button after the request completes
                button.onclick = function() {
                    acceptLeave(id, button);
                }; // Restore click event
                button.style.pointerEvents = 'auto'; // Re-enable pointer events
                button.style.opacity = '1'; // Restore opacity
            }
        });
    }
</script>