<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<style>
  .button {
    position: relative;
    float: right;
    background-color: #7366ff;
    /* Green */
    border: none;
    color: white;
    text-align: center;
    padding: 10px 20px 10px 20px;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
  }

  .button2 {
    background-color: #7366ff;
    color: white;
    border: 2px solid #7366ff;
  }

  .button2:hover {
    background-color: #7366ff;
    color: white;
  }
</style>
<?php
ob_start();
include('../../settings/database.php');
DB::connect();



// For Submitting The Form

// if (isset($_GET['submit1'])) {
//   $field = $_GET['field'];

//   for ($i = 1; $i <= $_GET['menuid']; $i++) {


//     if (!empty($_GET['menuid'])) {

//       // $list = isset($_GET['list'.$i][0]) ? 1 : 0;
//       // $update = isset($_GET['update'.$i][0]) ? 1 : 0;
//       // $create = isset($_GET['create'.$i][0]) ? 1 : 0;
//       // $delete = isset($_GET['delete'.$i][0]) ? 1 : 0;
//       // $check = isset($_GET['check'.$i][0]) ? 1 : 0;

//       // echo $i;
//       // echo $field;
//       // echo $list;
//       // echo $update;
//       // echo $create;
//       // echo $delete;
//       // echo $check;

//       // echo '<br>';


//       $insert_bookings = "INSERT `$table_name` SET  
//       mod_per_user_role   = '" . addslashes($_GET['field']) . "',
//       mod_per_module_id   = '" . addslashes($i) . "',
//       mod_per_view        = '" . addslashes(isset($_GET['list' . $i][0]) ? $i : 0) . "',
//       mod_per_update      = '" . addslashes(isset($_GET['update' . $i][0]) ? $i : 0) . "',
//       mod_per_create      = '" . addslashes(isset($_GET['create' . $i][0]) ? $i : 0) . "',
//       mod_per_delete      = '" . addslashes(isset($_GET['delete' . $i][0]) ? $i : 0) . "',
//       status   = 'Active'";


//       $sql_insert = $dbconn->prepare($insert_bookings);
//       $sql_insert->execute();
//     }
//   }
//   $myid = $dbconn->lastInsertId();

//   $message = "Details successfully updated.";
//   $status = "success";
//   if ($myid) {
//     header("Location: $redirection_page&id=$myid");
//   } else {
//     print_r($this->pdo->errorInfo());
//   }
// }

$field  = $_GET['field'];

$select_enquiry1 = "SELECT * FROM `module_permission` where status = 'Active' and mod_per_user_role='$field' order by id asc";
$sql1 = $dbconn->prepare($select_enquiry1);
$sql1->execute();
$wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);


