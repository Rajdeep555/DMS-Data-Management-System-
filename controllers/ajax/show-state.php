<?php
ob_start();
include('../../settings/database.php');
DB::connect();


echo "<option selected disabled>";
echo "<td>Choose State</td>";
echo "</option>";

$q  = $_GET['q'];

$select_bookings = "SELECT * FROM `state` where `status` = 'Active' and `st_country_id`='$q' ";
$sql11 = $dbconn->prepare($select_bookings);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd11 as $rows11) {

   $sta_state_name = $rows11->sta_state_name;
?>
   <option value="<?=$rows11->id?>"><?= $sta_state_name ?></option>

<?php

}







?>