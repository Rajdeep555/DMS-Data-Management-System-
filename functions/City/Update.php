<?php

$table_name = 'location';
$redirection_page = "index.php?module=City&view=List";
$id = $_GET['id'];

// For Submitting The Form

if (isset($_POST['edit'])) {

   $id         =  $_POST['id'];
   $field2    =  $_POST['field2'];
   $field3    =  $_POST['field3'];
   $field4    =  $_POST['field4'];


   $insert_bookings = "UPDATE `$table_name` SET
  loc_city_name   = '" . ucwords($field1) . "',   
     loc_sate_id   = '" . addslashes($field2) . "', 
     loc_countries_id   = '" . addslashes($field3) . "'
     where id = '$id'";


   $sql_insert = $dbconn->prepare($insert_bookings);
   $sql_insert->execute();
   $myid = $dbconn->lastInsertId();

   $message = "Details successfully updated.";
   $status = "success";
   header("Location: $redirection_page&eid=$id");
}


$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' and id='$id'";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd as $rows);
$loc_sate_id = $rows->loc_sate_id;
$loc_countries_id = $rows->loc_countries_id;

$select_sate_location = "SELECT * FROM `state` where status = 'Active' and id='$loc_sate_id'";
$sql11 = $dbconn->prepare($select_sate_location);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd11 as $rows11);
$sta_state_name = $rows11->sta_state_name;


$select_sate_location = "SELECT * FROM `countries` where status = 'Active' and id='$loc_countries_id'";
$sql111 = $dbconn->prepare($select_sate_location);
$sql111->execute();
$wlvd111 = $sql111->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd111 as $rows111);
$countries_name = $rows111->countries_name;

// $select_sate_location = "SELECT * FROM `state` where status = 'Active'";
// $sql1 = $dbconn->prepare($select_sate_location);
// $sql1->execute();
// $wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
// foreach ($wlvd1 as $rows1);

// $select_sate_location2 = "SELECT * FROM `countries` where status = 'Active'";
// $sql12 = $dbconn->prepare($select_sate_location2);
// $sql12->execute();
// $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
// foreach ($wlvd12 as $rows12);



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
                        <a class="nav-item nav-link  btn btn-lg" href="index.php?module=City&view=List" aria-selected="true">City</a>
                     <?php
                     }
                     if ($Update == '1') {
                     ?>
                        <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;edit</i>Edit</a>
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
                              City
                           </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                           <div class="accordion-body">
                              <div class="row mb-4">

                                 <div class="col-md-4">
                                    <label><strong><span style="color:red;">*</span>Countries Name</strong> </label>
                                    <input class="form-control" name="field3" type="text" value=" <?php echo $countries_name; ?> " readonly>
                                 </div>

                                 <div class="col-md-4">
                                    <label><strong><span style="color:red;">*</span>state</strong> </label>
                                    <input class="form-control" name="field2" type="text" value=" <?php echo $sta_state_name; ?> " readonly>
                                 </div>

                                 <div class="col-md-4">
                                    <label><strong><span style="color:red;">*</span>City Name</strong> </label>
                                    <input class="form-control" name="field1" type="text" placeholder="Enter City Name" required value="<?= $rows->loc_city_name; ?>">
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
                  <button class="btn  btn-md btn-success me-3" type="submit" name="edit" value="edit">Save</button>
               </div>
               <div class="col-md-5"></div>
            </div>
         </div>
         </form>
      </div>
   </div>
</div>
</div>