<?php

$table_name = 'users';
$redirection_page = "index.php?module=Users&view=List";
$id = $_GET['id'];

$delete_statement = "UPDATE `$table_name` SET
-- user_status   = 'INACTIVE',
   status   = 'Inactive'
   where id='".$id."'";   
  
  
  $sql_insert = $dbconn->prepare($delete_statement);
  $sql_insert->execute();
  
  header("Location: $redirection_page&id=$id");

  ?>