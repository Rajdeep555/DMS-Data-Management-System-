<?php

$table_name = 'users';
$redirection_page = "index.php?module=Users&view=List";
$id = $_GET['id'];


// For Submitting The Form

if (isset($_POST['submit'])) {

  $field1     =  $_POST['field1'];
  $field2     =  $_POST['field2'];
  $field3     =  $_POST['field3'];
  $field4     =  $_POST['field4'];
  $field5     =  $_POST['field5'];
  $field6     =  $_POST['field6'];
  $field7     =  $_POST['field7'];
  $field8     =  $_POST['field8'];
  $field9     =  $_POST['field9'];
  $field10    =  $_POST['field10'];
  $field11    =  $_POST['field11'];
  $field12    =  $_POST['field12'];
  $field13    =  $_POST['field13'];
  $field14    =  $_POST['field14'];


  // if (isset($_POST["field15"])) {
  //   $covering_area = implode(',', $_POST["field15"]);
  // }

  $field16    =  $_POST['field16'];

  $select_enquiry121 = "SELECT * FROM `users` where status = 'Active' AND user_unique_id='$field16'";
  $sql121 = $dbconn->prepare($select_enquiry121);
  $sql121->execute();
  if ($sql121->rowCount() > 0) {
    $errormessage = "Employee ID already exist.";
    $error = "error";
  } else {

    $password = md5($field7);

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
    if ($field7 == $field8) {

      $insert_bookings = "INSERT `$table_name` SET
    $sql1
    user_unique_id      = '" . addslashes($field16) . "',   
    user_fname          = '" . addslashes($field1) . "',   
    user_mname          = '" . addslashes($field2) . "',
    user_lname          = '" . addslashes($field3) . "', 
    user_role           = '" . addslashes($field5) . "',
    user_password       = '" . addslashes($password) . "', 
    user_email          = '" . addslashes($field4) . "',   
    user_phone          = '" . addslashes($field10) . "', 
    user_country        = '" . addslashes($field11) . "',   
    user_state          = '" . addslashes($field12) . "',
    user_city           = '" . addslashes($field13) . "', 
    user_address        = '" . addslashes($field14) . "',
    status              = 'Active'";


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
  }
}

$select_enquiry12 = "SELECT * FROM `countries` where status = 'Active' order by id desc";
$sql12 = $dbconn->prepare($select_enquiry12);
$sql12->execute();
$wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);

?>

<script>
  function matchPassword() {
    var pw1 = document.getElementById("field7").value;
    var pw2 = document.getElementById("field8").value;


    if (pw1 != pw2) {
      alert("Passwords did not match");
    }
  }
</script>

