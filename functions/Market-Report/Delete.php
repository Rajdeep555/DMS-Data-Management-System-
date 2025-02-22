<?php

$table_name = 'travel_log';
$redirection_page = "index.php?module=Market-Report&view=List";
$id = $_GET['id'];


$delete_statement = "UPDATE `$table_name` SET
   status   = 'Inactive'
   where id='" . $id . "'";


$sql_insert = $dbconn->prepare($delete_statement);
$sql_insert->execute();

header("Location: $redirection_page&id=$id");
