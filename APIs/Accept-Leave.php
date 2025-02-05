<?php
// Include database dbconnection
include('../settings/database.php'); // Update with your actual database dbconnection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID from the POST request
    $leaveId = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($leaveId > 0) {
        // Prepare and execute the SQL statement to update the leave status
        $stmt = $dbconn->prepare("UPDATE leave_request SET leave_status = 'Accepted' WHERE id = :id AND status='Active'");
        $stmt->bindParam(':id', $leaveId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Success response
            echo json_encode(['status' => 'success', 'message' => 'Leave request accepted.']);
        } else {
            // Error response
            echo json_encode(['status' => 'error', 'message' => 'Failed to accept leave request.']);
        }

        $stmt->closeCursor();
    } else {
        // Invalid ID response
        echo json_encode(['status' => 'error', 'message' => 'Invalid leave request ID.']);
    }
} else {
    // Invalid request method response
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

// Close the database dbconnection
$dbconn = null; // Properly close the PDO connection