<style>
  :focus {
    outline: 0 !important;
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 0) !important;
  }

  ::placeholder {
    color: rgb(188, 184, 183) !important;
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
              <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Users&view=List" aria-selected="true">Users</a>
              <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Users</a>
            </div>
          </nav>
        </div>
        <form id="formID" method="POST" action="" enctype="multipart/form-data" onsubmit="return validateForm()">
          <div class="card-body mb-0">
            <div class="accordion" id="accordionPanelsStayOpenExample">
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour" style="background-color:#e3dfde;color:black;">
                    Employee ID Generate
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFour">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-12">
                        <label><strong>Employee ID (Eg. MCI/0122/100)</strong> </label>
                        <input class="form-control" name="field16" type="text" placeholder="Unique Employee ID" required>
                        <?php if ($errormessage) { ?><span class=" text-danger"><?php echo $errormessage; ?></span><?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne" style="background-color:#e3dfde;color:black;">
                    Profile Informations
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>First Name</strong> </label>
                        <input class="form-control" name="field1" type="text" placeholder="First Name" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Middle Name</strong></label>
                        <input class="form-control" name="field2" type="text" placeholder="Middle Name">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Last Name</strong> </label>
                        <input class="form-control" name="field3" type="text" placeholder="Last Name" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="gender" value="male" required> Male
                          </label>
                          <label>
                            <input type="radio" name="gender" value="female" required> Female
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Designation</strong> </label>
                        <select class="form-select" name="field5" aria-label="Default select example" required>
                          <option selected disabled>Select User Role</option>
                          <?php
                          $select_bookings = "SELECT * FROM `groups` where status = 'Active' ORDER BY id ASC";
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
                      <div class="col-md-3">
                        <label><strong>Department</strong> </label>
                        <input class="form-control" name="field6" type="text" placeholder="Enter Department" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Login Password</strong> </label>
                        <input class="form-control" name="field7" type="text" placeholder="Enter Password" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Confirm Password</strong> </label>
                        <input class="form-control" name="field8" type="text" placeholder="Enter Confirm Password" required>
                      </div>
                    </div>

                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Date of Birth</strong></label>
                        <input class="form-control" name="field9" type="date" placeholder="Date of Birth">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Date of Joining</strong></label>
                        <input class="form-control" name="field10" type="date" placeholder="Date of Joining">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Date of Confirmation</strong></label>
                        <input class="form-control" name="field11" type="date" placeholder="Date of Confirmation">
                      </div>

                      <div class="col-md-3">
                        <label><strong>Date of Relieving</strong></label>
                        <input class="form-control" name="field12" type="date" placeholder="Date of Relieving">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingReporting">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseReporting" aria-expanded="false" aria-controls="panelsStayOpen-collapseReporting" style="background-color:#e3dfde;color:black;">
                    Reporting Informations
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseReporting" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingReporting">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Immediate Reporting</strong> </label>
                        <input class="form-control" name="immediate_reporting" type="text" placeholder="Immediate Reporting" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Reporting Manager</strong> </label>
                        <input class="form-control" name="reporting_manager" type="text" placeholder="Reporting Manager" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingContact">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseContact" aria-expanded="false" aria-controls="panelsStayOpen-collapseContact" style="background-color:#e3dfde;color:black;">
                    Contact Informations
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseContact" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingContact">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Official Email ID</strong></label>
                        <input class="form-control" name="official_email" type="email" placeholder="Enter Email">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Personal Email ID</strong></label>
                        <input class="form-control" name="personal_email" type="email" placeholder="Enter Email">
                      </div>

                      <div class="col-md-6">
                        <label><strong>Address for Communication (With Pincode)</strong></label>
                        <input class="form-control" name="afc" type="text" placeholder="Enter Address">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-5">
                        <label><strong>Permanent Address (With Pincode)</strong></label>
                        <input class="form-control" name="afc" type="text" placeholder="Enter Address">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Contact No. - Mobile</strong> </label>
                        <input class="form-control" name="field10" type="tel" placeholder="Enter Phone" pattern="[0-9]{10}" required>
                      </div>
                      <div class="col-md-4">
                        <label><strong>Contact No. - Landline (Area Code)</strong></label>
                        <input class="form-control" name="field10" type="tel" placeholder="Enter Phone">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-5">
                        <label><small style="font-weight: 600;">Contact Person's Name ( In case of emergency )</small></label>
                        <input class="form-control" name="afc" type="text" placeholder="Enter Address">
                      </div>
                      <div class="col-md-2">
                        <label><strong>Relation</strong></label>
                        <input class="form-control" name="field10" type="text" placeholder="Relation">
                      </div>
                      <div class="col-md-5">
                        <label><strong>Contact No. - (In case of emergency)</strong></label>
                        <input class="form-control" name="field10" type="tel" placeholder="Enter Phone">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!--others -->
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingOtherInfo">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOtherInfo" aria-expanded="false" aria-controls="panelsStayOpen-collapseOtherInfo" style="background-color:#e3dfde;color:black;">
                    Additional Information - 01
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOtherInfo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOtherInfo">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Blood Group</strong></label>
                        <select name="blood_group" class="form-select" required>
                          <option value="" disabled selected>Select Blood Group</option>
                          <option value="A+">A+</option>
                          <option value="A-">A-</option>
                          <option value="B+">B+</option>
                          <option value="B-">B-</option>
                          <option value="AB+">AB+</option>
                          <option value="AB-">AB-</option>
                          <option value="O+">O+</option>
                          <option value="O-">O-</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Qualification</strong> </label>
                        <input type="text" name="qualification" class="form-control" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Specialization</strong> </label>
                        <input type="text" name="specialization" class="form-control" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Certification (if any)</strong></label>
                        <input type="text" name="certification" class="form-control">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-4">
                        <label><strong>Previous Company Worked in</strong> </label>
                        <input type="text" name="previous_company" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><small style="font-weight: 600;">Total Years of Exp. in previous company</small></label>
                        <input type="text" name="total_years_of_exp" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Total Work Experience</strong></label>
                        <input type="text" name="total_work_experience" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <!-- bank details -->
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingAddress">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseAddress" aria-expanded="false" aria-controls="panelsStayOpen-collapseAddress" style="background-color:#e3dfde;color:black;">
                    Bank Details
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseAddress" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingAddress">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-4">
                        <label><strong>Bank Account No.</strong></label>
                        <input type="text" name="bank_account_no" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Bank Name</strong></label>
                        <input type="text" name="bank_name" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Bank Branch</strong></label>
                        <input type="text" name="bank_branch" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- additional info 02 -->
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingOtherInfo">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOtherInfo" aria-expanded="false" aria-controls="panelsStayOpen-collapseOtherInfo" style="background-color:#e3dfde;color:black;">
                    Additional Information - 02
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOtherInfo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOtherInfo">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>PAN No.</strong> </label>
                        <input type="text" name="pan_no" class="form-control" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Driving License No.</strong> </label>
                        <input type="text" name="driving_license_no" class="form-control" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>PF No.</strong></label>
                        <input type="text" name="pf_no" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Passport No.</strong></label>
                        <input type="text" name="passport_no" class="form-control">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Passport Issued at</strong></label>
                        <input type="time" name="passport_issued_at" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Passport Issued Date</strong></label>
                        <input type="date" name="passport_issued_date" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Passport Expired Date</strong></label>
                        <input type="date" name="passport_expired_date" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- additional info 02 ends -->

              <!-- additional info 02 -->
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingOtherInfo">
                  <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOtherInfo" aria-expanded="false" aria-controls="panelsStayOpen-collapseOtherInfo" style="background-color:#e3dfde;color:black;">
                    Additional Information - 03
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseOtherInfo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOtherInfo">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Father's Name</strong> </label>
                        <input type="text" name="father_name" class="form-control" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Mother's Name</strong> </label>
                        <input type="text" name="mother_name" class="form-control" required>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Marital Status</strong> </label>
                        <select name="marital_status" class="form-select" required>
                          <option value="" disabled selected>Select Marital Status</option>
                          <option value="single">Single</option>
                          <option value="married">Married</option>
                          <option value="divorced">Divorced</option>
                          <option value="widowed">Widowed</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Spouse's Name</strong></label>
                        <input type="text" name="pf_no" class="form-control">
                      </div>

                    </div>
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Child Name 1</strong></label>
                        <input type="text" name="passport_no" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="gender" value="male" required> Male
                          </label>
                          <label>
                            <input type="radio" name="gender" value="female" required> Female
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Child Name 2</strong></label>
                        <input type="text" name="child_name_2" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="gender" value="male" required> Male
                          </label>
                          <label>
                            <input type="radio" name="gender" value="female" required> Female
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Child Name 3</strong></label>
                        <input type="text" name="passport_no" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="gender" value="male" required> Male
                          </label>
                          <label>
                            <input type="radio" name="gender" value="female" required> Female
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Child Name 4</strong></label>
                        <input type="text" name="child_name_2" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="gender" value="male" required> Male
                          </label>
                          <label>
                            <input type="radio" name="gender" value="female" required> Female
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- additional info 02 ends -->


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
            <button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit" onclick="matchPassword()">Save</button>
          </div>
          <div class="col-md-5"></div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var preselectedCountry = document.querySelector('select[name="field11"]').value;
    showState(preselectedCountry);
  });

  function showState(str) {
    if (str == "") {
      document.getElementById("relatedState").innerHTML = "";
      return;
    }


    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("relatedState").innerHTML = this.responseText;
    }
    xhttp.open("GET", "controllers/ajax/show-state.php?q=" + str, true);
    xhttp.send();
  }


  function showCity(str) {
    if (str == "") {
      document.getElementById("relatedCity").innerHTML = "";
      return;
    }


    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("relatedCity").innerHTML = this.responseText;
    }
    xhttp.open("GET", "controllers/ajax/show-city.php?q=" + str, true);
    xhttp.send();
  }


  function showCityZone(str) {
    if (str == "") {
      document.getElementById("cityZone").innerHTML = "";
      return;
    }


    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("cityZone").innerHTML = this.responseText;
    }
    xhttp.open("GET", "controllers/ajax/city-zone.php?q=" + str, true);
    xhttp.send();
  }
</script>