<?php
ob_start();
include('../../settings/database.php');
DB::connect();


echo "<option selected disabled>";
echo "<td>Choose City</td>";
echo "</option>";

$q  = $_GET['q'];

$select_bookings = "SELECT * FROM `location` where `status` = 'Active' and `loc_sate_id`='$q' ";
$sql11 = $dbconn->prepare($select_bookings);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd11 as $rows11) {

   $loc_city_name = $rows11->loc_city_name;
?>
   <option value="<?=$rows11->id?>"><?= $loc_city_name ?></option>

<?php

}







?>