if ($sql1->rowCount() > 0) {

  echo '
              <thead>
                <tr class="border-bottom-primary">
                  <th scope="col">Id</th>
                  <th scope="col">Application</th>
                  <th scope="col">Module</th>
                  <th scope="col">View</th>
                  <th scope="col">Update</th>
                  <th scope="col">Create</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>';


  $i = 1;
  $select_bookings = "SELECT * FROM `module` where `status` = 'Active' ";
  $sql12 = $dbconn->prepare($select_bookings);
  $sql12->execute();
  $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
  if ($sql12->rowCount() > 0) {
    foreach ($wlvd12 as $rows12) {
      $module_id     = $rows12->id;
      $module_name   = $rows12->module_name;
      $module_application   = $rows12->module_application;
      //   $module_group = $rows12->module_group;

      $select_bookings = "SELECT * FROM `application` where `status` = 'Active' and `id`='$module_application' ";
      $sql13 = $dbconn->prepare($select_bookings);
      $sql13->execute();
      $wlvd13 = $sql13->fetchAll(PDO::FETCH_OBJ);
      foreach ($wlvd13 as $rows13);
      $application_name   = $rows13->application_name;

      $select_enquiry1 = "SELECT * FROM `module_permission` where status = 'Active' and mod_per_user_role='$field' and mod_per_module_id='$module_id' order by id asc";
      $sql1 = $dbconn->prepare($select_enquiry1);
      $sql1->execute();
      $wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
      foreach ($wlvd1 as $rows1);
      $field1 = $rows1->id;
      $field2 = $rows1->mod_per_module_id;
      $field3 = $rows1->mod_per_user_role;
      $field4 = $rows1->mod_per_all;
      $field5 = $rows1->mod_per_view;
      $field6 = $rows1->mod_per_update;
      $field7 = $rows1->mod_per_create;
      $field8 = $rows1->mod_per_delete;


      echo '<tr>
                    <td>' . $module_id . '</td>
                    <td>' . $module_name . '</td>
                    <td>' . $application_name . '</td>
               
                        <input type="hidden" name="menuid" value="' . $module_id . '">
                  
                    
                    <td><input class="form-check-input" type="checkbox" name="list' . $module_id . '" id="checkbox_4" value="1" ';
      if ($field5 == '1') {
      echo 'checked';
      }
      echo '></td>
                    <td><input class="form-check-input" type="checkbox" name="update' . $module_id . '" id="checkbox_4" value="1"';
                    if ($field6 == '1') {
                    echo 'checked';
                    }
                    echo '></td>
                    <td><input class="form-check-input" type="checkbox" name="create' . $module_id . '" id="checkbox_4" value="1"';
                    if ($field7 == '1') {
                    echo 'checked';
                    }
                    echo '></td>
                    <td><input class="form-check-input" type="checkbox" name="delete' . $module_id . '" id="checkbox_4" value="1"';
                    if ($field8 == '1') {
                    echo 'checked';
                    }
                    echo '>
                     </tr>';
    }
  }
  echo '</tbody>';



  echo '

            
           
           
            ';
} else {

  echo '
              <thead>
                <tr class="border-bottom-primary">
                  <th scope="col">Id</th>
                  <th scope="col">Application</th>
                  <th scope="col">Module</th>
                  <th scope="col">View</th>
                  <th scope="col">Update</th>
                  <th scope="col">Create</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>';

  $i = 1;
  $select_bookings = "SELECT * FROM `module` where `status` = 'Active' ";
  $sql12 = $dbconn->prepare($select_bookings);
  $sql12->execute();
  $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
  if ($sql12->rowCount() > 0) {
    foreach ($wlvd12 as $rows12) {
      $module_id     = $rows12->id;
      $module_name   = $rows12->module_name;
      $module_application   = $rows12->module_application;
      $module_group = $rows12->module_group;

      $select_bookings = "SELECT * FROM `application` where `status` = 'Active' and `id`='$module_application' ";
      $sql13 = $dbconn->prepare($select_bookings);
      $sql13->execute();
      $wlvd13 = $sql13->fetchAll(PDO::FETCH_OBJ);
      foreach ($wlvd13 as $rows13);
      $application_name   = $rows13->application_name;


      echo '<tr>
                    <td>' . $module_id . '</td>
                    <td>' . $module_name . '</td>
                    <td>' . $application_name . '</td>
               
                        <input type="hidden" name="menuid" value="' . $module_id . '">
                        
                     
                       
                    
                    <td><input class="form-check-input" type="checkbox" name="list' . $module_id . '" id="checkbox_4" value="1"></td>
                    <td><input class="form-check-input" type="checkbox" name="update' . $module_id . '" id="checkbox_4" value="1"></td>
                    <td><input class="form-check-input" type="checkbox" name="create' . $module_id . '" id="checkbox_4" value="1"></td>
                    <td><input class="form-check-input" type="checkbox" name="delete' . $module_id . '" id="checkbox_4" value="1"></td>
                     </tr>
              </tbody>';
    }
  }


  echo '


            
        
            ';
}
