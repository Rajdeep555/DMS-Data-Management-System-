<?php

$table_name = 'countries';
$redirection_page = "index.php?module=Countries&view=List";


// For Submitting The Form

if (isset($_POST['submit'])) {

    $field1    =  $_POST['field1'];
    $field2    =  $_POST['field2'];
    $field3    =  $_POST['field3'];


    $insert_bookings = "INSERT `$table_name` SET
     countries_name   = '" . addslashes($field1) . "',   
     status   = 'Active'";


    $sql_insert = $dbconn->prepare($insert_bookings);
    $sql_insert->execute();
    $myid = $dbconn->lastInsertId();

    $message = "Details successfully updated.";
    $status = "success";
    if ($myid) {
        if ($List == '1') {
            header("Location: $redirection_page&sid=$myid");
        } else {
            header("Location: index.php?module=Countries&view=Create&submit=1");
        }
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
                            <?php
                            if ($List == '1') {
                            ?>
                                <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Countries&view=List" aria-selected="true">Countries</a>
                            <?php
                            }
                            if ($Create == '1') {
                            ?>
                                <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Countries</a>
                            <?php
                            }
                            ?>
                        </div>
                    </nav>
                </div>
                <form id="formID" method="POST" action="">
                    <div class="card-body mb-0">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item border mb-2">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne" style="background-color:#e3dfde;color:black;">
                                        Countries
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <label><strong>Countries Name</strong> <span style="color:red;">*</span></label>
                                                <input class="form-control" name="field1" type="text" placeholder="Enter Countries Name" required>
                                            </div>
                                        </div>


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
                        <button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit">Submit</button>
                    </div>
                    <div class="col-md-5"></div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>