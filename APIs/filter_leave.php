<?php
session_start();
require_once('../settings/database.php');

$table_name = 'leave_application';
$filter_name = $_POST['filter_name'] ?? '';

// Prepare the SQL query based on the filter
$select_enquiry = "SELECT * FROM `$table_name` WHERE status = 'Active' AND lev_status='Pending'";

if (!empty($filter_name)) {
    $select_enquiry .= " AND user_unique_id = :filter_name"; // Assuming 'user_unique_id' matches the user's unique ID
}

$select_enquiry .= " ORDER BY id DESC";

$sql = $dbconn->prepare($select_enquiry);

// Bind the filter parameter if it is set
if (!empty($filter_name)) {
    $sql->bindParam(':filter_name', $filter_name, PDO::PARAM_STR);
}

$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

// Generate the table body
$output = '';
if ($sql->rowCount() > 0) {
    foreach ($wlvd as $rows) {
        $field1 = $rows->id;
        $field2 = $rows->lev_app_name;
        $field3 = $rows->lev_app_sub;
        $field4 = $rows->lev_app_from_date;
        $field5 = $rows->lev_app_end_date;
        $field6 = $rows->lev_app_des;
        $field7 = $rows->lev_app_upload;

        $output .= '<tr>';
        $output .= '<td>' . htmlentities($field2) . '</td>';
        $output .= '<td>' . htmlentities($field3) . '</td>';
        $output .= '<td>' . htmlentities($field4) . '</td>';
        $output .= '<td>' . htmlentities($field5) . '</td>';
        $output .= '<td>' . htmlentities($field6) . '</td>';
        $output .= '<td><a href="assets/uploads/' . htmlentities($field7) . '" target="_blank">View</a></td>';
        $output .= '<td>
                        <a href="index.php?module=Leave Request&view=Accept&type=Accept&id=' . $field1 . '&user_id=' . $_SESSION['user_id'] . '" class="btn btn-primary btn-sm">Accept</a>
                        <a href="index.php?module=Leave Request&view=Accept&type=Reject&id=' . $field1 . '&user_id=' . $_SESSION['user_id'] . '" class="btn btn-danger btn-sm">Decline</a>
                    </td>';
        $output .= '</tr>';
    }
} else {
    $output .= '<tr><td colspan="7" class="text-center">No records found.</td></tr>';
}

echo $output;
?>
