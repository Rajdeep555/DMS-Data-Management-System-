<?php
ob_start();
include('../../settings/database.php');
DB::connect();

$group  = $_GET['group'];


$select_bookings = "SELECT * FROM `user_mapping` where `status` = 'Active' and `user_map_parent`='$group' ";
$sql11 = $dbconn->prepare($select_bookings);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd11 as $rows11);
    $user_map_child = $rows11->user_map_child;


$select_bookings = "SELECT * FROM `users` where `status` = 'Active' and `id`='$user_map_child' ";
$sql12 = $dbconn->prepare($select_bookings);
$sql12->execute();
$wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd12 as $rows12);
$u_role = $rows12->user_role;

if($u_role){
?>
<select id="child5" name="child5"  class="form-select"  onchange="showGroup5(this.value)">
            <!--<option value="0">Select</option>-->
            <!--</select>-->
<option selected disabled>Select <?= $u_role ?></option>


<?php
echo $group;


foreach ($wlvd11 as $rows11){
    $user_map_child = $rows11->user_map_child;


$select_bookings = "SELECT * FROM `users` where `status` = 'Active' and `id`='$user_map_child' ";
$sql12 = $dbconn->prepare($select_bookings);
$sql12->execute();
$wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd12 as $rows12) {

   $user_fname = $rows12->user_fname;
    $user_mname = $rows12->user_mname; 
    $user_lname = $rows12->user_lname;
?>
   <option value="<?= $user_map_child ?>"><?= $user_fname ?> <?= $user_mname ?> <?= $user_lname ?></option>

<?php
}
}
echo $user_map_child;
?>

</select>
<?php
}
?>