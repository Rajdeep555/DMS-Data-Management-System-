<?php

$table_name = 'state';
$redirection_page = "index.php?module=State&view=List";
$id = $_REQUEST['id'];


// For Editing The Form

if (isset($_POST['edit'])) {

   $field1    =  $_POST['field1'];
   $field2    =  $_POST['field2'];
   $field3    =  $_POST['field3'];
   $field4    =  $_POST['field4'];
   $field5    =  $_POST['field5'];
   $field6    =  $_POST['field6'];
   $field7    =  $_POST['field7'];

   $insert_bookings = "UPDATE `$table_name` SET
   sta_state_name   = '" . ucwords($field1) . "'
    where id='" . $id . "'";


   $sql_insert = $dbconn->prepare($insert_bookings);
   $sql_insert->execute();

   $message = "Details successfully updated.";
   $status = "success";

   header("Location: $redirection_page&eid=$id");
}

$select_enquiry1 = "SELECT * FROM `$table_name` where status = 'Active' and `id`='$id'";
$sql1 = $dbconn->prepare($select_enquiry1);
$sql1->execute();
$wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd1 as $rows1);
$sta_state_name  = $rows1->sta_state_name;
$st_country_id = $rows1->st_country_id;

$select_enquiry11 = "SELECT * FROM `countries` where status = 'Active' and `id`='$st_country_id'";
$sql11 = $dbconn->prepare($select_enquiry11);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd11 as $rows11);
$countries_name  = $rows11->countries_name;

?>




<!-- user details form start from here -->
<div class="container-fluid" style=" height:75vh; ">
   <div class="row">
      <div class="col-md-12">
         <div class="card" style="border-radius: 0;">
            <div class="card-header border-0">
               <nav style="font-size:20px;">
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                     <?php
                     if ($List == '1') {
                     ?>
                        <a class="nav-item nav-link  btn btn-lg" href="index.php?module=State&view=List" aria-selected="true">State</a>
                     <?php
                     }
                     if ($Update == '1') {
                     ?>
                        <a class="nav-item nav-link active btn  btn-lg text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;edit</i>Edit</a>
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
                              Update State Name
                           </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                           <div class="accordion-body">

                              <div class="row mb-4">
                                 <div class="col-md-6">
                                    <label><strong>  Country </strong> <span style="color:red;"></span></label>

                                    <input class="form-control" name="field2" type="text" value=" <?php echo $countries_name; ?> " readonly>

                                 </div>


                                 <div class="col-md-6">
                                    <label><strong> State Name</strong> <span style="color:red;">*</span></label>

                                    <input class="form-control" name="field1" type="text" value=" <?php echo $rows1->sta_state_name; ?> " required>
                                 </div>

                              </div>


                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="card-footer border-0 mb-0 pt-0">
                     <div class="row">
                        <div class="col-md-12 text-center">
                           <button style="background: #896afe;color:#fff; " class="btn  btn-md btn-success me-3" type="submit" name="edit" value="edit">Save</button>
                        </div>

                     </div>
                  </div>
            </form>
         </div>
      </div>
   </div>
   </form>
</div>