<?php

$table_name = 'state';
$redirection_page = "index.php?module=State&view=List";
$action_name = "module=State&view=List";


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

if($_GET['sid']){
    echo '<script language="javascript">';
    echo 'alert("Created successfully")';
     echo '</script>';
}elseif($_GET['eid']){
    echo '<script language="javascript">';
    echo 'alert("Edited successfully")';
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
                            <?php
                            if ($List == '1') {
                            ?>
                                <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="true">State</a>
                            <?php
                            }
                            ?>
                            <?php
                            if ($Create == '1') {
                            ?>
                                <a class="nav-item nav-link  btn btn-lg" href="index.php?module=State&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New State</a>
                            <?php
                            }
                            ?>
                        </div>
                    </nav>
                </div>
                <div class="table-responsive p-3">
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col">Id</th>
                                <th scope="col">State Name</th>
                                <?php
                                if ($Update == '1' || $Delete == '1') {
                                ?>
                                    <th scope="col">Action</th>
                                <?php }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            //while($rows = mysql_fetch_array($aResult,MYSQL_ASSOC))
                            //{ 
                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {

                                    $field1 = $rows->id;
                                    $field2 = $rows->sta_state_name;
                                    // $field3 = $rows->loc_sate_id;




                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><?php echo $field2; ?></td>

                                        <td>
                                            <?php
                                            if ($Update == '1') {
                                            ?>
                                                <a href="index.php?module=State&view=Update&id=<?php echo $field1; ?>" class="btn"><i class="material-icons" style="font-size:18px;color:#7366ff;">edit</i></a>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if ($Delete == '1') {
                                            ?>
                                                <a href="index.php?module=State&view=Delete&id=<?php echo $field1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');"><i class="material-icons" style="font-size:18px;">delete</i></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>

                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                     <?php include('plugin/pagination.php'); ?>
                </div>



            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->