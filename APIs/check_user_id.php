<?php
session_start();
require_once('../settings/database.php');
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $query = "SELECT * FROM users WHERE user_unique_id = :user_id AND status='Active'";
    $stmt = $dbconn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo 'found';
    } else {
        echo 'not found';
    }
}
?>
