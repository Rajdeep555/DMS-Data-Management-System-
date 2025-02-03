<?php

$table_name = 'user_mapping';
$redirection_page = "index.php?module=User Mapping&view=List";

// For Submitting The Form

if (isset($_POST['submit'])) {
    $field1 = $_POST['field1'];

    $child1 = $_POST['field2'];

    $c = "";
    foreach ($child1 as $c1) {


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
        header("Location: $redirection_page&id=$myid");
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
$u_role = $rows31->user_grp_role;
// echo $user_role;
// echo $user_role_id;
// echo '<br>';

$select_enquiry1 = "SELECT * FROM `group_mapping` where status = 'Active'";
$sql1 = $dbconn->prepare($select_enquiry1);
$sql1->execute();
$wlvd1 = $sql1->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd1 as $rows1);
// $counter  =1 ; 
$grp_map_group = $rows1->grp_map_group;
$grp_map_sub_group = $rows1->grp_map_sub_group;


// $select_enquiry3 = "SELECT * FROM groups where id='$grp_map_group' and status = 'Active'";
// $sql3 = $dbconn->prepare($select_enquiry3);
// $sql3->execute();
// $wlvd3 = $sql3->fetchAll(PDO::FETCH_OBJ);
// foreach ($wlvd3 as $rows3);
// $group = $rows3->user_grp_role;

// echo 1;
// echo $user_role_id;
 echo $grp_map_sub_group;
// echo '<br>';


?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link btn btn-lg" href="index.php?module=User Mapping&view=List" aria-selected="true">User Mapping</a>
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="true">Create User Mapping</a>
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
                        ?>

                                <div class="col-md-12  pd-2">
                                    <div class="card border">
                                        <div class="card-header">
                                            <h6 class="text-center"><?php echo $u_role ?></h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="formID" method="POST" action="">


                                                <div class="row m-3">
                                                    <div class="col-sm-3">
                                                        <label>Select Parent <span style="color:red;">*</span></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="field1" aria-label="Default select example" required="required">
                                                            <option selected disabled>Select Parent</option>
                                                            <?php
                                                            $select_bookings = "SELECT * FROM `users` where user_role='$u_role' and status = 'Active'";
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
                                                                    <option value="<?php echo $user_id; ?>"><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?></option>
                                                            <?php
                                                                }
                                                            } 
                                                            ?>
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
                                                            $suv_group = explode(',', $grp_map_sub_group);

                                                            // echo $suv_group;
                                                            
                                                            $rev = array_reverse($suv_group);
                                                            // echo $rev[1];
                      
                        $counter  = 2;
                        $subgroup = [];
                        foreach ($rev as $i) {
                            if ($i == $user_role_id) {
                                break;
                            } else {

                                //   echo $counter;
                                //   echo $i;
                                //     echo '<br>';

                       

                                $select_enquiry2 = "SELECT * FROM groups where id='$i' and status = 'Active'";
                                $sql2 = $dbconn->prepare($select_enquiry2);
                                $sql2->execute();
                                $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($wlvd2 as $rows2);
                                $subgroup = $rows2->user_grp_role;
                                // echo $counter;
                                //  echo $subgroup;
                                    // echo '<br>';
                            }
                        }
             $ans =$subgroup;           
//  echo $ans;
                                                            // $a = $suv_group1[$counter+1];
                                                            // $select_enquiry2 = "SELECT * FROM groups where id='$a' and status = 'Active'";
                                                            // $sql2 = $dbconn->prepare($select_enquiry2);
                                                            // $sql2->execute();
                                                            // $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                                            // foreach ($wlvd2 as $rows2);
                                                            // $subgroup1 = $rows2->user_grp_role;




                                                            //         $grp = implode(',', $subgroup1);

                                                            // echo $grp_map_group;
                                                            // echo ',';
                                                            // echo $grp;
                                                            ?>
                                                            <!--<option selected disabled>Select Child</option>-->
                                                            <?php
                                                            $select_bookings = "SELECT * FROM `users` where user_role='$ans' and status = 'Active'";
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
                                                                    <option value="<?php echo $user_id; ?>"><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <?php

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" name="submit">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php
                        //     }
                        // }
                        ?>


                        <?php
                        $suv_group = explode(',', $grp_map_sub_group);

                        // echo $suv_group[0];

                      
                        $counter  = 2;
                        $subgroup = [];
                        foreach ($suv_group as $i) {
                            // if ($i == $user_role_id) {
                            //     break;
                            // } else {

                                //   echo $counter;
                                //   echo $i;
                                //     echo '<br>';

                       

                                $select_enquiry2 = "SELECT * FROM groups where id='$i' and status = 'Active'";
                                $sql2 = $dbconn->prepare($select_enquiry2);
                                $sql2->execute();
                                $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($wlvd2 as $rows2);
                                $subgroup = $rows2->user_grp_role;
                                // echo $counter;
                                //  echo $subgroup;
                                    // echo '<br>';
                                
                                
    // $z[]= $subgroup;
    // echo $z[];

//  $select_bookings = "SELECT * FROM `user_mapping` where user_map_parent='$z' and status = 'Active'";
//                         $sql111 = $dbconn->prepare($select_bookings);
//                         $sql111->execute();
//                         $wlvd111 = $sql111->fetchAll(PDO::FETCH_OBJ);
//                         if ($sql111->rowCount() > 0) {
//                             foreach ($wlvd111 as $rows111);
//                             $user_map_id = $rows111->id;
//                             if (!$sql111) {
                        ?>
                              

                        <?php
                                $counter++;
                        // }
//                         }
// }
}
                        //         $grp = implode(',', $a);

                        // echo $grp_map_group;
                        // echo ',';
                        // echo $grp;
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