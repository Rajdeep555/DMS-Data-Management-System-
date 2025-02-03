<?php
require_once('../settings/database.php');
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['ids']) && isset($data['action'])) {
    $ids = $data['ids'];
    $action = $data['action'];

    // Prepare the appropriate SQL statement based on action
    if ($action === 'accept') {
        $update_status = "UPDATE tour SET approval_status = 'Accepted' WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";
    } else if ($action === 'reject') {
        $update_status = "UPDATE tour SET approval_status = 'Rejected' WHERE id IN (" . implode(',', array_fill(0, count($ids), '?')) . ")";
    }

    $stmt = $dbconn->prepare($update_status);

    // Bind each ID
    foreach ($ids as $index => $id) {
        $stmt->bindValue($index + 1, $id); // Bind values starting from 1
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
