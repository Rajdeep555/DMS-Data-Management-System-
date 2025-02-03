<?php
ob_start();
include('../../settings/database.php');
DB::connect();


$q  = $_GET['q'];
// $branch  = $_REQUEST['branch'];

echo "<option>Select Application</option>";


$select_bookings= "SELECT * FROM `application` where `status` = 'Active' and `application_type`='$q' ";
$sql11=$dbconn->prepare($select_bookings);
$sql11->execute();
$wlvd11=$sql11->fetchAll(PDO::FETCH_OBJ);
if($sql11->rowCount() > 0){
foreach($wlvd11 as $rows11){
$application_id = $rows11->id;
$application_name = $rows11->application_name;

echo "<option value=".$application_id."> ".$application_name."</option>";
?>
 

<?php }} ?>