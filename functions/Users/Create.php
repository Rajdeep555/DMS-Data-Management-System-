<?php
// Enable error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$table_name = 'users';
$redirection_page = "index.php?module=Users&view=List";
// $id = $_GET['id'];

$errormessage = "";




function generateUserOptions($dbconn, $role)
{
  $options = "";
  $sql = "SELECT user_unique_id, user_fname, user_mname, user_lname FROM users WHERE user_role = :role AND status = 'Active'";

  $stmt = $dbconn->prepare($sql);
  $stmt->bindParam(':role', $role, PDO::PARAM_STR);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($users) > 0) {
    foreach ($users as $row) {
      $fullName = trim("{$row['user_fname']} {$row['user_mname']} {$row['user_lname']}");
      $options .= "<option value='{$row['user_unique_id']}'>{$fullName}</option>";
    }
  } else {
    $options = "<option value=''>No Active Users</option>";
  }

  return $options;
}


// For Submitting The Form

if (isset($_POST['submit'])) {
  $user_unique_id = $_POST['user_unique_id'];
  $field1     =  $_POST['field1']; // First Name
  $field2     =  $_POST['field2']; // Middle Name
  $field3     =  $_POST['field3']; // Last Name
  $field4     =  $_POST['field4']; // Gender
  $field5     =  $_POST['field5']; // Designation
  $field6     =  $_POST['field6']; // Department
  $field7     =  $_POST['field7']; // Login Password
  $field8     =  $_POST['field8']; // Confirm Password
  $field9     =  $_POST['field9']; // Date of Birth
  $field10    =  $_POST['field10']; // Date of Joining
  $field11    =  $_POST['field11']; // Date of Confirmation
  $field12    =  $_POST['field12']; // Date of Relieving
  $field13    =  $_POST['field13']; // Immediate Reporting
  $field14    =  $_POST['field14']; // Reporting Manager
  $field15    =  $_POST['field15']; // Official Email ID
  $field16    =  $_POST['field16']; // Personal Email ID
  $field17    =  $_POST['field17']; // Address for Communication
  $field18    =  $_POST['field18']; // Permanent Address
  $field19    =  $_POST['field19']; // Contact No. - Mobile
  $field20    =  $_POST['field20']; // Contact No. - Landline
  $field21    =  $_POST['field21']; // Contact Person's Name
  $field22    =  $_POST['field22']; // Relation
  $field23    =  $_POST['field23']; // Contact No. - (In case of emergency)
  $field24    =  $_POST['field24']; // Blood Group
  $field25    =  $_POST['field25']; // Qualification
  $field26    =  $_POST['field26']; // Specialization
  $field27    =  $_POST['field27']; // Certification
  $field28    =  $_POST['field28']; // Previous Company Worked in
  $field29    =  $_POST['field29']; // Total Years of Experience
  $field30    =  $_POST['field30']; // Total Work Experience
  $field31    =  $_POST['field31']; // Bank Account No.
  $field32    =  $_POST['field32']; // Bank Name
  $field33    =  $_POST['field33']; // Bank Branch
  $field34    =  $_POST['field34']; // PAN No.
  $field35    =  $_POST['field35']; // Driving License No.
  $field36    =  $_POST['field36']; // PF No.
  $field37    =  $_POST['field37']; // Passport No.
  $field38    =  $_POST['field38']; // Passport Issued at
  $field39    =  $_POST['field39']; // Passport Issued Date
  $field40    =  $_POST['field40']; // Passport Expired Date
  $field41    =  $_POST['field41']; // Father's Name
  $field42    =  $_POST['field42']; // Mother's Name
  $field43    =  $_POST['field43']; // Marital Status
  $field44    =  $_POST['field44']; // Spouse's Name
  $field45    =  $_POST['field45']; // Child Name 1
  $field46    =  $_POST['field46']; // Child Name 2
  $field47    =  $_POST['field47']; // Child Name 3
  $field48    =  $_POST['field48']; // Child Name 4
  $field49    =  $_POST['field49']; // Child Name 5
  $field50    =  $_POST['field50']; // Child Name 6
  $field51    =  $_POST['field51']; // Child Name 7
  $field52    =  $_POST['field52']; // Child Name 8

  $field53    =  $_POST['gm']; //gm 
  $field54    =  $_POST['agm']; //dgm
  $field55    =  $_POST['rsm']; //rsm
  $field56    =  $_POST['asm']; //asm
  $field57    =  $_POST['tsm']; //tsmx

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
      user_unique_id      = '" . addslashes($user_unique_id) . "',   
      user_fname          = '" . addslashes($field1) . "',   
      user_mname          = '" . addslashes($field2) . "',
      user_lname          = '" . addslashes($field3) . "', 
      user_gender         = '" . addslashes($field4) . "',
      user_role           = '" . addslashes($field5) . "',
      user_department     = '" . addslashes($field6) . "',
      user_password       = '" . addslashes($password) . "', 
      dob                 = '" . addslashes($field9) . "',
      doj                 = '" . addslashes($field10) . "',
      doc                 = '" . addslashes($field11) . "',
      dor                 = '" . addslashes($field12) . "',
      immediate_reporting = '" . addslashes($field13) . "',
      reporting_manager   = '" . addslashes($field14) . "',
      official_email      = '" . addslashes($field15) . "',
      personal_email      = '" . addslashes($field16) . "',
      afc                 = '" . addslashes($field17) . "',
      permanent_address   = '" . addslashes($field18) . "',
      user_phone          = '" . addslashes($field19) . "',
      landline            = '" . addslashes($field20) . "',
      contact_per_emergency = '" . addslashes($field21) . "',
      emergency_relation  = '" . addslashes($field22) . "',
      emergency_p_num     = '" . addslashes($field23) . "',
      blood_group         = '" . addslashes($field24) . "',
      qualification       = '" . addslashes($field25) . "',
      specialization      = '" . addslashes($field26) . "',
      certification       = '" . addslashes($field27) . "',
      previous_company    = '" . addslashes($field28) . "',
      total_years_of_exp     = '" . addslashes($field29) . "',
      total_work_experience      = '" . addslashes($field30) . "',
      bank_account_no     = '" . addslashes($field31) . "',
      bank_name           = '" . addslashes($field32) . "',
      bank_branch         = '" . addslashes($field33) . "',
      pan_no              = '" . addslashes($field34) . "',
      driving_license_no  = '" . addslashes($field35) . "',
      pf_no               = '" . addslashes($field36) . "',
      passport_no         = '" . addslashes($field37) . "',
      passport_issued_at  = '" . addslashes($field38) . "',
      passport_issued_date = '" . addslashes($field39) . "',
      passport_expired_date = '" . addslashes($field40) . "',
      father_name         = '" . addslashes($field41) . "',
      mother_name         = '" . addslashes($field42) . "',
      marital_status      = '" . addslashes($field43) . "',
      spouse_name         = '" . addslashes($field44) . "',
      child_one         = '" . addslashes($field45) . "',
      child_one_gender         = '" . addslashes($field49) . "',
      child_two         = '" . addslashes($field46) . "',
      child_two_gender         = '" . addslashes($field50) . "',
      child_three         = '" . addslashes($field47) . "',
      child_three_gender         = '" . addslashes($field51) . "',
      child_four         = '" . addslashes($field48) . "',
      child_four_gender         = '" . addslashes($field52) . "',
      gm         = '" . addslashes($field53) . "',
      dgm         = '" . addslashes($field54) . "',
      rsm         = '" . addslashes($field55) . "',
      asm         = '" . addslashes($field56) . "',
      tsm         = '" . addslashes($field57) . "',
      status              = 'Active'";

      $sql_insert = $dbconn->prepare($insert_bookings);
      $sql_insert->execute();
      $myid = $dbconn->lastInsertId();

      $message = "Details successfully updated.";
      $status = "success";
      if ($myid) {
        // Redirect to avoid form resubmission
        header("Location: $redirection_page&sid=$myid");
        exit(); // Ensure no further code is executed after the redirect
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
                        <input class="form-control" name="user_unique_id" type="text" placeholder="Unique Employee ID" required>
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
                        <label><strong>First Name</strong></label>
                        <input class="form-control" name="field1" type="text" placeholder="First Name">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Middle Name</strong></label>
                        <input class="form-control" name="field2" type="text" placeholder="Middle Name">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Last Name</strong> </label>
                        <input class="form-control" name="field3" type="text" placeholder="Last Name">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="field4" value="male"> Male
                          </label>
                          <label>
                            <input type="radio" name="field4" value="female"> Female
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Designation</strong></label>
                        <select class="form-select" id="designationSelect" name="field5" aria-label="Default select example">
                          <option selected disabled>Select User Role</option>
                          <?php
                          $select_bookings = "SELECT * FROM `groups` WHERE status = 'Active' ORDER BY id ASC";
                          $sql11 = $dbconn->prepare($select_bookings);
                          $sql11->execute();
                          $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                          if ($sql11->rowCount() > 0) {
                            foreach ($wlvd11 as $rows11) {
                              $user_grp_name = $rows11->user_grp_name;
                              if (
                                $user_grp_name !== 'Assistant Vice Pesident(SM)' &&
                                $user_grp_name !== 'Deputy Vice President(SM)' &&
                                $user_grp_name !== 'Vice President(Sales & Marketing)'
                              ) {
                          ?>
                                <option value="<?= htmlspecialchars($user_grp_name); ?>">
                                  <?= htmlspecialchars($user_grp_name); ?>
                                </option>
                          <?php
                              }
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Department</strong> </label>
                        <select class="form-select" name="field6" aria-label="Select Department">
                          <option selected disabled>Select Department</option>
                          <?php
                          // Query to select departments from the database
                          $select_departments = "SELECT * FROM `departments` WHERE status = 'Active' ORDER BY id ASC";
                          $sql_departments = $dbconn->prepare($select_departments);
                          $sql_departments->execute();
                          $departments = $sql_departments->fetchAll(PDO::FETCH_OBJ);

                          // Loop through the results and create options
                          foreach ($departments as $department) {
                            echo '<option value="' . htmlspecialchars($department->dept_name) . '">' . htmlspecialchars($department->dept_name) . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Login Password</strong> </label>
                        <input class="form-control" name="field7" type="text" placeholder="Enter Password">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Confirm Password</strong> </label>
                        <input class="form-control" name="field8" type="password" placeholder="Enter Confirm Password">
                      </div>
                    </div>

                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Date of Birth</strong></label>
                        <input class="form-control" name="field9" type="date">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Date of Joining</strong></label>
                        <input class="form-control" name="field10" type="date">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Date of Confirmation</strong></label>
                        <input class="form-control" name="field11" type="date">
                      </div>

                      <div class="col-md-3">
                        <label><strong>Date of Relieving</strong></label>
                        <input class="form-control" name="field12" type="date">
                      </div>
                      <div class="col-md-3 mt-3">
                        <label><strong>Profile Photo</strong></label>
                        <input class="form-control" name="photo1" type="file">
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
                      <div class="col-md-3" id="gmDiv">
                        <label><strong>Select GM</strong></label>
                        <select class="form-control" name="gm">
                          <option value="">Select GM</option>
                          <?= generateUserOptions($dbconn, 'General Manger'); ?>
                        </select>
                      </div>
                      <div class="col-md-3" id="dgmDiv">
                        <label><strong>Select DGM</strong></label>
                        <select class="form-control" name="dgm">
                          <option value="">Select DGM</option>
                          <?= generateUserOptions($dbconn, 'Deputy General Manager'); ?>
                        </select>
                      </div>
                      <div class="col-md-3" id="rsmDiv">
                        <label><strong>Select RSM</strong></label>
                        <select class="form-control" name="rsm">
                          <option value="">Select RSM</option>
                          <?= generateUserOptions($dbconn, 'Regional Sales Manager'); ?>
                        </select>
                      </div>
                      <div class="col-md-3" id="asmDiv">
                        <label><strong>Select ASM</strong></label>
                        <select class="form-control" name="asm">
                          <option value="">Select ASM</option>
                          <?= generateUserOptions($dbconn, 'Area Sales Manager'); ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mb-4">
                      <div class="col-md-3" id="tsmDiv">
                        <label><strong>Select TSM</strong></label>
                        <select class="form-control" name="tsm">
                          <option value="">Select TSM</option>
                          <?= generateUserOptions($dbconn, 'Territory Sales Manager'); ?>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Immediate Reporting</strong> </label>
                        <input class="form-control" name="field13" type="text" placeholder="Immediate Reporting">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Reporting Manager</strong> </label>
                        <input class="form-control" name="field14" type="text" placeholder="Reporting Manager">
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
                        <input class="form-control" name="field15" type="email" placeholder="Enter Email">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Personal Email ID</strong></label>
                        <input class="form-control" name="field16" type="email" placeholder="Enter Email">
                      </div>

                      <div class="col-md-6">
                        <label><strong>Address for Communication (With Pincode)</strong></label>
                        <input class="form-control" name="field17" type="text" placeholder="Enter Address">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-5">
                        <label><strong>Permanent Address (With Pincode)</strong></label>
                        <input class="form-control" name="field18" type="text" placeholder="Enter Address">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Contact No. - Mobile</strong> </label>
                        <input class="form-control" name="field19" type="tel" placeholder="Enter Phone" pattern="[0-9]{10}">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Contact No. - Landline (Area Code)</strong></label>
                        <input class="form-control" name="field20" type="tel" placeholder="Enter Phone">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-5">
                        <label><small style="font-weight: 600;">Contact Person's Name ( In case of emergency )</small></label>
                        <input class="form-control" name="field21" type="text" placeholder="Enter Address">
                      </div>
                      <div class="col-md-2">
                        <label><strong>Relation</strong></label>
                        <input class="form-control" name="field22" type="text" placeholder="Relation">
                      </div>
                      <div class="col-md-5">
                        <label><strong>Contact No. - (In case of emergency)</strong></label>
                        <input class="form-control" name="field23" type="tel" placeholder="Enter Phone">
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
                        <select name="field24" class="form-select">
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
                        <input type="text" name="field25" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Specialization</strong> </label>
                        <input type="text" name="field26" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Certification (if any)</strong></label>
                        <input type="text" name="field27" class="form-control">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-4">
                        <label><strong>Previous Company Worked in</strong> </label>
                        <input type="text" name="field28" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><small style="font-weight: 600;">Total Years of Exp. in previous company</small></label>
                        <input type="text" name="field29" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Total Work Experience</strong></label>
                        <input type="text" name="field30" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- bank details -->
              <div class="accordion-item border mb-2">
                <h2 class="accordion-header" id="panelsStayOpen-headingAddress">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseAddress" aria-expanded="false" aria-controls="panelsStayOpen-collapseAddress" style="background-color:#e3dfde;color:black;">
                    Bank Details
                  </button>
                </h2>
                <div id="panelsStayOpen-collapseAddress" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingAddress">
                  <div class="accordion-body">
                    <div class="row mb-4">
                      <div class="col-md-4">
                        <label><strong>Bank Account No.</strong></label>
                        <input type="text" name="field31" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Bank Name</strong></label>
                        <input type="text" name="field32" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label><strong>Bank Branch</strong></label>
                        <input type="text" name="field33" class="form-control">
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
                        <input type="text" name="field34" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Driving License No.</strong> </label>
                        <input type="text" name="field35" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>PF No.</strong></label>
                        <input type="text" name="field36" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Passport No.</strong></label>
                        <input type="text" name="field37" class="form-control">
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-3">
                        <label><strong>Passport Issued at</strong></label>
                        <input type="text" name="field38" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Passport Issued Date</strong></label>
                        <input type="date" name="field39" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Passport Expired Date</strong></label>
                        <input type="date" name="field40" class="form-control">
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
                        <input type="text" name="field41" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Mother's Name</strong> </label>
                        <input type="text" name="field42" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Marital Status</strong> </label>
                        <select name="field43" class="form-select" onchange="toggleSpouseAndChildren()">
                          <option value="" disabled selected>Select Marital Status</option>
                          <option value="single">Single</option>
                          <option value="married">Married</option>
                          <option value="divorced">Divorced</option>
                          <option value="widowed">Widowed</option>
                        </select>
                      </div>
                      <div class="col-md-3" id="spouseName" style="display:none;">
                        <label><strong>Spouse's Name</strong></label>
                        <input type="text" name="field44" class="form-control">
                      </div>
                    </div>

                    <div class="row mb-4" id="childrenInfo" style="display:none;">
                      <div class="col-md-3">
                        <label><strong>Child Name 1</strong></label>
                        <input type="text" name="field45" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="field49" value="male"> Male
                          </label>
                          <label>
                            <input type="radio" name="field49" value="female"> Female
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Child Name 2</strong></label>
                        <input type="text" name="field46" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="field50" value="male"> Male
                          </label>
                          <label>
                            <input type="radio" name="field50" value="female"> Female
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4" id="childrenInfo" style="display:none;">
                      <div class="col-md-3">
                        <label><strong>Child Name 3</strong></label>
                        <input type="text" name="field47" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="field51" value="male"> Male
                          </label>
                          <label>
                            <input type="radio" name="field51" value="female"> Female
                          </label>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label><strong>Child Name 4</strong></label>
                        <input type="text" name="field48" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label><strong>Gender</strong> </label>
                        <div>
                          <label>
                            <input type="radio" name="field52" value="male"> Male
                          </label>
                          <label>
                            <input type="radio" name="field52" value="female"> Female
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- additional info 03 ends -->
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
            <button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit" onclick="matchPassword()">Submit</button>
          </div>
          <div class="col-md-5"></div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.getElementById("formID").addEventListener("submit", (e) => {
    if (!confirm("Are you sure ?")) {
      e.preventDefault();
    }
  })
</script>
<script>
  $(document).ready(function() {
    // Initially hide all select fields
    $("#gmDiv, #dgmDiv, #rsmDiv, #asmDiv, #tsmDiv").hide();

    $("#designationSelect").change(function() {
      var selectedRole = $(this).val();

      // Hide all dropdowns initially
      $("#gmDiv, #dgmDiv, #rsmDiv, #asmDiv, #tsmDiv").hide();

      if (selectedRole === "General Manger") {
        // If GM is selected, show nothing below
      } else if (selectedRole === "Deputy General Manager") {
        $("#gmDiv").show();
      } else if (selectedRole === "Regional Sales Manager") {
        $("#gmDiv, #dgmDiv").show();
      } else if (selectedRole === "Area Sales Manager") {
        $("#gmDiv, #dgmDiv, #rsmDiv").show();
      } else if (selectedRole === "Territory Sales Manager") {
        $("#gmDiv, #dgmDiv, #rsmDiv, #asmDiv").show();
      } else if (selectedRole === "Sales Officer") {
        // Show all dropdowns when Sales Officer is selected
        $("#gmDiv, #dgmDiv, #rsmDiv, #asmDiv, #tsmDiv").show();
      }
    });
  });
</script>

<script>
  function toggleSpouseAndChildren() {
    var maritalStatus = document.querySelector('select[name="field43"]').value;
    var spouseDiv = document.getElementById("spouseName");
    var childrenDiv = document.getElementById("childrenInfo");

    if (maritalStatus === "single") {
      spouseDiv.style.display = "none";
      childrenDiv.style.display = "none";
    } else if (maritalStatus === "divorced") {
      spouseDiv.style.display = "none";
      childrenDiv.style.display = "block"; // Show children inputs
    } else {
      spouseDiv.style.display = "block"; // Show spouse input for married and widowed
      childrenDiv.style.display = "block"; // Show children inputs
    }
  }
</script>