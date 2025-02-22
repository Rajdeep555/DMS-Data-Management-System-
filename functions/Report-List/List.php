<?php

$table_name = 'users';
$redirection_page = "index.php?module=Module&view=List";
$action_name = "module=Module&view=List";
$user_role = $_SESSION['user_role'];

// For Displaying the table

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 35;
$offset = ($pageno - 1) * $no_of_records_per_page;

$designation_order = "CASE user_role 
    WHEN 'Deputy Vice President(SM)' THEN 1
    WHEN 'Assistant Vice President(SM)' THEN 2
    WHEN 'General Manager' THEN 3
    WHEN 'Deputy General Manager' THEN 4
    WHEN 'Regional Sales Manager' THEN 5
    WHEN 'Area Sales Manager' THEN 6
    WHEN 'Territory Sales Manager' THEN 7
    WHEN 'Sales Manager' THEN 8
    WHEN 'Market Development Executive' THEN 9
    ELSE 10 END";

$select_enquiry = "SELECT * FROM `$table_name` WHERE status = 'Active' ORDER BY $designation_order, id DESC";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();



$total_rows = $sql->fetchColumn();
$total_pages = ceil($total_rows / $no_of_records_per_page);

if ($user_role == 'Admin') {
    $allowed_roles = ['Deputy Vice President(SM)'];
} elseif ($user_role == 'Deputy Vice President(SM)') {
    $allowed_roles = ['Regional Sales Manager'];
} elseif ($user_role == 'Regional Sales Manager') {
    $allowed_roles = ['Area Sales Manager'];
} elseif ($user_role == 'Area Sales Manager') {
    $allowed_roles = ['Territory Sales Manager'];
} elseif ($user_role == 'Territory Sales Manager') {
    $allowed_roles = ['Sales Manager'];
} else {
    $allowed_roles = []; // No roles to show for other users
}

$select_enquiry = "SELECT DISTINCT user_role FROM `$table_name` WHERE status = 'Active' 
    AND user_role IN ('" . implode("','", $allowed_roles) . "') 
    ORDER BY $designation_order, id DESC LIMIT $offset, $no_of_records_per_page";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

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

<style>
    .designation-cell {
        transition: color 0.3s ease;
    }

    .designation-cell:hover {
        color: blue;
    }

    .designation-cell:active {
        scale: 1.03;
    }
</style>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="table-responsive p-3" style="min-height: 400px;">
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <!-- <th scope="col"><strong>ID</strong></th> -->
                                <th scope="col"><strong>DESIGNATIONS</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {
                                    // $field1 = $rows->id;
                                    $field2 = $rows->user_role;

                                    if ($field2 != 'Admin') {
                            ?>
                                        <tr style="cursor: pointer;">
                                            <!-- <th scope="row"><?php echo $i++; ?></th> -->
                                            <td class="designation-cell" onclick="window.location.href='index.php?module=Report-List&view=Hierarchy&designation=<?php echo urlencode($field2); ?>'"><?php echo $field2; ?></td>
                                        </tr>
                            <?php

                                    }
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