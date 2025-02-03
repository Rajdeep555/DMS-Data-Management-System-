<?php
//Database Connectivity  Starts
ob_start();
include('settings/database.php');
DB::connect();
require_once("settings/session.php");

$user_role = $_SESSION["user_role"];
$module = $_REQUEST['module'];

//  $select_bookings = "SELECT * FROM `groups` where status = 'Active' and `user_grp_name`='$user_role'";
//  $sql = $dbconn->prepare($select_bookings);
//  $sql->execute();
//  $wlvd = $sql->fetchAll(PDO::FETCH_OBJ);
//  foreach ($wlvd as $rows);
//  $user_grp_id = $rows->id;

//  $select_bookings11 = "SELECT * FROM `module` where status = 'Active' and `module_name`='$module'";
//  $sql11 = $dbconn->prepare($select_bookings11);
//  $sql11->execute();
//  $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
//  foreach ($wlvd11 as $rows11);
//  $module_id = $rows11->id;

//  $select_bookings = "SELECT * FROM `module_permission` where `status` = 'Active' and mod_per_module_id='$module_id' and `mod_per_user_role`='$user_grp_id'";
//  $sql123 = $dbconn->prepare($select_bookings);
//  $sql123->execute();
//  $wlvd123 = $sql123->fetchAll(PDO::FETCH_OBJ);
//     foreach ($wlvd123 as $rows123);
//         $field1 = $rows123->id;
//         $field2 = $rows123->mod_per_module_id;
//         $field3 = $rows123->mod_per_user_role;
//         $field4 = $rows123->mod_per_all;
//         $field5 = $rows123->mod_per_view;
//         $field6 = $rows123->mod_per_update;
//         $Create = $rows123->mod_per_create;
//         $field8 = $rows123->mod_per_delete;

//         $List   = $field5;
//         $Update = $field6;
//         $Delete = $field8;

echo '$module';

                     
     ?>
