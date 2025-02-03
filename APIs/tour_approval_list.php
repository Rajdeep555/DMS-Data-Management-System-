<?php
session_start();
require_once('../settings/database.php');

$table_name = 'tour';
$user_id = $_SESSION['user_id'];

$employee_id = isset($_POST['employee']) ? $_POST['employee'] : ''; // Employee ID
$date = isset($_POST['date_']) ? $_POST['date_'] : ''; // full year in YYYY format
$month = isset($_POST['month']) ? $_POST['month'] : ''; // month in MM format

// Initialize an array to hold the results
$response = [];

// Check if both date and month are provided before proceeding
if (!empty($date) && !empty($month)) {
    // Create the start and end date for the month
    $startDate = $date . '-' . $month . '-01';
    $endDate = date("Y-m-t", strtotime($startDate));
    $query = "
        SELECT t.*, 
               start_area.covering_area_name AS start_city_name, 
               work_area.covering_area_name AS work_city_name, 
               end_area.covering_area_name AS end_city_name
        FROM $table_name t
        LEFT JOIN covering_area start_area ON t.tou_start_city = start_area.id
        LEFT JOIN covering_area work_area ON t.tou_work_city = work_area.id
        LEFT JOIN covering_area end_area ON t.tou_end_city = end_area.id
        WHERE t.status = 'Active' 
        AND t.user_id = :employee 
        AND t.approval_status = 'Pending' 
        AND t.tou_tour_date BETWEEN :start_date AND :end_date 
        ORDER BY t.id DESC
    ";

    $stmt = $dbconn->prepare($query);
    $stmt->bindParam(':employee', $employee_id);
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
} else {
    // If date and month are not provided, fetch all pending requests
    $query = "
        SELECT t.*, 
               start_area.covering_area_name AS start_city_name, 
               work_area.covering_area_name AS work_city_name, 
               end_area.covering_area_name AS end_city_name
        FROM $table_name t
        LEFT JOIN covering_area start_area ON t.tou_start_city = start_area.id
        LEFT JOIN covering_area work_area ON t.tou_work_city = work_area.id
        LEFT JOIN covering_area end_area ON t.tou_end_city = end_area.id
        WHERE t.status = 'Active' 
        AND t.user_id = :employee 
        AND t.approval_status = 'Pending' 
        ORDER BY t.id DESC
    ";

    $stmt = $dbconn->prepare($query);
    $stmt->bindParam(':employee', $employee_id);
}

// Execute the query
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_OBJ);

// Prepare the response
if ($stmt->rowCount() > 0) {
    foreach ($results as $row) {
        $tourDate = DateTime::createFromFormat('Y-m-d', $row->tou_tour_date);
        $formattedDate = $tourDate ? $tourDate->format('d-m-Y') : 'Invalid date';

        $response[] = [
            'id' => $row->id,
            'date' => $formattedDate,
            'start_city' => $row->start_city_name,
            'work_city' => $row->work_city_name,
            'end_city' => $row->end_city_name,
        ];
    }
} else {
    $response[] = ['message' => 'No records found'];
}

// Add a property to indicate that buttons should be shown at the end
$response[] = [
    'show_buttons' => true,
];

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
