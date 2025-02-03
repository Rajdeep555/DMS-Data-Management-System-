<?php

$table_name = 'users';
$redirection_page = "index.php?module=Profile&view=List";
$user_id = $_SESSION['user_id'];

// For Editing The Form

if (isset($_POST['edit'])) {

  $id       =  $_POST['id'];
  $field1    =  $_POST['field1'];
  $field2    =  $_POST['field2'];
  $field3    =  $_POST['field3'];
  $field4    =  $_POST['field4'];
  $field5    =  $_POST['field5'];
  $field6    =  $_POST['field6'];
  $field7    =  $_POST['field7'];
  $field8    =  $_POST['field8'];
  $field9    =  $_POST['field9'];
  $field10    =  $_POST['field10'];
  
     $password = md5($field6);

  //File Upload Codes Starts Here
  //1st 
  $allow = array("jpg", "JPG", "jpeg", "JPEG", "gif", "GIF", "png", "PNG", "pdf", "PDF");
  //1st File
  if ($_FILES['photo1']['name'] == "") {
    //echo "No Image"
  } else {

    $photo1 = basename($_FILES['photo1']['name']);
    $extension = pathinfo($photo1, PATHINFO_EXTENSION);
    if (in_array($extension, $allow)) {
      $target_path = "assets/uploads/";
      $photo1 = md5(rand() * time()) . '.' . $extension;
      $target_path = $target_path . $photo1;
      move_uploaded_file($_FILES['photo1']['tmp_name'], $target_path);
      $sql1 = ($photo1 != '') ? " user_image='$photo1' " . ',' : '';
    }
  }
if($field6 == $field7){
    
   
  $insert_bookings = "UPDATE `$table_name` SET
    $sql1
    user_fname        = '" . addslashes($field1) . "',   
    user_mname        = '" . addslashes($field2) . "',
    user_lname        = '" . addslashes($field3) . "', 
    user_role         = '" . addslashes($field5) . "',
    user_password     = '" . addslashes($password) . "', 
    user_desc         = '" . addslashes($field8) . "', 
    user_email        = '" . addslashes($field9) . "',   
    user_phone        = '" . addslashes($field10) . "'
    where id='" . $user_id . "'";


  $sql_insert = $dbconn->prepare($insert_bookings);
  $sql_insert->execute();

  $message = "Details successfully updated.";
  $status = "success";

  header("Location: $redirection_page&eid=$id");
}
}


$select_enquiry1 = "SELECT * FROM `$table_name` where status = 'Active' and id='$user_id'";
$sql1 = $dbconn->prepare($select_enquiry1);
$sql1->execute();
$wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd1 as $rows1);

$user_id = $rows1->id;
$user_fname = $rows1->user_fname;
$user_mname = $rows1->user_mname;
$user_lname = $rows1->user_lname;
$user_phone = $rows1->user_phone;
$user_email = $rows1->user_email;
$user_role = $rows1->user_role;
$user_pass = $rows1->user_password;
$user_desc = $rows1->user_desc;

?>

<style>
  :focus {
    outline: 0 !important;
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0) !important;
  }
</style>

<script>  
function matchPassword() {  
    //collect form data in JavaScript variables  
    var pw1 = document.getElementById("field6").value;  
    var pw2 = document.getElementById("field7").value;  


    if(pw1 != pw2)
  {	
  	alert("Passwords did not match");
  } 
}
</script>


<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <form id="formID" method="POST" action=""  enctype="multipart/form-data">
          <input class="form-control" name="id" type="hidden" value="<?php echo $user_id; ?>">
          <div class="card-body mb-0">
            <div class="accordion" id="accordionPanelsStayOpenExample">
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne" style="background-color:#e3dfde;color:black;">
                    Profile Informations
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-4">
                        <label><strong>First Name</strong> <span style="color:red;">*</span></label>
                        <input class="form-control" name="field1" type="text" value="<?php echo $user_fname; ?>" required>
                      </div>
                      <div class="col-md-4">
                        <label><strong>Middle Name</strong></label>
                        <input class="form-control" name="field2" type="text" value="<?php echo $user_mname; ?>">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Last Name</strong> <span style="color:red;">*</span></label>
                        <input class="form-control" name="field3" type="text" value="<?php echo $user_lname; ?>" required>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <label><strong>Upload Photo</strong></label>
                        <input class="form-control" name="photo1" type="file">
                      </div>
                      <div class="col-md-6">
                        <label><strong>Group</strong> <span style="color:red;">*</span></label>
                        <select class="form-select" name="field5" aria-label="Default select example" required>
                          <option selected><?php echo $user_role; ?></option>
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
                              <option value="<?php echo $user_grp_name; ?>"><?php echo $user_grp_name; ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <label><strong>Password</strong> <span style="color:red;">*</span></label>
                        <input class="form-control" name="field6" type="text" id="field6" value="<?php echo $user_pass; ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label><strong>Confirm Password</strong> <span style="color:red;">*</span></label>
                        <input class="form-control" name="field7" type="text" id="field7" value="<?php echo $user_pass; ?>" required>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-12">
                        <label><strong>Description</strong></label>
                        <textarea class="form-control" id="editor1" name="field8"><?php echo $user_desc; ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo" style="background-color:#e3dfde;color:black;">
                    Contact Informations
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <label><strong>Email</strong> <span style="color:red;">*</span></label>
                        <input class="form-control" name="field9" type="email" value="<?php echo $user_email; ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label><strong>Phone</strong> <span style="color:red;">*</span></label>
                        <input class="form-control" name="field10" type="tel" value="<?php echo $user_phone; ?>"  pattern="[0-9]{10}" required>
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
            <button class="btn  btn-md btn-success me-3" type="submit" name="edit" value="edit" onclick= matchPassword()>Save</button>
          </div>
          <div class="col-md-5"></div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>