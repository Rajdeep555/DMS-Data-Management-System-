<?php

$table_name = 'user_mapping';
$redirection_page = "index.php?module=User Mapping&view=List";
$action_name = "module=User Mapping&view=List";

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


$select_enquiry3 = "SELECT * FROM groups where id='$grp_map_group' and status = 'Active'";
$sql3 = $dbconn->prepare($select_enquiry3);
$sql3->execute();
$wlvd3 = $sql3->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd3 as $rows3);
$group = $rows3->user_grp_role;

// echo 1;
// echo $grp_map_group;
// echo '<br>';
if(isset($_GET['sid'])){
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script type="text/javascript">';
    echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Created successfully"
    });';
    echo '</script>';
} elseif(isset($_GET['eid'])){
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
                            <a class="nav-item nav-link active btn btn-lg text-primary" href="" aria-selected="true">User Mapping</a>
                             <a class="nav-item nav-link btn btn-lg" href="index.php?module=Location Mapping&view=List" aria-selected="true">Location Mapping</a>
                            <!--<a class="nav-item nav-link  btn btn-lg" href="index.php?module=User Mapping&view=Create" aria-selected="true"><i class="material-icons" style="font-size:14px;">add</i> User Mapping</a>-->
                        </div>
                    </nav>
                </div>


                <div class="card-body">
                    <div class="row">


                        <div class="col-md-12  pd-2">
                            <div class="card border">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-9"><h6  class="text-center "><?php echo $group ?></h6></div>
                                        <?php
                                         $select_enquiry4 = "SELECT distinct B.user_map_parent from users as A,user_mapping as B WHERE A.id=B.user_map_parent and A.user_role='$group' and A.status='Active' and   B.status='Active'";
                                        $sql4 = $dbconn->prepare($select_enquiry4);
                                        $sql4->execute();
                                        $wlvd4 = $sql4->fetchAll(PDO::FETCH_OBJ);
                                        ?>
                                    <!--<a href="index.php?module=User Mapping&view=Create&group=<?php echo $group ?>" class="text-center button">-->
                                        <div class="col-md-3">
                                            <?php
                                            // if(!$sql4){
                                            ?>
                                            <a  href="index.php?module=User Mapping&view=Create&group=<?php echo $group ?>"  class="btn btn-primary"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i> Add</a>
                                            <?php
                                            // }
                                            ?>
                                        </div>
                                    <!--</a>-->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr class="border-bottom-primary">
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Parent Group</th>
                                                    <th scope="col">Child Group</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                               
                                                foreach ($wlvd4 as $rows4){
                                                $parent = $rows4->user_map_parent;
                                                
                                                $select_enquiry41 = "SELECT * from users WHERE id='$parent' and status='Active'";
                                                $sql41 = $dbconn->prepare($select_enquiry41);
                                                $sql41->execute();
                                                $wlvd41 = $sql41->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($wlvd41 as $rows41);
                                                
                                                $select_enquiry42 = "SELECT * from user_mapping WHERE user_map_parent='$parent' and status='Active'";
                                                $sql42 = $dbconn->prepare($select_enquiry42);
                                                $sql42->execute();
                                                $wlvd42 = $sql42->fetchAll(PDO::FETCH_OBJ);
                                                $c=[];
                                                
                                                //  $c = implode(',',$child);
                                                
                                      
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $rows41->user_fname; ?> <?php echo $rows41->user_mname; ?> <?php echo $rows41->user_lname; ?> ( <?php echo $rows41->user_role; ?> )</td>
                                                    <td><?php
                                                    if($sql42->rowCount()>0){
                                                    foreach ($wlvd42 as $rows42){
                                                    $child_id = $rows42->user_map_child;
                                                   
                                                    $select_enquiry43 = "SELECT * from users WHERE id='$child_id' and status='Active'";
                                                    $sql43 = $dbconn->prepare($select_enquiry43);
                                                    $sql43->execute();
                                                    $wlvd43 = $sql43->fetchAll(PDO::FETCH_OBJ);
                                                    foreach ($wlvd43 as $rows43);
                                                   echo  $fname = $rows43->user_fname;
                                                   echo '&nbsp';
                                                   echo $mname = $rows43->user_mname;
                                                   echo '&nbsp';
                                                    echo $lname = $rows43->user_lname;
 echo '&nbsp';
 echo '(';
                                                    echo $role = $rows43->user_role;
                                                     echo ')';

                                                     ?>
                                                        
                                                        <a href="index.php?module=User Mapping&view=Delete&cid=<?php echo $child_id; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove only child group?');"><i class="material-icons" style="font-size:18px;">do_disturb_on</i></a>
                                                        <?php
                                                       echo '<br>';
                                                        }
                                                }
                                               
                                                      
                                                    
                                                    
                                                    ?></td>
                                                    <td>
                                                                <a href="index.php?module=User Mapping&view=CreateNew&group=<?php echo $group ?>&id=<?php echo $parent; ?>" class="btn"><i class="material-icons" style="font-size:18px;color:#7366ff;">add</i></a>
                                                       <!-- <a href="index.php?module=User Mapping&view=Update&group=<?php echo $group ?>&id=<?php echo $parent; ?>" class="btn"><i class="material-icons" style="font-size:18px;color:#7366ff;">edit</i></a>-->
                                                        <a href="index.php?module=User Mapping&view=Delete&id=<?php echo $parent; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');"><i class="material-icons" style="font-size:18px;">delete</i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <?php
                            $suv_group = explode(',', $grp_map_sub_group);


                            $subgroup = [];
                            
                                                            $numItems = count($suv_group);
$a = 0;
                            foreach ($suv_group as $i) {
                                


  if(++$a != $numItems) {
   


                                $select_enquiry2 = "SELECT * FROM groups where id='$i' and status = 'Active'";
                                $sql2 = $dbconn->prepare($select_enquiry2);
                                $sql2->execute();
                                $wlvd2 = $sql2->fetchAll(PDO::FETCH_OBJ);
                                foreach ($wlvd2 as $rows2);
                                $subgroup = $rows2->user_grp_role;
                                //  echo $subgroup;
                                                


                            ?>
                            
                                <div class="col-md-12  pd-2">
                                    <div class="card border">
                                        <div class="card-header">
                                            <div class="row">
                                            <!--<a href="index.php?module=User Mapping&view=Create&group=<?php echo $subgroup ?>" class="text-center button">-->
                                                <div class="col-md-9"><h6  class="text-center "><?php echo $subgroup ?></h6></div>
                                                <div class="col-md-3">
                                                   <?php
                                                      $select_enquiry44 = "SELECT * from users as A,user_mapping as B WHERE A.id=B.user_map_parent and A.user_role='$subgroup' and A.status='Active' and   B.status='Active'";
                                        $sql44 = $dbconn->prepare($select_enquiry44);
                                        $sql44->execute();
                                        $wlvd44 = $sql44->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($wlvd44 as $rows44){
                                                        $id = $rows44->id;
                                                        $u_role = $rows44->user_role;
                                                        // echo $id;
                                                        //  echo $u_role;
                                        }
                                        // if($u_role != $subgroup){
                                        ?>
                                                    <a  href="index.php?module=User Mapping&view=Create&group=<?php echo $subgroup ?>"  class="btn btn-primary"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i> Add</a>
                                        <?php
                                        // }
                                        
                                        ?>
                                                </div>
                                            <!--</a>-->
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr class="border-bottom-primary">
                                                            <th scope="col">Id</th>
                                                            <th scope="col">Parent Group</th>
                                                            <th scope="col">Child Group</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i=1;
                                                        
                                                          $select_enquiry40 = "SELECT distinct B.user_map_parent from users as A,user_mapping as B WHERE A.id=B.user_map_parent and A.user_role='$subgroup' and A.status='Active' and   B.status='Active'";
                                        $sql40 = $dbconn->prepare($select_enquiry40);
                                        $sql40->execute();
                                        $wlvd40 = $sql40->fetchAll(PDO::FETCH_OBJ);
                                        
                                                        foreach ($wlvd40 as $rows40){
                                                        $parent1 = $rows40->user_map_parent;
                                                        
                                                        $select_enquiry41 = "SELECT * from users WHERE id='$parent1' and status='Active'";
                                                        $sql41 = $dbconn->prepare($select_enquiry41);
                                                        $sql41->execute();
                                                        $wlvd41 = $sql41->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($wlvd41 as $rows41);
                                                        
                                                        $select_enquiry42 = "SELECT * from user_mapping WHERE user_map_parent='$parent1' and status='Active'";
                                                        $sql42 = $dbconn->prepare($select_enquiry42);
                                                        $sql42->execute();
                                                        $wlvd42 = $sql42->fetchAll(PDO::FETCH_OBJ);
                                                        $c=[];
                                                        
                                                        //  $c = implode(',',$child);
                                                        
                                              
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo $rows41->user_fname; ?> <?php echo $rows41->user_mname; ?> <?php echo $rows41->user_lname; ?> ( <?php echo $rows41->user_role; ?> )</td>
                                                            <td><?php
                                                            if($sql42->rowCount() > 0){
                                                            foreach ($wlvd42 as $rows42){
                                                            $child_id = $rows42->user_map_child;
                                                           
                                                            $select_enquiry43 = "SELECT * from users WHERE id='$child_id' and status='Active'";
                                                            $sql43 = $dbconn->prepare($select_enquiry43);
                                                            $sql43->execute();
                                                            $wlvd43 = $sql43->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($wlvd43 as $rows43);
                                                           echo  $fname = $rows43->user_fname;
                                                           echo '&nbsp';
                                                           echo $mname = $rows43->user_mname;
                                                           echo '&nbsp';
                                                            echo $lname = $rows43->user_lname;
                                                             echo '&nbsp';
 echo '(';
                                                    echo $role = $rows43->user_role;
                                                     echo ')';
                                                            ?>
                                                        
                                                        <a href="index.php?module=User Mapping&view=Delete&cid=<?php echo $child_id; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove only child group?');"><i class="material-icons" style="font-size:18px;">do_disturb_on</i></a>
                                                        <?php
                                                       echo '<br>';
                                                        }
                                                        
                                                        
                                                            }
                                                            
                                                            
                                                            ?></td>
                                                             <td>
                                                             
                                                                <a href="index.php?module=User Mapping&view=CreateNew&group=<?php echo $subgroup ?>&id=<?php echo $parent1; ?>" class="btn"><i class="material-icons" style="font-size:18px;color:#7366ff;">add</i></a>
                                                              <!--  <a href="index.php?module=User Mapping&view=Update&group=<?php echo $subgroup ?>&id=<?php echo $parent1; ?>" class="btn"><i class="material-icons" style="font-size:18px;color:#7366ff;">edit</i></a>-->
                                                                <a href="index.php?module=User Mapping&view=Delete&id=<?php echo $parent1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');"><i class="material-icons" style="font-size:18px;">delete</i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
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