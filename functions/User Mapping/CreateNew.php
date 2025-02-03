<?php

$table_name = 'user_mapping';
$redirection_page = "index.php?module=User Mapping&view=List";
$g = $_GET['group'];

$p_id = $_GET['id'];

// For Submitting The Form

if (isset($_POST['submit'])) {
    $field1 = $_POST['field1'];

    $child1 = $_POST['field2'];

    $c1 = "";
    foreach ($child1 as $c1) {
        
        // echo $field1;
        // echo $c1;

        $sql = "INSERT `$table_name` SET
                    user_map_parent   = '" . addslashes($field1) . "',
      user_map_child        = '" . addslashes($c1) . "',
                  status   = 'Active'";


        $sql_insert = $dbconn->prepare($sql);
        $sql_insert->execute();
    }


    $myid = $dbconn->lastInsertId();

    $message = "Details successfully updated.";
    $status = "success";
    if ($myid) {
        header("Location: $redirection_page&sid=$myid");
    } else {
        print_r($this->pdo->errorInfo());
    }
}


$user_role = $_SESSION['user_role'];
$select_enquiry31 = "SELECT * FROM groups where user_grp_role='$user_role' and status = 'Active'";
$sql31 = $dbconn->prepare($select_enquiry31);
$sql31->execute();
$wlvd31 = $sql31->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd31 as $rows31);
$user_role_id = $rows31->id;
// echo $user_role;
// echo $user_role_id;
// echo '<br>';

$select_enquiry313 = "SELECT * FROM users where id='$p_id' and status = 'Active'";
$sql313 = $dbconn->prepare($select_enquiry313);
$sql313->execute();
$wlvd313 = $sql313->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd313 as $rows313);

$select_enquiry1 = "SELECT * FROM `group_mapping` where status = 'Active'";
$sql1 = $dbconn->prepare($select_enquiry1);
$sql1->execute();
$wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd1 as $rows1);
// $counter  =1 ; 
$grp_map_group = $rows1->grp_map_group;
$grp_map_sub_group = $rows1->grp_map_sub_group;


$select_enquiry3 = "SELECT * FROM groups where id='$grp_map_group' and status = 'Active'";
$sql3 = $dbconn->prepare($select_enquiry3);
$sql3->execute();
$wlvd3 = $sql3->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd3 as $rows3);
$group = $rows3->user_grp_role;

// echo 1;
// echo $grp_map_group;
// echo '<br>';

$select_enquiry31 = "SELECT * FROM groups where user_grp_role='$g' and status = 'Active'";
$sql31 = $dbconn->prepare($select_enquiry31);
$sql31->execute();
$wlvd31 = $sql31->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd31 as $rows31);
$user_roleid = $rows31->id;


$select_enquiry11 = "SELECT * FROM `user_mapping` where status = 'Active' and user_map_parent='$user_roleid'";
$sql11 = $dbconn->prepare($select_enquiry11);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd11 as $rows11);
$user_map_parent =$rows11->user_map_parent;
$user_map_child =$rows11->user_map_child;


