<?php

$table_name = 'location';
$redirection_page = "index.php?module=City&view=List";


// For Submitting The Form

if (isset($_POST['submit'])) {

   $field1    =  $_POST['field1'];
   $field2    =  $_POST['field2'];
   $field3    =  $_POST['field3'];
   $field4    =  $_POST['field4'];



   $insert_bookings = "INSERT `$table_name` SET
     loc_city_name   = '" . ucwords($field1) . "',   
     loc_sate_id   = '" . addslashes($field2) . "', 
     loc_countries_id   = '" . addslashes($field3) . "',   
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
         header("Location: index.php?module=City&view=Create&submit=1");
      }
   } else {
      echo 'error';
   }
}

$select_sate_location2 = "SELECT * FROM `countries` where status = 'Active'";
$sql12 = $dbconn->prepare($select_sate_location2);
$sql12->execute();
$wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd12 as $rows12);



$select_sate_location = "SELECT * FROM `state` where status = 'Active'";
$sql1 = $dbconn->prepare($select_sate_location);
$sql1->execute();
$wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd1 as $rows1);


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
                     if ($Create == '1') {
                     ?>
                        <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New City</a>
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
                                    <select name="field3" class="form-control" id="field2" value="" placeholder="Enter Company Type ">
                                       <option selected disabled>--Select Countries--- </option>
                                       <?php
                                       foreach ($wlvd12 as $rows12) {
                                       ?>
                                          <option value="<?php echo $rows12->id; ?>">
                                             <?php echo $rows12->countries_name;  ?></option>

                                       <?php  } ?>
                                    </select>

                                    <input class="form-control" type="hidden" value="<?php echo $rows12->id; ?>">

                                 </div>

                                 <div class="col-md-4">
                                    <label><strong><span style="color:red;">*</span>state</strong> </label>
                                    <select name="field2" class="form-control" id="field2" value="" placeholder="Enter Company Type ">
                                       <option selected disabled>--Select state--- </option>
                                       <?php
                                       foreach ($wlvd1 as $rows1) {
                                       ?>

                                          <option value="<?php echo $rows1->id; ?>">
                                             <?php echo $rows1->sta_state_name;  ?></option>


                                       <?php  } ?>
                                    </select>
                                 </div>

                                 <div class="col-md-4">
                                    <label><strong><span style="color:red;">*</span>City Name</strong> </label>
                                    <input class="form-control" name="field1" type="text" placeholder="Enter City Name" required>
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