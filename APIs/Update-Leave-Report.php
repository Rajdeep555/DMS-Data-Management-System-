<?php
include('../settings/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve and sanitize POST data
        $employeeId = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
        $leaveType = isset($_POST['leave_type']) ? stripslashes(trim($_POST['leave_type'])) : '';
        $dateFrom = isset($_POST['date_from']) ? trim($_POST['date_from']) : '';
        $dateTo = isset($_POST['date_to']) ? trim($_POST['date_to']) : '';

        // Calculate the number of leave days
        $daysDifference = (strtotime($dateTo) - strtotime($dateFrom)) / (60 * 60 * 24) + 1;
        $daysDifference = max(0, intval($daysDifference));

        // Validate inputs
        if (empty($employeeId) || empty($leaveType) || empty($dateFrom) || empty($dateTo)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
            exit;
        }

        // Prepare SQL query with CASE statement
        $updateQuery = "
            UPDATE leave_report 
            SET 
                sl_used = CASE WHEN :leave_type = 'SL/CL' THEN sl_used + :days_difference ELSE sl_used END,
                el_used = CASE WHEN :leave_type = 'EL' THEN el_used + :days_difference ELSE el_used END,
                lop_used = CASE WHEN :leave_type = 'LOP' THEN lop_used + :days_difference ELSE lop_used END,
                mat_used = CASE WHEN :leave_type = 'Maternity' THEN mat_used + :days_difference ELSE mat_used END
            WHERE employee_id = :employee_id AND status = 'Active'
        ";

        // Prepare the statement
        $updateStmt = $dbconn->prepare($updateQuery);
        $updateStmt->bindParam(':leave_type', $leaveType, PDO::PARAM_STR);
        $updateStmt->bindParam(':days_difference', $daysDifference, PDO::PARAM_INT);
        $updateStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_STR);

        // Execute query
        if ($updateStmt->execute()) {
            if ($updateStmt->rowCount() > 0) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Leave report updated successfully.',
                    'employee_id' => $employeeId,
                    'leave_type' => $leaveType,
                    'days_difference' => $daysDifference
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No changes made. Employee might not exist or already has the same leave balance.'
                ]);
            }
        }

        // Close statement
        $updateStmt->closeCursor();
    } catch (Exception $e) {
        error_log("Error in Update-Leave-Report.php: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An internal error occurred.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

// Close DB connection
$dbconn = null;
