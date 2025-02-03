<?php
ob_start();
include('../../settings/database.php');
DB::connect();



?>
<style>
   label {
      padding-top: 5px;
   }

   img {
      width: 100px;
      height: 80px;
      margin-top: 10px;

   }
</style>
<?php


$q  = $_GET['q'];
$branch  = $_REQUEST['branch'];


$select_bookings = "SELECT * FROM `professionals_package` where `status` = 'Active' and `id`='$q' ";
$sql11 = $dbconn->prepare($select_bookings);
$sql11->execute();
$wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
if ($sql11->rowCount() > 0) {
   foreach ($wlvd11 as $rows11) {
      $prof_id = $rows11->id;
      $prof_prof_name = $rows11->prof_prof_name;
      $prof_country_id = $rows11->prof_country_id;
      $prof_sate_id = $rows11->prof_sate_id;
      $prof_city_id = $rows11->prof_city_id;
      $prof_doc_specialties_id = $rows11->prof_doc_specialties_id;
      $prof_city_zone = $rows11->prof_city_zone;
      $prof_doctor_upload = $rows11->prof_doctor_upload;

      // code for country name

      $select_bookings112 = "SELECT * FROM `countries` where `status` = 'Active' and `id`=$rows11->prof_country_id";
      $sql112 = $dbconn->prepare($select_bookings112);
      $sql112->execute();
      $wlvd112 = $sql112->fetchAll(PDO::FETCH_OBJ);
      foreach ($wlvd112 as $row112);

      // code for state name

      $select_bookings1123 = "SELECT * FROM `state` where `status` = 'Active' and `id`=$rows11->prof_sate_id";
      $sql1123 = $dbconn->prepare($select_bookings1123);
      $sql1123->execute();
      $wlvd1123 = $sql1123->fetchAll(PDO::FETCH_OBJ);
      foreach ($wlvd1123 as $row1123);

      // code for City name

      $select_bookings11234 = "SELECT * FROM `location` where `status` = 'Active' and `id`=$rows11->prof_city_id";
      $sql11234 = $dbconn->prepare($select_bookings11234);
      $sql11234->execute();
      $wlvd11234 = $sql11234->fetchAll(PDO::FETCH_OBJ);
      foreach ($wlvd11234 as $row11234);


      // code for specialties name

      $select_bookings112345 = "SELECT * FROM `doctor_categories` where `status` = 'Active' and `id`=$rows11->prof_doc_specialties_id";
      $sql112345 = $dbconn->prepare($select_bookings112345);
      $sql112345->execute();
      $wlvd112345 = $sql112345->fetchAll(PDO::FETCH_OBJ);
      foreach ($wlvd112345 as $row112345);



   }
}
?>

 <form method='POST' enctype='multipart/form-data'>
         <input name='field1' type='hidden' class='form-control' placeholder='Proffesional user Id' value='<?= $prof_id ?>'>

         <label>Doctor Name</label>
         <select name='field2' class='form-control radius_border_2'>
            <option value=''><?= $prof_prof_name ?></option>
         </select>

         <label>Country Name</label>
         <select name='field3' class='form-control radius_border_2'>
            <option value='<?= $row112->id ?>'><?= $row112->countries_name ?></option>
         </select>

         <label>State Name</label>
         <select name='field4' class='form-control radius_border_2'>
            <option value='<?= $row1123->id ?>'><?= $row1123->sta_state_name ?></option>
         </select>

         <label>City Name</label>
         <select name='field5' class='form-control radius_border_2'>
            <option value='<?= $row11234->id ?>'><?= $row11234->loc_city_name ?></option>
         </select>

         <label>City Zone</label>
         <select name='field6' class='form-control radius_border_2'>
            <option value=''><?= $prof_city_zone ?></option>
         </select>


         <label>Specialties Name</label>
         <select name='field7' class='form-control radius_border_2'>
            <option value='<?= $row112345->id ?>'><?= $row112345->doc_cate_name ?></option>
         </select>

         <button name='submit' value="submit" type='' class='btn btn-info'>Submit</button>

      </form>




<?php

// $table_name = 'doctor_reports';


if (isset($_POST['submit'])) {
   $field1    =  $_POST['field1'];
   $field2    =  $_POST['field2'];
   $field3    =  $_POST['field3'];
   $field4    =  $_POST['field4'];
   $field5    =  $_POST['field5'];
   $field6    =  $_POST['field6'];
   $field7    =  $_POST['field7'];
   $field8    =  $_POST['field8'];

   // $insert_query22 = "INSERT INTO `doctor_reports`(`dc_re_prof_pack_id`, `dc_re_prof_id`, `dc_re_prof_conty_id`, `dc_re_prof_sta_id`, `dc_re_prof_cty_id`, `dc_re_prof_zone_name`, `dc_re_prof_speci_id`,`status`) VALUES ('$field1','$field2','$field3','$field4','$field5','$field6','$field7','Active')";
   // $sql22 = $dbconn->prepare($insert_query22);
   // $sql22->execute();
   // $myid = $dbconn->lastInsertId();
   // if ($myid) {
   //    header("Location: $redirection_page&id=$myid");
   // } else {
   //    echo 'error';
   // }

   $insert_bookings1 = "INSERT `doctor_reports` SET
      dc_re_prof_pack_id   = '" . addslashes($field1) . "',
      dc_re_prof_id     = '" . addslashes($field2) . "',
      dc_re_prof_conty_id   = '" . addslashes($field3) . "',   
      dc_re_prof_sta_id   = '" . addslashes($field4) . "',
      dc_re_prof_cty_id   = '" . addslashes($field5) . "',
      dc_re_prof_zone_name   = '" . addslashes($field6) . "', 
      dc_re_prof_speci_id   = '" . addslashes($field7) . "', 
     status   = 'Active'";

     $sql_insert1 = $dbconn->prepare($insert_bookings1);
     $sql_insert1->execute();
     $myid = $dbconn->lastInsertId();
  
     $message = "Details successfully updated.";
     $status = "success";

     

}



?>