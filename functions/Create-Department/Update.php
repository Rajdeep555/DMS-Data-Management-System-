<?php

$table_name = 'departments';
$redirection_page = "index.php?module=Create-Department&view=List";
$id = $_GET['id'];



// For Editing The Form

if (isset($_POST['edit'])) {

    $field1    =  $_POST['field1'];

    $insert_bookings = "UPDATE `$table_name` SET
    dept_name   = '" . addslashes($field1) . "'
    where id='" . $id . "'";


    $sql_insert = $dbconn->prepare($insert_bookings);
    $sql_insert->execute();

    $message = "Details successfully updated.";
    $status = "success";

    header("Location: $redirection_page&eid=$id");
}



$select_enquiry1 = "SELECT * FROM `$table_name` where status = 'Active' and id='$id'";
$sql1 = $dbconn->prepare($select_enquiry1);
$sql1->execute();
$wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd1 as $rows1);
$dept_name  = $rows1->dept_name;



// $select_bookings = "SELECT * FROM `application` where status = 'Active' and id='$module_application'";
// $sql12 = $dbconn->prepare($select_bookings);
// $sql12->execute();
// $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
// foreach ($wlvd12 as $rows12);
// $a_id = $rows12->id;
// $application_name = $rows12->application_name;

?>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Create-Department&view=List" aria-selected="true">Department</a>
                        <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;edit</i>Edit</a>

                    </div>
                </div>
                <form id="formID" method="POST" action="">
                    <div class="card-body mb-0">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" style="background-color:#e3dfde;color:black;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Edit Department
                                    </button>
                                </h2>

                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <input class="form-control" name="id" type="hidden" value="<?php echo $id; ?>" required>
                                        <div class="row mb-4">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-3"><label><strong>Department Name</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="field1" type="text" value="<?php echo $dept_name; ?>" required>
                                            </div>
                                            <div class="col-md-2"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer border-0 mb-0 pt-0">
                        <div class="row">
                            <div class="col-md-5"></div>
                            <div class="col-md-1">
                                <!-- <button type="button" class="btn btn-md btn-danger">Close</button> -->
                            </div>
                            <div class="col-md-1">
                                <button class="btn  btn-md btn-success me-3" type="submit" name="edit" value="edit">Submit</button>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>