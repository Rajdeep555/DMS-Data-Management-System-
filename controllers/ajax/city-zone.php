<?php
ob_start();
include('../../settings/database.php');
DB::connect();


echo "<option selected disabled>";
echo "<td> City Zone </td>";
echo "</option>";

$q  = $_GET['q'];

$select_bookings = "SELECT * FROM `doctor` where `status` = 'Active' and `doc_city_id`='$q' ";
$sql11 = $dbconn->prepare($select_bookings);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd11 as $rows11) {

   $doc_city_zone = $rows11->doc_city_zone;
?>
   <option><?= $doc_city_zone ?></option>

<?php

}

?>