$arr_child ==array();
$arr_parent ==array();
$select_bookings = "SELECT * FROM `user_mapping` where status = 'Active'";
$sql111 = $dbconn->prepare($select_bookings);
$sql111->execute();
$wlvd111 = $sql111->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd111 as $rows111) {
    $user_map_child =$rows111->user_map_child;
    $user_map_parent =$rows111->user_map_parent;
 
$arr_child[] = $user_map_child;

$ar_child = implode(",",$arr_child);

 $arr_parent[] = $user_map_parent;

$ar_parent = implode(",",$arr_parent);
}

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=User Mapping&view=List" aria-selected="true">User Mapping</a>
                            <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="true"><i class="material-icons" style="font-size:14px;">add</i> Create Mapping</a>
                         <a class="nav-item nav-link btn btn-lg" href="index.php?module=Location Mapping&view=List" aria-selected="true">Location Mapping</a>
                            
                        </div>
                    </nav>
                </div>


                <div class="card-body">
                    <div class="row">
                        <?php
                        // $select_bookings = "SELECT * FROM `user_mapping` where user_map_parent='$user_role_id' and status = 'Active'";
                        // $sql111 = $dbconn->prepare($select_bookings);
                        // $sql111->execute();
                        // $wlvd111 = $sql111->fetchAll(PDO::FETCH_OBJ);
                        // if ($sql111->rowCount() > 0) {
                        //     foreach ($wlvd111 as $rows111);
                        //     $user_map_id = $rows111->id;
                        //     if (!$sql111) {
                        if($g=='Admin'){
                        ?>

                                <div class="col-md-12  pd-2">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h6 class="text-center"><?php echo $g ?></h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="formID" method="POST" action="">


                                                <div class="row m-3">
                                                    <div class="col-sm-3">
                                                        <label>Select Parent <span style="color:red;">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="field1" aria-label="Default select example" required="required">
                                                           
                                                                <option selected value="<?php echo $rows313->id; ?> "><?php echo $rows313->user_fname; ?> <?php echo $rows313->user_mname; ?> <?php echo $rows313->user_lname; ?></option>
                                                                
                                                    
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="row m-3">
                                                    <div class="col-sm-3">
                                                        <label>Select Child <span style="color:red;">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="field2[]" multiple aria-label="Default select example" required="required">
                                                            <?php
                                                            if($sql11){
                                                                
                                                                $suv_group = explode(',', $grp_map_sub_group);

                                                           //  echo $grp_map_sub_group;

                                                            $a = $suv_group[0];
                                                            $select_enquiry2 = "SELECT * FROM groups where id='$a' and status = 'Active'";
                                                            $sql2 = $dbconn->prepare($select_enquiry2);
                                                            $sql2->execute();
                                                            $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($wlvd2 as $rows2);
                                                            $subgroup = $rows2->user_grp_role;
                                                                ?>
                                                                <option selected disabled>Select Child</option>
                                                                <?php
                                                               
                                                            
                                                                
                                                            $select_bookings = "SELECT * FROM `users` where user_role='$subgroup' and status = 'Active' and id NOT IN (SELECT user_map_child FROM `user_mapping` where status = 'Active')";
                                                            $sql11 = $dbconn->prepare($select_bookings);
                                                            $sql11->execute();
                                                            $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                                                                foreach ($wlvd11 as $rows11) {
                                                                    $u_id = $rows11->id;
                                                                    $user_fname = $rows11->user_fname;
                                                                    $user_mname = $rows11->user_mname;
                                                                    $user_lname = $rows11->user_lname;
                                                                    
                                                            
                                                            ?>
                                                            <option value="<?php echo $u_id; ?>"><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?>  ( <?php echo $rows11->user_role; ?> )</option>
                                                            <?php
                                                           
                                                                }
                                                            }else{
                                                           ?>
                                                           <option selected disabled>Select child</option>
                                                            <?php
                                                            $suv_group = explode(',', $grp_map_sub_group);

                                                            // echo $grp_map_sub_group;

                                                            $a = $suv_group[0];
                                                            $select_enquiry2 = "SELECT * FROM groups where id='$a' and status = 'Active'";
                                                            $sql2 = $dbconn->prepare($select_enquiry2);
                                                            $sql2->execute();
                                                            $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($wlvd2 as $rows2);
                                                            $subgroup = $rows2->user_grp_role;

                                                            $select_enquiry21 = "SELECT * FROM user_mapping where user_map_child='$subgroup' and status = 'Active'";
                                                            $sql21 = $dbconn->prepare($select_enquiry21);
                                                            $sql21->execute();
                                                            $wlvd21 = $sql21->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($wlvd21 as $rows21);
                                                            $user_map = $rows21->id;

                                                            ?>
                                                            <option selected disabled>Select Child</option>
                                                            <?php
                                                            if(!$user_map){
                                                            $select_bookings = "SELECT * FROM `users` where user_role='$subgroup' and status = 'Active'";
                                                            $sql11 = $dbconn->prepare($select_bookings);
                                                            $sql11->execute();
                                                            $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                                                            if ($sql11->rowCount() > 0) {
                                                                foreach ($wlvd11 as $rows11) {
                                                                    $u_id = $rows11->id;
                                                                    $user_fname = $rows11->user_fname;
                                                                    $user_mname = $rows11->user_mname;
                                                                    $user_lname = $rows11->user_lname;
                                                            ?>
                                                                    <option value="<?php echo $u_id; ?>"><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?>  ( <?php echo $rows11->user_role; ?> )</option>
                                                            <?php
                                                                }
                                                            }
                                                            }
                                                            ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                               <div class="row">
                                                    <div class="col-md-5"></div>
                                                    <div class="col-md-2"><button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit">Save</button></div>
                                                    <div class="col-md-5"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php
                        //     }
                        // }
                        ?>

 <?php
                        }else{                  
                        ?>

                        <?php
                        $suv_group = explode(',', $grp_map_sub_group);

                      
                        $counter  = 2;
                        $subgroup = [];
                        foreach ($suv_group as $i) {

                      

                                $select_enquiry2 = "SELECT * FROM groups where id='$i' and status = 'Active'";
                                $sql2 = $dbconn->prepare($select_enquiry2);
                                $sql2->execute();
                                $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($wlvd2 as $rows2);
                                $subgroup = $rows2->user_grp_role;
     if($g == $subgroup){
                        ?>
                                <div class="col-md-12  pd-2">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h6 class="text-center"><?php echo $g ?></h6>
                                        </div>
                                        <div class="card-body">
 <form id="formID" method="POST" action="">


                                                <div class="row m-3">
                                                    <div class="col-sm-3">
                                                        <label>Select Parent <span style="color:red;">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="field1" aria-label="Default select example" required="required">
                                                                <option selected value="<?php echo $rows313->id; ?> "><?php echo $rows313->user_fname; ?> <?php echo $rows313->user_mname; ?> <?php echo $rows313->user_lname; ?></option>
                                                                
                                                    
                                                        </select>

                                                    </div>
                                                </div>
                                              <?php 
                                               
                                            //   echo $subgroup;
                                            //   echo $grp_map_sub_group;
                                              $suv_group1 = explode(',', $grp_map_sub_group);

                                                         
                                                            $rev = array_reverse($suv_group1);
                                                            
                                                         
                                                            
$subgroup1 = [];
                                                            foreach ($rev as $j) {
                                                                //   echo $j;
                            if ($j == $i) {
                                break;
                            } else {
                                  $select_enquiry2 = "SELECT * FROM groups where id='$j' and status = 'Active'";
                                $sql2 = $dbconn->prepare($select_enquiry2);
                                $sql2->execute();
                                $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($wlvd2 as $rows2);
                                $subgroup1 = $rows2->user_grp_role;
                            }
                                                            }
                                                            $ans =$subgroup1;   
                                                            
                                                         
                                                            //  echo $ans;
                                              ?>
                                                 <div class="row m-3">
                                                    <div class="col-sm-3">
                                                        <label>Select Child <span style="color:red;">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="field2[]" multiple aria-label="Default select example" required="required">
                                                            <?php
                                                            if($sql11){
                                                                 ?>
                                                             <option selected disabled>Select Child</option>
                                                            <?php
                                                                 $select_bookings = "SELECT * FROM `users` where user_role='$ans' and status = 'Active'  and id NOT IN ($ar_child)";
                                                            $sql11 = $dbconn->prepare($select_bookings);
                                                            $sql11->execute();
                                                            $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                                                            if ($sql11->rowCount() > 0) {
                                                                foreach ($wlvd11 as $rows11) {
                                                                    $user_id = $rows11->id;
                                                                    $user_fname = $rows11->user_fname;
                                                                    $user_mname = $rows11->user_mname;
                                                                    $user_lname = $rows11->user_lname;
                                                                  
                                                                   ?>
                                                                    <option value="<?php echo $user_id; ?>"><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?>  ( <?php echo $rows11->user_role; ?> )</option>
                                                            <?php
                                                                    
                                                                }
                                                            }
                                                            }else{
                                                                 ?>
                                                             <option selected disabled>Select Child</option>
                                                            <?php
                                                            $select_bookings = "SELECT * FROM `users` where user_role='$ans' and status = 'Active' ";
                                                            $sql11 = $dbconn->prepare($select_bookings);
                                                            $sql11->execute();
                                                            $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                                                            if ($sql11->rowCount() > 0) {
                                                                foreach ($wlvd11 as $rows11) {
                                                                    $user_id = $rows11->id;
                                                                    $user_fname = $rows11->user_fname;
                                                                    $user_mname = $rows11->user_mname;
                                                                    $user_lname = $rows11->user_lname;
                                                                    
                                                                         $select_enquiry21 = "SELECT * FROM user_mapping where user_map_child='$user_id' and status = 'Active'";
                                                            $sql21 = $dbconn->prepare($select_enquiry21);
                                                            $sql21->execute();
                                                            $wlvd21 = $sql21->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($wlvd21 as $rows21);
                                                            $user_map = $rows21->id;
                                                            $user_map_parent = $rows21->user_map_parent;
                                                            $user_map_child = $rows21->user_map_child;
                                                            if($user_id != $user_map_child ){
                                                                
                                                            ?>
                                                                    <option value="<?php echo $user_id; ?>"><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?>  ( <?php echo $rows11->user_role; ?> )</option>
                                                            <?php
                                                            
                                                            }
                                                                }
                                                            }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5"></div>
                                                    <div class="col-md-2"><button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit">Save</button></div>
                                                    <div class="col-md-5"></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                        <?php
     }
}
}
                        ?>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>




<script>
    function showGroup(str) {
        if (str == "") {
            document.getElementById("Child").innerHTML = "";
            return;
        }


        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("Child").innerHTML = this.responseText;
        }
        xhttp.open("GET", "controllers/ajax/child.php?group=" + str, true);
        xhttp.send();
    }

    // "controllers/ajax/users-name.php?q="+str,true
</script>