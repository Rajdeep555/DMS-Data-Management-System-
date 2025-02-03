<?php
// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', 'error.log');

// Start output buffering to catch any unexpected output
ob_start();

session_start();

include('../../settings/database.php');


// Set headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

try {
    // Log received data
    error_log("Received POST data in check-salary-exists.php: " . print_r($_POST, true));

    if (!isset($_POST['employee_id']) || !isset($_POST['month']) || !isset($_POST['year'])) {
        throw new Exception(
            'Missing required fields: ' .
                (!isset($_POST['employee_id']) ? 'employee_id ' : '') .
                (!isset($_POST['month']) ? 'month ' : '') .
                (!isset($_POST['year']) ? 'year' : '')
        );
    }

    $employee_id = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Format month-year string
    $month_year = sprintf("%02d-%d", $month, $year);

    error_log("Checking for salary record: Employee ID: $employee_id, Month-Year: $month_year");

    // Verify database connection
    if (!isset($dbconn)) {
        throw new Exception('Database connection not established');
    }

    $query = "SELECT COUNT(*) FROM salary_details 
              WHERE employee_id = :employee_id 
              AND month_year = :month_year 
              AND status = 'Active'";

    error_log("Executing query: $query");

    $stmt = $dbconn->prepare($query);
    if (!$stmt) {
        throw new Exception("Query preparation failed: " . print_r($dbconn->errorInfo(), true));
    }

    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':month_year', $month_year);

    if (!$stmt->execute()) {
        error_log("Query execution failed: " . print_r($stmt->errorInfo(), true));
        throw new Exception("Failed to check existing salary record");
    }

    $count = $stmt->fetchColumn();
    error_log("Found $count matching records");

    $response = array(
        'exists' => $count > 0,
        'success' => true,
        'debug' => array(
            'employee_id' => $employee_id,
            'month_year' => $month_year,
            'count' => $count
        )
    );

    error_log("Sending response: " . json_encode($response));
    echo json_encode($response);
} catch (Exception $e) {
    error_log("Error in check-salary-exists.php: " . $e->getMessage());
    echo json_encode(array(
        'success' => false,
        'error' => $e->getMessage()
    ));
}

// End output buffering
ob_end_flush();
