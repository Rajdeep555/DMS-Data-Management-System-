<?php

$table_name = 'group_mapping';
$redirection_page = "index.php?module=Groups Mapping&view=List";
$action_name = "module=Groups Mapping&view=List";

$id = $_REQUEST['id'];


// For Displaying the table

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 7;
$offset = ($pageno - 1) * $no_of_records_per_page;


$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();


$total_rows = $sql->fetchColumn();
$total_pages = ceil($total_rows / $no_of_records_per_page);

$select_enquiry = "SELECT * FROM `$table_name` where status = 'Active' order by id desc LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);


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


<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="true">Group Mapping</a>
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Groups Mapping&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create Group Mapping</a>
                        </div>
                    </nav>
                </div>


                <div class="table-responsive p-3">
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col">Id</th>
                                <th scope="col">Parent Groups</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {

                                    $field1 = $rows->id;
                                    $field2 = $rows->grp_map_application;
                                    $grp_map_sub_group = $rows->grp_map_sub_group;
                                    $grp_map_group  = $rows->grp_map_group;
                                   
                                    $select_bookings = "SELECT * FROM `groups` where status = 'Active' and id='$grp_map_group'";
                                    $sql11 = $dbconn->prepare($select_bookings);
                                    $sql11->execute();
                                    $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($wlvd11 as $rows11);
                                    $groups_name = $rows11->user_grp_name;


                                $sub_group = explode(',', $grp_map_sub_group);
                               
                                $subGroup=[];
                                foreach($sub_group as $a)
                                {
                                
                                //for job type
                                $select_enquiry3 = "SELECT * FROM groups where id='$a' and status = 'Active'";
                                $sql3=$dbconn->prepare($select_enquiry3);
                                $sql3->execute();
                                $wlvd3=$sql3->fetchAll(PDO::FETCH_OBJ);
                                
                                // empty array
                                // $job=[];
                                
                                foreach ($wlvd3 as $rows3){
                                    $subGroup[]=$rows3->user_grp_name;
                           
                                    }
                                } 
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><?php echo $groups_name; ?> -> <?php echo implode("->",$subGroup); ?></td>
                                       
                                        <td>
                                            <!-- <a class="btn" href="index.php?module=Groups Mapping&view=Update&id=<?php echo $field1; ?>"><i class="material-icons" style="font-size:18px;color:#7366ff;">edit</i></a> -->
                                            <a href="index.php?module=Groups Mapping&view=Delete&id=<?php echo $field1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');"><i class="material-icons" style="font-size:18px;">delete</i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->