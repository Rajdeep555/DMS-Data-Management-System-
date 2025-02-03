<style>
    label {
        display:block; 
        text-align:right;
        font-size:15px;
     }
</style>

<?php
// For Submitting The Form

if (isset($_POST['submit'])) {

    $menuid    =  $_POST['menuid'];
    $menu = "";
    foreach ($menuid as $menu1) {
        $menu .= $menu1 . ",";

        echo $menu;
    }

    $checkbox1 = $_POST['check'];
    $chk = "";
    foreach ($checkbox1 as $chk1) {
        $chk .= $chk1 . ",";

        echo $chk ;
    }

    echo $menuid;

    echo $checkbox1;
}
?>

<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
            <form id="formID" class="m-t-30" method="POST" action="">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label>Select Group for Permission  <span style="color:red;">*</span></label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-3">
                        <select class="form-select" name="field2" aria-label="Default select example" onchange="showMenu(this.value)" >
                                <option selected disabled>Select Group</option>
                                <?php  
                                $select_bookings= "SELECT * FROM `groups` where status = 'Active'";
                                $sql11=$dbconn->prepare($select_bookings);
                                $sql11->execute();
                                $wlvd11=$sql11->fetchAll(PDO::FETCH_OBJ);
                                if($sql11->rowCount() > 0){
                                    foreach($wlvd11 as $rows11){
                                        $user_grp_id = $rows11->id;
                                        $user_grp_name = $rows11->user_grp_name;
                                    ?>
                                    <option value="<?php  echo $user_grp_id;?>"><?php  echo $user_grp_name;?></option>
                                    <?php 
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
function showMenu(str) {
  if (str == "") {
    document.getElementById("table").innerHTML = "";
    return;
  }


  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("table").innerHTML = this.responseText;
  }
  xhttp.open("GET","controllers/ajax/table.php?q="+str,true );
  xhttp.send();
}

// "controllers/ajax/users-name.php?q="+str,true
</script>
