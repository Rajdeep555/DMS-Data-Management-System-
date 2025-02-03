<?php

// not working 
require_once('../settings/database.php');

$response = ['success' => false, 'message' => 'Invalid input.'];

if (isset($_POST['user_id']) && isset($_POST['status'])) {
    $id = $_POST['user_id'];  // Note: this is actually an id, not a user_id
    $status = $_POST['status'];

    $sql = "UPDATE `expenses_report` SET `approval_statuss` = :status WHERE `id` = :id";
    $stmt = $dbconn->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => 'Status updated successfully', 'id' => $id];
    } else {
        $response = ['success' => false, 'message' => 'Failed to update status'];
    }
} else {
    $response['message'] = 'Required parameters are missing.';
}

// Return the JSON response
echo json_encode($response);
?>
