<?php

$table_name = 'countries';
$redirection_page = "index.php?module=Countries&view=List";
$id= $_GET['id'];

$delete_statement = "UPDATE `$table_name` SET
   status   = 'Inactive'
   where id='".$id."'";   
  
  
  $sql_insert = $dbconn->prepare($delete_statement);
  $sql_insert->execute();
  
  header("Location: $redirection_page&id=$id");


  ?>