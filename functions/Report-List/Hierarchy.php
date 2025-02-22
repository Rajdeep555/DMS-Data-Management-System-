<?php

$table_name = 'users';
$redirection_page = "index.php?module=All-Designations&view=List";
$action_name = "module=All-Designations&view=List";

$designation = $_GET['designation'];

// For Displaying the table

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 35;
$offset = ($pageno - 1) * $no_of_records_per_page;


$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();


$total_rows = $sql->fetchColumn();
$total_pages = ceil($total_rows / $no_of_records_per_page);

$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' AND user_role = '$designation' order by id desc LIMIT $offset, $no_of_records_per_page";
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
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="true"><?php echo $designation; ?></a>
                            <!-- <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Module&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Module</a> -->
                        </div>
                    </nav>
                </div>
                <div class="table-responsive p-3">
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col"><strong>ID</strong></th>
                                <th scope="col"><strong>Name</strong></th>
                                <th scope="col"><strong>Email</strong></th>
                                <th scope="col"><strong>Phone</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {
                                    $field1 = $rows->id;
                                    $employee_id = $rows->user_unique_id;
                                    $field2 = $rows->user_fname . " " . $rows->user_mname . " " . $rows->user_lname;
                                    $field3 = $rows->official_email;
                                    $field4 = $rows->user_phone;
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><a style="color: blue; text-decoration:underline;" href="index.php?module=Report-List&view=AVP&emp_id=<?php echo urlencode($employee_id); ?>"><?php echo $field2; ?></a></td>
                                        <td><?php echo $field3; ?></td>
                                        <td><?php echo $field4; ?></td>
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