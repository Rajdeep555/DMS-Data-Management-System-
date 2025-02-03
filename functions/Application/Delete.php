<?php

$table_name = 'application';
$redirection_page = "index.php?module=Application&view=List";
$id = $_REQUEST['id'];

$delete_statement = "UPDATE `$table_name` SET
   status   = 'Inactive'
   where id='" . $id . "'";


$sql_insert = $dbconn->prepare($delete_statement);
$sql_insert->execute();

header("Location: $redirection_page&id=$id");

?>
