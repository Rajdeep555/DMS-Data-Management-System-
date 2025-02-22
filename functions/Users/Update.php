    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <?php
    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $table_name = 'users';
    $redirection_page = "index.php?module=Users&view=List";
    $user_id = $_GET['id'] ?? null;

    if ($user_id) {
      $getData = "SELECT * FROM users WHERE id = :user_id";
      $stmt = $dbconn->prepare($getData);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) {
        die("User not found.");
      }

      $selected_role = $user['user_role']; // This should be the column storing the role
      $selected_department = $user['user_department'] ?? ''; // Assuming field6 stores the department

    } else {
      die("Invalid or missing user ID.");
    }




    function generateUserOptions($dbconn, $role, $selectedValue = null)
    {
      $query = "SELECT * FROM users WHERE user_role = :role";
      $stmt = $dbconn->prepare($query);
      $stmt->bindParam(':role', $role);
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_OBJ);

      $options = "";
      foreach ($users as $user) {
        $selected = ($user->id == $selectedValue) ? "selected" : "";
        $options .= '<option value="' . htmlspecialchars($user->id) . '" ' . $selected . '>' . htmlspecialchars($user->user_fname) . ' ' . htmlspecialchars($user->user_mname) . ' ' . htmlspecialchars($user->user_lname) . '</option>';
      }
      return $options;
    }


    $errormessage = "";

    if (isset($_POST['submit'])) {
      $user_unique_id = $_POST['user_unique_id'];


      // phto upload 

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
          $sql2 = ($photo1 != '') ? " user_image='$photo1' " . ',' : '';
        }
      }


      // Fetch form fields
      $field1 = $_POST['field1'];
      $field2 = $_POST['field2'];
      $field3 = $_POST['field3'];
      $field4 = $_POST['field4'];
      $field5 = $_POST['field5'];
      $field6 = $_POST['field6'];
      $hashed_password = md5($_POST['field7']);
      $confirm_password = md5($_POST['field8']);
      $field9 = $_POST['field9'];
      $field10 = $_POST['field10'];
      $field11 = $_POST['field11'];
      $field12 = $_POST['field12'];
      $field13 = $_POST['field13'];
      $field14 = $_POST['field14'];
      $field15 = $_POST['field15'];
      $field16 = $_POST['field16'];
      $field17 = $_POST['field17'];
      $field18 = $_POST['field18'];
      $field19 = $_POST['field19'];
      $field20 = $_POST['field20'];
      $field21 = $_POST['field21'];
      $field22 = $_POST['field22'];
      $field23 = $_POST['field23'];
      $field24 = $_POST['field24'];
      $field25 = $_POST['field25'];
      $field26 = $_POST['field26'];
      $field27 = $_POST['field27'];
      $field28 = $_POST['field28'];
      $field29 = $_POST['field29'];
      $field30 = $_POST['field30'];
      $field31 = $_POST['field31'];
      $field32 = $_POST['field32'];
      $field33 = $_POST['field33'];
      $field34 = $_POST['field34'];
      $field35 = $_POST['field35'];
      $field36 = $_POST['field36'];
      $field37 = $_POST['field37'];
      $field38 = $_POST['field38'];
      $field39 = $_POST['field39'];
      $field40 = $_POST['field40'];
      $field41 = $_POST['field41'];
      $field42 = $_POST['field42'];
      $field43 = $_POST['field43'];
      $field44 = $_POST['field44'];
      $field45 = $_POST['field45'];
      $field46 = $_POST['field46'];
      $field47 = $_POST['field47'];
      $field48 = $_POST['field48'];
      $field49 = $_POST['gm'];
      $field50 = $_POST['dgm'];
      $field51 = $_POST['rsm'];
      $field52 = $_POST['asm'];
      $field53 = $_POST['tsm'];

      // Ensure password confirmation matches
      if ($hashed_password === $confirm_password) {
        $update_query = "UPDATE users SET
            $sql2
            user_fname = :field1,
            user_mname = :field2,
            user_lname = :field3,
            user_gender = :field4,
            user_role = :field5,
            user_department = :field6,
            user_password = :hashed_password,
            dob = :field9,
            doj = :field10,
            doc = :field11,
            dor = :field12,
            immediate_reporting = :field13,
            reporting_manager = :field14,
            official_email = :field15,
            personal_email = :field16,
            afc = :field17,
            permanent_address = :field18,
            user_phone = :field19,
            landline = :field20,
            contact_per_emergency = :field21,
            emergency_relation = :field22,
            emergency_p_num = :field23,
            blood_group = :field24,
            qualification = :field25,
            specialization = :field26,
            certification = :field27,
            previous_company = :field28,
            total_years_of_exp = :field29,
            total_work_experience = :field30,
            bank_account_no = :field31,
            bank_name = :field32,
            bank_branch = :field33,
            pan_no = :field34,
            driving_license_no = :field35,
            pf_no = :field36,
            passport_no = :field37,
            passport_issued_at = :field38,
            passport_issued_date = :field39,
            passport_expired_date = :field40,
            father_name = :field41,
            mother_name = :field42,
            marital_status = :field43,
            spouse_name = :field44,
            child_one = :field45,
            child_one_gender = :field46,
            child_two = :field47,
            child_two_gender = :field48,
            gm = :field49,
            dgm = :field50,
            rsm = :field51,
            asm = :field52,
            tsm = :field53
            WHERE user_unique_id = :user_unique_id";
        $stmt = $dbconn->prepare($update_query);

        // Bind all values explicitly
        $stmt->bindParam(':field1', $field1);
        $stmt->bindParam(':field2', $field2);
        $stmt->bindParam(':field3', $field3);
        $stmt->bindParam(':field4', $field4);
        $stmt->bindParam(':field5', $field5);
        $stmt->bindParam(':field6', $field6);
        $stmt->bindParam(':hashed_password', $hashed_password);
        $stmt->bindParam(':field9', $field9);
        $stmt->bindParam(':field10', $field10);
        $stmt->bindParam(':field11', $field11);
        $stmt->bindParam(':field12', $field12);
        $stmt->bindParam(':field13', $field13);
        $stmt->bindParam(':field14', $field14);
        $stmt->bindParam(':field15', $field15);
        $stmt->bindParam(':field16', $field16);
        $stmt->bindParam(':field17', $field17);
        $stmt->bindParam(':field18', $field18);
        $stmt->bindParam(':field19', $field19);
        $stmt->bindParam(':field20', $field20);
        $stmt->bindParam(':field21', $field21);
        $stmt->bindParam(':field22', $field22);
        $stmt->bindParam(':field23', $field23);
        $stmt->bindParam(':field24', $field24);
        $stmt->bindParam(':field25', $field25);
        $stmt->bindParam(':field26', $field26);
        $stmt->bindParam(':field27', $field27);
        $stmt->bindParam(':field28', $field28);
        $stmt->bindParam(':field29', $field29);
        $stmt->bindParam(':field30', $field30);
        $stmt->bindParam(':field31', $field31);
        $stmt->bindParam(':field32', $field32);
        $stmt->bindParam(':field33', $field33);
        $stmt->bindParam(':field34', $field34);
        $stmt->bindParam(':field35', $field35);
        $stmt->bindParam(':field36', $field36);
        $stmt->bindParam(':field37', $field37);
        $stmt->bindParam(':field38', $field38);
        $stmt->bindParam(':field39', $field39);
        $stmt->bindParam(':field40', $field40);
        $stmt->bindParam(':field41', $field41);
        $stmt->bindParam(':field42', $field42);
        $stmt->bindParam(':field43', $field43);
        $stmt->bindParam(':field44', $field44);
        $stmt->bindParam(':field45', $field45);
        $stmt->bindParam(':field46', $field46);
        $stmt->bindParam(':field47', $field47);
        $stmt->bindParam(':field48', $field48);
        $stmt->bindParam(':field49', $field49);
        $stmt->bindParam(':field50', $field50);
        $stmt->bindParam(':field51', $field51);
        $stmt->bindParam(':field52', $field52);
        $stmt->bindParam(':field53', $field53);
        $stmt->bindParam(':user_unique_id', $user_unique_id, PDO::PARAM_INT);

        // Execute query
        if ($stmt->execute()) {
          header("Location: $redirection_page&sid=$user_unique_id");
          exit();
        } else {
          echo 'Error updating record';
        }
      } else {
        echo 'Passwords do not match';
      }
    }
    ?>

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
            <form id="formID" method="POST" action="" enctype="multipart/form-data">
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
                            <input class="form-control" name="user_unique_id" type="text" value="<?= $user['user_unique_id'] ?>" placeholder="Unique Employee ID" required readonly>
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
                            <input class="form-control" name="field1" type="text" value="<?= $user['user_fname'] ?>" placeholder="First Name">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Middle Name</strong></label>
                            <input class="form-control" name="field2" type="text" value="<?= $user['user_mname'] ?>" placeholder="Middle Name">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Last Name</strong> </label>
                            <input class="form-control" name="field3" type="text" value="<?= $user['user_lname'] ?>" placeholder="Last Name">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Gender</strong></label>
                            <div>
                              <label>
                                <input type="radio" name="field4" value="male" <?= ($user['user_gender'] === 'male') ? 'checked' : ''; ?>> Male
                              </label>
                              <label>
                                <input type="radio" name="field4" value="female" <?= ($user['user_gender'] === 'female') ? 'checked' : ''; ?>> Female
                              </label>
                            </div>
                          </div>

                        </div>
                        <div class="row mb-4">
                          <div class="col-md-3">
                            <label><strong>Designation</strong></label>
                            <select class="form-select" id="designationSelect" name="field5" aria-label="Default select example">
                              <option disabled>Select User Role</option>
                              <?php
                              $select_roles = "SELECT * FROM `groups` WHERE status = 'Active' ORDER BY id ASC";
                              $sql11 = $dbconn->prepare($select_roles);
                              $sql11->execute();
                              $roles = $sql11->fetchAll(PDO::FETCH_OBJ);

                              if ($sql11->rowCount() > 0) {
                                foreach ($roles as $role) {
                                  $user_grp_name = $role->user_grp_name;

                                  // Exclude certain roles
                                  if (
                                    $user_grp_name !== 'Assistant Vice Pesident(SM)' &&
                                    $user_grp_name !== 'Deputy Vice President(SM)' &&
                                    $user_grp_name !== 'Vice President(Sales & Marketing)'
                                  ) {
                                    $selected = ($user_grp_name === $selected_role) ? "selected" : ""; // Check if selected
                              ?>
                                    <option value="<?= htmlspecialchars($user_grp_name); ?>" <?= $selected; ?>>
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
                              <option disabled>Select Department</option>
                              <?php
                              // Query to select departments from the database
                              $select_departments = "SELECT * FROM `departments` WHERE status = 'Active' ORDER BY id ASC";
                              $sql_departments = $dbconn->prepare($select_departments);
                              $sql_departments->execute();
                              $departments = $sql_departments->fetchAll(PDO::FETCH_OBJ);

                              // Loop through the results and create options
                              foreach ($departments as $department) {
                                $dept_name = htmlspecialchars($department->dept_name);
                                $selected = ($dept_name === $selected_department) ? 'selected' : ''; // Check if it's the user's department
                                echo "<option value=\"$dept_name\" $selected>$dept_name</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label><strong>Login Password</strong> </label>
                            <input class="form-control" name="field7" type="text" value="<?= $user['user_password'] ?>" placeholder="Enter Password">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Confirm Password</strong> </label>
                            <input class="form-control" name="field8" type="password" value="<?= $user['user_password'] ?>" placeholder="Enter Confirm Password">
                          </div>
                        </div>

                        <div class="row mb-4">
                          <div class="col-md-3">
                            <label><strong>Date of Birth</strong></label>
                            <input class="form-control" name="field9" type="date" value="<?= $user['dob'] ?>" placeholder="Date of Birth">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Date of Joining</strong></label>
                            <input class="form-control" name="field10" type="date" value="<?= $user['doj'] ?>" placeholder="Date of Joining">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Date of Confirmation</strong></label>
                            <input class="form-control" name="field11" type="date" value="<?= $user['doc'] ?>" placeholder="Date of Confirmation">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Date of Relieving</strong></label>
                            <input class="form-control" name="field12" type="date" value="<?= $user['dor'] ?>" placeholder="Date of Relieving">
                          </div>
                          <div class="col-md-3 mt-3">
                            <label><strong>Profile Photo</strong></label>
                            <input class="form-control" name="photo1" type="file" value="<?= $user['user_image'] ?>">
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
                              <?= generateUserOptions($dbconn, 'General Manager', $user['gm']); ?>
                            </select>
                          </div>
                          <div class="col-md-3" id="dgmDiv">
                            <label><strong>Select DGM</strong></label>
                            <select class="form-control" name="dgm">
                              <option value="">Select DGM</option>
                              <?= generateUserOptions($dbconn, 'Deputy General Manager', $user['dgm']); ?>
                            </select>
                          </div>
                          <div class="col-md-3" id="rsmDiv">
                            <label><strong>Select RSM</strong></label>
                            <select class="form-control" name="rsm">
                              <option value="">Select RSM</option>
                              <?= generateUserOptions($dbconn, 'Regional Sales Manager', $user['rsm']); ?>
                            </select>
                          </div>
                          <div class="col-md-3" id="asmDiv">
                            <label><strong>Select ASM</strong></label>
                            <select class="form-control" name="asm">
                              <option value="">Select ASM</option>
                              <?= generateUserOptions($dbconn, 'Area Sales Manager', $user['asm']); ?>
                            </select>
                          </div>
                        </div>

                        <div class="row mb-4">
                          <div class="col-md-3" id="tsmDiv">
                            <label><strong>Select TSM</strong></label>
                            <select class="form-control" name="tsm">
                              <option value="">Select TSM</option>
                              <?= generateUserOptions($dbconn, 'Territory Sales Manager', $user['tsm']); ?>
                            </select>
                          </div>
                          <div class="col-md-3">
                            <label><strong>Immediate Reporting</strong> </label>
                            <input class="form-control" name="field13" type="text" value="<?= $user['immediate_reporting'] ?>" placeholder="Immediate Reporting">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Reporting Manager</strong> </label>
                            <input class="form-control" name="field14" type="text" value="<?= $user['reporting_manager'] ?>" placeholder="Reporting Manager">
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
                            <input class="form-control" name="field15" type="email" value="<?= $user['official_email'] ?>" placeholder="Enter Email">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Personal Email ID</strong></label>
                            <input class="form-control" name="field16" type="email" value="<?= $user['personal_email'] ?>" placeholder="Enter Email">
                          </div>

                          <div class="col-md-6">
                            <label><strong>Address for Communication (With Pincode)</strong></label>
                            <input class="form-control" name="field17" type="text" value="<?= $user['afc'] ?>" placeholder="Enter Address">
                          </div>
                        </div>
                        <div class="row mb-4">
                          <div class="col-md-5">
                            <label><strong>Permanent Address (With Pincode)</strong></label>
                            <input class="form-control" name="field18" type="text" value="<?= $user['permanent_address'] ?>" placeholder="Enter Address">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Contact No. - Mobile</strong> </label>
                            <input class="form-control" name="field19" type="tel" value="<?= $user['user_phone'] ?>" placeholder="Enter Phone" pattern="[0-9]{10}">
                          </div>
                          <div class="col-md-4">
                            <label><strong>Contact No. - Landline (Area Code)</strong></label>
                            <input class="form-control" name="field20" type="tel" placeholder="Enter Phone" value="<?= $user['landline'] ?>">
                          </div>
                        </div>
                        <div class="row mb-4">
                          <div class="col-md-5">
                            <label><small style="font-weight: 600;">Contact Person's Name ( In case of emergency )</small></label>
                            <input class="form-control" name="field21" type="text" value="<?= $user['contact_per_emergency'] ?>" placeholder="Enter Address">
                          </div>
                          <div class="col-md-2">
                            <label><strong>Relation</strong></label>
                            <input class="form-control" name="field22" type="text" value="<?= $user['emergency_relation'] ?>" placeholder="Relation">
                          </div>
                          <div class="col-md-5">
                            <label><strong>Contact No. - (In case of emergency)</strong></label>
                            <input class="form-control" name="field23" type="tel" placeholder="Enter Phone" value="<?= $user['emergency_p_num'] ?>">
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
                              <option value="" disabled>Select Blood Group</option>
                              <option value="A+" <?= ($user['blood_group'] == "A+") ? 'selected' : '' ?>>A+</option>
                              <option value="A-" <?= ($user['blood_group'] == "A-") ? 'selected' : '' ?>>A-</option>
                              <option value="B+" <?= ($user['blood_group'] == "B+") ? 'selected' : '' ?>>B+</option>
                              <option value="B-" <?= ($user['blood_group'] == "B-") ? 'selected' : '' ?>>B-</option>
                              <option value="AB+" <?= ($user['blood_group'] == "AB+") ? 'selected' : '' ?>>AB+</option>
                              <option value="AB-" <?= ($user['blood_group'] == "AB-") ? 'selected' : '' ?>>AB-</option>
                              <option value="O+" <?= ($user['blood_group'] == "O+") ? 'selected' : '' ?>>O+</option>
                              <option value="O-" <?= ($user['blood_group'] == "O-") ? 'selected' : '' ?>>O-</option>
                            </select>

                          </div>
                          <div class="col-md-3">
                            <label><strong>Qualification</strong> </label>
                            <input type="text" value="<?= $user['qualification'] ?>" name="field25" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Specialization</strong> </label>
                            <input type="text" value="<?= $user['specialization'] ?>" name="field26" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Certification (if any)</strong></label>
                            <input type="text" value="<?= $user['certification'] ?>" name="field27" class="form-control">
                          </div>
                        </div>
                        <div class="row mb-4">
                          <div class="col-md-4">
                            <label><strong>Previous Company Worked in</strong> </label>
                            <input type="text" value="<?= $user['previous_company'] ?>" name="field28" class="form-control">
                          </div>
                          <div class="col-md-4">
                            <label><small style="font-weight: 600;">Total Years of Exp. in previous company</small></label>
                            <input type="text" value="<?= $user['total_years_of_exp'] ?>" name="field29" class="form-control">
                          </div>
                          <div class="col-md-4">
                            <label><strong>Total Work Experience</strong></label>
                            <input type="text" value="<?= $user['total_work_experience'] ?>" name="field30" class="form-control">
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
                            <input type="text" value="<?= $user['bank_account_no'] ?>" name="field31" class="form-control">
                          </div>
                          <div class="col-md-4">
                            <label><strong>Bank Name</strong></label>
                            <input type="text" value="<?= $user['bank_name'] ?>" name="field32" class="form-control">
                          </div>
                          <div class="col-md-4">
                            <label><strong>Bank Branch</strong></label>
                            <input type="text" value="<?= $user['bank_branch'] ?>" name="field33" class="form-control">
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
                            <input type="text" value="<?= $user['pan_no'] ?>" name="field34" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Driving License No.</strong> </label>
                            <input type="text" value="<?= $user['driving_license_no'] ?>" name="field35" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>PF No.</strong></label>
                            <input type="text" value="<?= $user['pf_no'] ?>" name="field36" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Passport No.</strong></label>
                            <input type="text" value="<?= $user['passport_no'] ?>" name="field37" class="form-control">
                          </div>
                        </div>
                        <div class="row mb-4">
                          <div class="col-md-3">
                            <label><strong>Passport Issued at</strong></label>
                            <input type="time" value="<?= $user['passport_issued_at'] ?>" name="field38" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Passport Issued Date</strong></label>
                            <input type="date" name="field39" value="<?= $user['passport_issued_date'] ?>" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Passport Expired Date</strong></label>
                            <input type="date" name="field40" value="<?= $user['passport_expired_date'] ?>" class="form-control">
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
                            <input type="text" value="<?= $user['father_name'] ?>" name="field41" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Mother's Name</strong> </label>
                            <input type="text" value="<?= $user['mother_name'] ?>" name="field42" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Marital Status</strong> </label>
                            <select name="field43" class="form-select" onchange="toggleSpouseAndChildren()">
                              <option value="" disabled>Select Marital Status</option>
                              <option value="single" <?= ($user['marital_status'] == "single") ? 'selected' : '' ?>>Single</option>
                              <option value="married" <?= ($user['marital_status'] == "married") ? 'selected' : '' ?>>Married</option>
                              <option value="divorced" <?= ($user['marital_status'] == "divorced") ? 'selected' : '' ?>>Divorced</option>
                              <option value="widowed" <?= ($user['marital_status'] == "widowed") ? 'selected' : '' ?>>Widowed</option>
                            </select>
                          </div>

                          <div class="col-md-3" id="spouseName">
                            <label><strong>Spouse's Name</strong></label>
                            <input type="text" value="<?= $user['spouse_name'] ?>" name="field44" class="form-control">
                          </div>
                        </div>

                        <div class="row mb-4" id="childrenInfo">
                          <div class="col-md-3">
                            <label><strong>Child Name 1</strong></label>
                            <input type="text" value="<?= $user['child_one'] ?>" name="field45" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Gender</strong> </label>
                            <div>
                              <label>
                                <input type="radio" name="field46" value="male" <?= ($user['child_one_gender'] == "male") ? 'checked' : '' ?>> Male
                              </label>
                              <label>
                                <input type="radio" name="field46" value="female" <?= ($user['child_one_gender'] == "female") ? 'checked' : '' ?>> Female
                              </label>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label><strong>Child Name 2</strong></label>
                            <input type="text" value="<?= $user['child_two'] ?>" name="field47" class="form-control">
                          </div>
                          <div class="col-md-3">
                            <label><strong>Gender</strong> </label>
                            <div>
                              <label>
                                <input type="radio" name="field48" value="male" <?= ($user['child_two_gender'] == "male") ? 'checked' : '' ?>> Male
                              </label>
                              <label>
                                <input type="radio" name="field48" value="female" <?= ($user['child_two_gender'] == "female") ? 'checked' : '' ?>> Female
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
                <button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit">Update</button>
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
        if (!confirm("Are you sure you want to submit?")) {
          e.preventDefault();
        }

        // Swal.fire({
        //   title: "Are you sure?",
        //   text: "Do you really want to submit the form?",
        //   icon: "warning",
        //   showCancelButton: true,
        //   confirmButtonColor: "#3085d6",
        //   cancelButtonColor: "#d33",
        //   confirmButtonText: "Yes, submit it!"
        // }).then((result) => {
        //   if (result.isConfirmed) {
        //     this.submit(); 
        //   }
        // });
      })
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