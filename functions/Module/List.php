<?php

$table_name = 'module';
$redirection_page = "index.php?module=Module&view=List";
$action_name = "module=Module&view=List";



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

$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

if(isset($_GET['sid'])){
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script type="text/javascript">';
    echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Created successfully"
    });';
    echo '</script>';
} elseif(isset($_GET['eid'])){
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
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="true">Module</a>
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Module&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Module</a>
                        </div>
                    </nav>
                </div>
                <div class="table-responsive p-3">
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col">Id</th>
                                <th scope="col">Module</th>
                                <!-- <th scope="col">Group</th> -->
                                <th scope="col">Application</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
 
                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {

                                    $field1 = $rows->id;
                                    $field2 = $rows->module_name;
                                    $field3 = $rows->module_application;
                                   

                                    $select_bookings = "SELECT * FROM `application` where status = 'Active' and id='$field3'";
                                    $sql12 = $dbconn->prepare($select_bookings);
                                    $sql12->execute();
                                    $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($wlvd12 as $rows12);
                                    $application_name = $rows12->application_name;

                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><?php echo $field2; ?></td>
                                        <!-- <td><?php echo $user_grp_name; ?></td> -->
                                        <td><?php echo $application_name; ?></td>
                                        <td>
                                            <a href="index.php?module=Module&view=Update&id=<?php echo $field1; ?>" class="btn"><i class="material-icons" style="font-size:18px;color:#7366ff;">edit</i></a>
                                            <a href="index.php?module=Module&view=Delete&id=<?php echo $field1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');"><i class="material-icons" style="font-size:18px;">delete</i></a>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal1<?php echo $field1; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form id="formID" class="m-t-30" method="POST" action="">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
                                                 
                                                    </div>
                                                    <?php


                                                    ?>
                                                    <div class="modal-body">
                                                        <input class="form-control" name="mid" type="hidden" value="<?php echo $field1; ?>">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label>Menu Name <span style="color:red;">*</span></label>
                                                                    <input class="form-control" name="field1" type="text" value="<?php echo "$sidebar_menu_name"; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label>GROUP <span style="color:red;">*</span></label>
                                                                    <select class="form-select" name="field2" aria-label="Default select example" onchange="showGroup(this.value)">
                                                                        <option selected disabled><?php echo "$user_grp_name11"; ?></option>
                                                                        <?php
                                                                        $select_bookings = "SELECT * FROM `groups` where status = 'Active'";
                                                                        $sql11 = $dbconn->prepare($select_bookings);
                                                                        $sql11->execute();
                                                                        $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                                                                        if ($sql11->rowCount() > 0) {
                                                                            foreach ($wlvd11 as $rows11) {
                                                                                $user_grp_id = $rows11->id;
                                                                                $user_grp_name = $rows11->user_grp_name;
                                                                        ?>
                                                                                <option value="<?php echo $user_grp_id; ?>"><?php echo $user_grp_name; ?></option>
                                                                        <?php
                                                                            }
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3">
                                                                    <label>Sidebar Category <span style="color:red;">*</span></label>
                                                                    <select class="form-select" name="field3" aria-label="Default select example" id="Menu">
                                                                        <option selected disabled><?php echo $sidebar_category_name; ?></option>
                                                                       
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button class="btn btn-success me-3" type="submit" name="edit" value="edit">Save</button>
                                                    </div>
                                                </form>
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

