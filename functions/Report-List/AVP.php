<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// require 'db_connection.php'; // Ensure database connection

$table_name = 'users';
$redirection_page = "index.php?module=All-Designations&view=List";
$action_name = "module=All-Designations&view=List";

$employee_id = $_GET['emp_id'] ?? null;

if (!$employee_id) {
    die("Error: Employee ID is missing.");
}

// Get the user details
$get_id_query = "SELECT id FROM users WHERE status = 'Active' AND user_unique_id = ?";
$sql = $dbconn->prepare($get_id_query);
$sql->execute([$employee_id]);
$id = $sql->fetchColumn();

if (!$id) {
    die("Error: No user found with this ID.");
}

// Get the mapped user IDs from user_mapping
$mapped_ids_query = "SELECT user_map_child FROM user_mapping WHERE user_map_parent = ? AND status = 'Active'";
$sql1 = $dbconn->prepare($mapped_ids_query);
$sql1->execute([$id]);
$mapped_ids2 = $sql1->fetchAll(PDO::FETCH_COLUMN);

// Recursive function to get all child users
function getAllChildren($dbconn, $parentIds)
{
    $allChildren = [];

    while (!empty($parentIds)) {
        $placeholders = implode(',', array_fill(0, count($parentIds), '?'));
        $query = "SELECT user_map_child FROM user_mapping WHERE user_map_parent IN ($placeholders) AND status = 'Active'";
        $stmt = $dbconn->prepare($query);
        $stmt->execute($parentIds);
        $children = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($children)) {
            break;
        }

        $allChildren = array_merge($allChildren, $children);
        $parentIds = $children; // Set new parents for next loop
    }

    return $allChildren;
}

// Get all child users
$allChildren = !empty($mapped_ids2) ? getAllChildren($dbconn, $mapped_ids2) : [];

// If no child found, include parent employee_id
if (empty($allChildren)) {
    $allChildren = [$id];
}

// Fetch employee unique IDs
$get_emp_ids = [];
$placeholders = implode(',', array_fill(0, count($allChildren), '?'));

if (!empty($allChildren)) {
    $get_emp_ids_query = "SELECT user_unique_id FROM users WHERE id IN ($placeholders)";
    $sql = $dbconn->prepare($get_emp_ids_query);
    $sql->execute($allChildren);
    $get_emp_ids = $sql->fetchAll(PDO::FETCH_COLUMN);
}

// Debugging output
// echo "<pre>All Children IDs: " . print_r($allChildren, true) . "</pre>";
// echo "<pre>Employee Unique IDs: " . print_r($get_emp_ids, true) . "</pre>";






$mapped_ids = "SELECT user_map_child FROM user_mapping WHERE user_map_parent = '$id' AND status = 'Active'";
$sql = $dbconn->prepare($mapped_ids);
$sql->execute();
$mapped_ids = $sql->fetchAll(PDO::FETCH_COLUMN);

if (!empty($mapped_ids)) {
    $select_enquiry = "SELECT * FROM $table_name WHERE status = 'Active' AND id IN (" . implode(',', $mapped_ids) . ") ORDER BY id DESC";
} else {
    $select_enquiry = "SELECT * FROM $table_name WHERE status = 'Active' AND id IS NULL"; // Handle empty case
}

$sql = $dbconn->prepare($select_enquiry);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

// Get user designation
$user_designation = !empty($wlvd) ? $wlvd[0]->user_role : 'No designation found';

// Handle success messages
if (isset($_GET['sid']) || isset($_GET['eid'])) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script type="text/javascript">';
    echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "' . (isset($_GET['sid']) ? "Created successfully" : "Edited successfully") . '"
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
                            <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="true"><?= $user_designation; ?></a>
                        </div>
                    </nav>
                </div>

                <div class="table-responsive p-3">
                    <table class="table">
                        <thead>
                            <tr class="border-bottom-primary">
                                <th scope="col"><strong>ID</strong></th>
                                <th scope="col"><strong>Name</strong></th>
                                <th scope="col"><strong>Farmer Visit</strong></th>
                                <th scope="col"><strong>Retailer Visit</strong></th>
                                <th scope="col"><strong>Collections</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if ($sql->rowCount() > 0) {
                                foreach ($wlvd as $rows) {
                                    $field1 = $rows->id;
                                    $employee_id = $rows->user_unique_id;
                                    $field2 = $rows->user_fname . " " . $rows->user_mname . " " . $rows->user_lname;

                                    // Get travel log data for the mapped Market Development Executives
                                    // Ensure $allChildren is not empty, otherwise use only $employee_id
                                    $employeeIds = !empty($get_emp_ids) ? array_merge([$employee_id], $get_emp_ids) : [$employee_id];

                                    // Create placeholders for each employee ID
                                    $placeholders = implode(',', array_fill(0, count($employeeIds), '?'));

                                    $get_data = "SELECT employee_id, no_of_farm_visits, no_of_retailer_visits, collection 
             FROM travel_log 
             WHERE employee_id IN ($placeholders) AND status = 'Active'";

                                    $sql = $dbconn->prepare($get_data);
                                    $sql->execute($employeeIds);
                                    $get_data = $sql->fetchAll(PDO::FETCH_OBJ); // Fetch multiple rows as objects

                                    // echo "<pre>" . print_r($get_data, true) . "</pre>";

                                    // Initialize totals
                                    $no_of_farmer_visit = 0;
                                    $no_of_retailer_visit = 0;
                                    $collection_amount = 0;

                                    // Loop through the data to sum up values
                                    foreach ($get_data as $row) {
                                        $no_of_farmer_visit += $row->no_of_farm_visits ?? 0;
                                        $no_of_retailer_visit += $row->no_of_retailer_visits ?? 0;
                                        $collection_amount += $row->collection ?? 0;
                                    }

                                    // echo "Total Farm Visits: $no_of_farmer_visit\n";
                                    // echo "Total Retailer Visits: $no_of_retailer_visit\n";
                                    // echo "Total Collection: $collection_amount\n";

                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td>
                                            <a style="color: blue; text-decoration:underline;"
                                                href="index.php?module=<?= ($rows->user_role == 'Market Development Executive') ? 'Market-Report' : 'Report-List'; ?>&view=<?= ($rows->user_role == 'Market Development Executive') ? 'List' : 'AVP'; ?>&emp_id=<?php echo urlencode($employee_id); ?>">
                                                <?php echo $field2; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $no_of_farmer_visit; ?></td>
                                        <td><?php echo $no_of_retailer_visit; ?></td>
                                        <td><?php echo $collection_amount; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
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
<!-- Container-fluid Ends-->