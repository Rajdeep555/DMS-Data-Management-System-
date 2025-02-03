<?php

$table_name = 'state';
$redirection_page = "index.php?module=State&view=List";


// For Submitting The Form

if (isset($_POST['submit'])) {

   $field1    =  $_POST['field1'];
   $field2    =  $_POST['field2'];
   $field3    =  $_POST['field3'];


   $insert_bookings = "INSERT `$table_name` SET
     sta_state_name   = '" . ucwords($field1) . "', 
     st_country_id   = '" . addslashes($field2) . "',   
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
         header("Location: index.php?module=State&view=Create&submit=1");
      }
   } else {
      echo 'error';
      print_r($sql_insert->errorInfo()); 
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
                        <a class="nav-item nav-link  btn btn-lg" href="index.php?module=State&view=List" aria-selected="true">State</a>
                     <?php
                     }
                     if ($Create == '1') {
                     ?>
                        <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New State</a>
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
                              State
                           </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                           <div class="accordion-body">
                              <div class="row mb-4">
                                 <div class="col-md-6">
                                    <label><strong> Select Country </strong> <span style="color:red;">*</span></label>

                                    <select class="form-control" name="field2">
                                       <option selected disabled>--- Select countries --- </option>

                                       <?php
                                       $select_enquiry1 = "SELECT * FROM `countries` where status = 'Active'";
                                       $sql1 = $dbconn->prepare($select_enquiry1);
                                       $sql1->execute();
                                       $wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
                                       foreach ($wlvd1 as $rows1) {
                                       ?>
                                          <option value="<?= $rows1->id; ?>"><?= $rows1->countries_name; ?></option>

                                       <?php
                                       }
                                       ?>
                                    </select>

                                 </div>


                                 <div class="col-md-6">
                                    <label><strong> State Name</strong> <span style="color:red;">*</span></label>

                                    <input class="form-control" placeholder="Enter State Name ...." name="field1">
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