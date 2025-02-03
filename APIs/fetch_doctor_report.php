<?php
require_once('../settings/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];
    $employee_id = $_POST['employee_name']; // Ensure this is correctly set

    // Prepare your SQL query
    $select_enquiry15 = "SELECT * FROM `doctor_report_search` WHERE doc_rep_sea_sdate BETWEEN :fromDate AND :toDate AND user_id=:employee_id AND status='Active'";
    $sql15 = $dbconn->prepare($select_enquiry15);
    $sql15->bindValue(':fromDate', $fromDate);
    $sql15->bindValue(':toDate', $toDate);
    $sql15->bindValue(':employee_id', $employee_id);
    $sql15->execute();
    $wlvd15 = $sql15->fetchAll(PDO::FETCH_OBJ);


    $select_enquiry22 = "SELECT * FROM `covering_area` WHERE status='Active'";
    $sql22 = $dbconn->prepare($select_enquiry22);
    $sql22->execute();
    $coveringAreas = $sql22->fetchAll(PDO::FETCH_OBJ);

    // Create a mapping of city numbers to area names
    $areaMapping = [];
    foreach ($coveringAreas as $area) {
        $areaMapping[$area->id] = $area->covering_area_name; 
    }


    // Check if any data is returned
    if (count($wlvd15) > 0) {
        $si = 1; // Initialize counter
        $displayedUserIds = [];
        $output = ''; 

        foreach ($wlvd15 as $row15) {
            $u_id = $row15->user_id;
            $data_id = $row15->id;

            // Add user ID to the displayed list
            $displayedUserIds[] = $u_id;
            $select_enquiry23 = "SELECT * FROM `users` WHERE id = :userId AND status='Active'";
            $sql23 = $dbconn->prepare($select_enquiry23);
            $sql23->bindValue(':userId', $u_id);
            $sql23->execute();
            $wlvd23 = $sql23->fetch(PDO::FETCH_OBJ);
            if ($wlvd23) {
                $user_fname = $wlvd23->user_fname;
                $user_mname = $wlvd23->user_mname;
                $user_lname = $wlvd23->user_lname;
            } else {
                $user_fname = $user_mname = $user_lname = 'Unknown';
            }

            $output .= '<tr>';
            $output .= '<td>' . $si . '</td>';
            $output .= '<td>' . $user_fname . ' ' . $user_mname . ' ' . $user_lname . '</td>';
           $output .= '<td id="date__" 
                data-toggle="modal" data-target=".bd-example-modal-lg"
                data-employee-name="' . $user_fname . ' ' . $user_mname . ' ' . $user_lname . '" 
                data-date="' . (new DateTime($row15->doc_rep_sea_sdate))->format('Y-m-d') . '" 
                data-id="' . htmlspecialchars($row15->id) . '">' . 
                (new DateTime($row15->doc_rep_sea_sdate))->format('d-m-Y') . 
            '</td>';
            $output .= '<td>' . ($areaMapping[$row15->doc_rep_sea_startcity] ?? 'Unknown') . '</td>'; // Start City
            $output .= '<td>' . ($areaMapping[$row15->doc_rep_sea_workcity] ?? 'Unknown') . '</td>'; // Work City
            $output .= '<td>' . ($areaMapping[$row15->doc_rep_sea_endcity] ?? 'Unknown') . '</td>'; // End City
            // $output .= '<td>' . ($doc_name ?? 'Unknown') . '</td>'; 
            $output .= '</tr>';
            $si++;
        }

        echo $output; // Output the rows
    } else {
        echo '<tr><td colspan="7" class="text-center">No data found for the selected date range.</td></tr>';
    }
}
?>
