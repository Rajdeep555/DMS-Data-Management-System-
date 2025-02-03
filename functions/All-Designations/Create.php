<?php

$table_name = 'module';
$redirection_page = "index.php?module=Module&view=List";


// For Submitting The Form

if (isset($_POST['submit'])) {

    $field1    =  $_POST['field1'];
     $field2    =  $_POST['field2'];
  
    $insert_bookings = "INSERT `$table_name` SET
    module_name   = '" . addslashes($field1) . "',   
    module_application   = '" . addslashes($field2) . "',
    status   = 'Active'";
  
  
    $sql_insert = $dbconn->prepare($insert_bookings);
    $sql_insert->execute();
    $myid = $dbconn->lastInsertId();
  
    $message = "Details successfully updated.";
    $status = "success";
    if ($myid) {
      header("Location: $redirection_page&sid=$myid");
    } else {
      echo 'error';
    }
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
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Module&view=List" aria-selected="true">Module</a>
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Module</a>
                        </div>
                    </nav>
                </div>
                <form id="formID" method="POST" action="">
                <div class="card-body mb-0">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" style="background-color:#e3dfde;color:black;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        New Module
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Module Name</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="field1" type="text" placeholder="Module Name" required>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Application </strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <select class="form-select" name="field2" aria-label="Default select example">
                                                    <option selected disabled>Select Application</option>
                                                    <?php
                                                        $select_bookings= "SELECT * FROM `application` where `status` = 'Active' ";
                                                        $sql11=$dbconn->prepare($select_bookings);
                                                        $sql11->execute();
                                                        $wlvd11=$sql11->fetchAll(PDO::FETCH_OBJ);
                                                        if($sql11->rowCount() > 0){
                                                        foreach($wlvd11 as $rows11){
                                                        $application_id = $rows11->id;
                                                        $application_name = $rows11->application_name;
                                                    ?>
                                                        <option value="<?=$application_id ?>"><?=$application_name ?></option>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </select>
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
                                <button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit">Save</button>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

