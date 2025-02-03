<?php

$table_name = 'group_mapping';
$redirection_page = "index.php?module=Groups Mapping&view=List";
$id = $_REQUEST['id'];

// For Submitting The Form

if (isset($_GET['submit'])) {

    $field1    =  $_GET['field1'];
    $field2    =  $_GET['field2'];

    for ($i = 0; $i < count($_GET['field3']); $i++) {
        $a = implode(', ', $_GET['field3']);
    }
    $insert_bookings = "INSERT `$table_name` SET
                grp_map_group   = '" . addslashes($field2) . "',
                grp_map_sub_group   = '" . addslashes($a) . "',
                status   = 'Active'";

    $sql_insert = $dbconn->prepare($insert_bookings);
    $sql_insert->execute();
    $myid = $dbconn->lastInsertId();

    $message = "Details successfully updated.";
    $status = "success";
    if ($myid) {
        header("Location: $redirection_page&eid=$myid");
    } else {
        echo 'error';
    }
}

$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active'";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd as $rows) ;

?>

<style>
    :focus {
        outline: 0 !important;
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0) !important;
    }
</style>


<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Groups Mapping&view=List" aria-selected="true">Group Mapping</a>
                            <a class="nav-item nav-link active btn btn-lg" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;edit</i>Edit</a>
                        </div>
                    </nav>
                </div>
                <form id="formID" method="GET" action="">
                    <div class="card-body mb-0">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" style="background-color:#e3dfde;color:black;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Edit
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <input type="hidden" name="module" class="form-control m-input border-0" value="Groups Mapping">
                                        <input type="hidden" name="view" class="form-control m-input border-0" value="Create">
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong> Parent Group</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <select class="form-select" name="field2" aria-label="Default select example">
                                                    <option selected value="<?php echo $user_grp_name; ?>><?php echo $rows->grp_map_group; ?></option>
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
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Sub Group</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <div id="inputFormRow">
                                                    <div class="input-group mb-3">
                                                        <?php $i = 1; ?>
                                                        <!-- <input type="text" name="count[]" class="form-control m-input border-0" value="<?php echo $i; ?>">
                                                        <select class="form-select" name="field3[]" aria-label="Default select example">
                                                            <option selected disabled>Select Sub Group</option> -->
                                                            <?php
                                                            // $select_bookings = "SELECT * FROM `groups` where status = 'Active'";
                                                            // $sql11 = $dbconn->prepare($select_bookings);
                                                            // $sql11->execute();
                                                            // $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                                                            // if ($sql11->rowCount() > 0) {
                                                            //     foreach ($wlvd11 as $rows11) {
                                                            //         $user_grp_id = $rows11->id;
                                                            //         $user_grp_name = $rows11->user_grp_name;
                                                            ?>
                                                                    <!-- <option value="<?php echo $user_grp_id; ?>"><?php echo $user_grp_name; ?></option> -->
                                                            <?php
                                                            //     }
                                                            // }
                                                            ?>
                                                        </select>
                                                        <!-- <input type="text" name="title[]" class="form-control m-input" placeholder="Sub Group" autocomplete="off"> -->
                                                        <!-- <div class="input-group-append">
                                                            <button id="removeRow" type="button" class="btn btn-danger">X</button>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div id="newRow"></div>
                                                <button id="addRow" type="button" class="btn btn-info">Add Row</button>
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


<script type="text/javascript">
    var i = 1;
    // add row
    $("#addRow").click(function() {
        

        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="count[]" class="form-control m-input border-0" value="' + i + '"> ';
        html += '<select class="form-select" name="field3[]" aria-label="Default select example">';
        html += ' <option selected disabled>Select Sub Group</option>';
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
                html += '   <option value="<?php echo $user_grp_id; ?>"><?php echo $user_grp_name; ?></option>';
        <?php
            }
        } ?>
        html += ' </select>';

        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">X</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
        i++;
    });

    // remove row
    $(document).on('click', '#removeRow', function() {
        i--;
        $(this).closest('#inputFormRow').remove();
    });
</script>