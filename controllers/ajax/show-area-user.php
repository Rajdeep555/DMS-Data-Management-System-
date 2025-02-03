<?php
ob_start();
include('../../settings/database.php');
DB::connect();

$q = $_GET['q'];

$select_enquiry41 = "SELECT * from doctor WHERE id='$q' and status='Active'";
$sql41 = $dbconn->prepare($select_enquiry41);
$sql41->execute();
$wlvd41 = $sql41->fetchAll(PDO::FETCH_OBJ);
$doc_area = isset($wlvd41[0]) ? $wlvd41[0]->doc_city_zone : null;

$select_enquiry13 = "SELECT * FROM `users` where status = 'Active' order by id desc";
$sql13 = $dbconn->prepare($select_enquiry13);
$sql13->execute();
$wlvd13 = $sql13->fetchAll(PDO::FETCH_OBJ);

$found = false;

if ($doc_area) {
    foreach ($wlvd13 as $rows13) {
        $users_area = $rows13->user_covering_area;
        $users_area_array = explode(',', $users_area);

        if (in_array($doc_area, $users_area_array)) {
            $found = true;
            echo "<option value='{$rows13->id}'>{$rows13->user_fname} {$rows13->user_mname} {$rows13->user_lname}</option>";
        }
    }
}

if (!$found) {
    echo ""; // No users found
}
?>
