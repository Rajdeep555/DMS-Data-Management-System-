<?php

$table_name = 'module_permission';
$redirection_page = "index.php?module=Permissions&view=List";
$action_name = "module=Permissions&view=List";

// For Submitting The Form

if (isset($_GET['submit1'])) {
  $field = $_GET['field'];

  for ($i = 1; $i <= $_GET['menuid']; $i++) {


    if (!empty($_GET['menuid'])) {

      $list = isset($_GET['list' . $i][0]) ? 1 : 0;
      $update = isset($_GET['update' . $i][0]) ? 1 : 0;
      $create = isset($_GET['create' . $i][0]) ? 1 : 0;
      $delete = isset($_GET['delete' . $i][0]) ? 1 : 0;

      $delete_statement = "UPDATE `$table_name` SET
   status   = 'Inactive'
   where mod_per_module_id='$i' and mod_per_user_role='$field'";


      $sql_insert = $dbconn->prepare($delete_statement);
      $sql_insert->execute();

      // echo $i;
      // echo $field;
      // echo $list;
      // echo $update;
      // echo $create;
      // echo $delete;
      // echo $check;

      // echo '<br>';


      $insert_bookings = "INSERT `$table_name` SET  
      mod_per_user_role   = '" . addslashes($_GET['field']) . "',
      mod_per_module_id   = '" . addslashes($i) . "',
      mod_per_view        = '" . addslashes($list) . "',
      mod_per_update      = '" . addslashes($update) . "',
      mod_per_create      = '" . addslashes($create) . "',
      mod_per_delete      = '" . addslashes($delete) . "',
      status   = 'Active'";


      $sql_insert = $dbconn->prepare($insert_bookings);
      $sql_insert->execute();
    }
  }
  $myid = $dbconn->lastInsertId();

  $message = "Details successfully updated.";
  $status = "success";
  if ($myid) {
    header("Location: $redirection_page&sid=$myid");
  } else {
    // print_r($this->pdo->errorInfo());
  }
}

if (isset($_GET['sid'])) {
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo '<script type="text/javascript">';
  echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Created successfully"
    });';
  echo '</script>';
} elseif (isset($_GET['eid'])) {
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo '<script type="text/javascript">';
  echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Edited successfully"
    });';
  echo '</script>';
}


?>

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header border-0">
          <nav style="font-size:20px;">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active btn btn-lg text-primary" href="" aria-selected="true">Permissions</a>
              <!-- <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Permissions&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Add Permissions</a> -->
            </div>
          </nav>
        </div>
        <form id="formID" method="GET" action="index.php">

          <div class="card-body">

            <div class="row m-3">
              <div class="col-sm-3">
                <label>Select Group for Permission <span style="color:red;">*</span></label>
              </div>
              <div class="col-sm-8">
                <input type="hidden" name="module" value="Permissions">
                <input type="hidden" name="view" value="List">
                <select class="form-select" name="field" aria-label="Default select example" required="required" id="field" onchange="showGroup(this.value)">
                  <option selected disabled>Select Group</option>
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
              <div class="col-sm-1">
                <!-- <button type="submit" name="submit1" value="submit1" class="btn btn-success btn-sm">Submit</button> -->
              </div>
            </div>

            <div class="table-responsive" class="m-3">
              <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2"></div>
              </div>
              <table class="table" id="Table">


              </table>

            </div>


          </div>
          <div class="card-footer">
            <div class="row">
              <button type="submit" name="submit1" value="submit1" id="button" class=" button btn btn-success btn-block">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




<script>
  $('#button').hide();

  function showGroup(str) {
    if (str == "") {
      document.getElementById("Table").innerHTML = "";
      return;
    }


    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("Table").innerHTML = this.responseText;
    }
    xhttp.open("GET", "controllers/ajax/table.php?field=" + str, true);
    xhttp.send();
    $('#button').show();

  }

  // "controllers/ajax/users-name.php?q="+str,true
</script>