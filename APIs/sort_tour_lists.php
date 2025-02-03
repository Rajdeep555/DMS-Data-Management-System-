<?php
session_start();
require_once('../settings/database.php');

// Helper function to get city names
function getCityName($dbconn, $city_id) {
    $query = "SELECT covering_area_name FROM covering_area WHERE id = :city_id";
    $stmt = $dbconn->prepare($query);
    $stmt->bindParam(':city_id', $city_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    // Return the city name or 'Unknown' if not found
    return $result ? $result->covering_area_name : 'Unknown';
}

$table_name = 'tour';
$user_id = $_SESSION['user_id'];

$date = isset($_POST['date_']) ? $_POST['date_'] : '';
$month = isset($_POST['month']) ? $_POST['month'] : '';

$query = "SELECT DATE_FORMAT(tou_tour_date, '%Y-%m') AS month, MIN(tou_tour_date) AS first_date, tou_start_city, tou_work_city, tou_end_city, approval_status 
          FROM `$table_name` 
          WHERE status = 'Active'";

// Check if a date and month have been provided
if (!empty($date) && !empty($month)) {
    $startDate = $date . '-' . $month . '-01';
    $endDate = date("Y-m-t", strtotime($startDate));
    $query .= " AND tou_tour_date BETWEEN :start_date AND :end_date";
}

$query .= " GROUP BY month ORDER BY first_date DESC"; // Group by month

$stmt = $dbconn->prepare($query);

// Bind parameters if a date and month are provided
if (!empty($date) && !empty($month)) {
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($stmt->rowCount() > 0) {
    $counter = 1; // Initialize a counter for row numbering

    foreach ($results as $row) {
        // Use the function to get the city names
        $start_city_name = getCityName($dbconn, $row->tou_start_city);
        $work_city_name = getCityName($dbconn, $row->tou_work_city);
        $end_city_name = getCityName($dbconn, $row->tou_end_city);

        $color = 'black';
        if ($row->approval_status == 'Accepted') {
            $color = 'green';
        } elseif ($row->approval_status == 'Pending') {
            $color = 'orange';
        } else {
            $color = 'red';
        }

        // Use the counter variable to display row number
        echo "<tr>
                <td>{$counter}</td> 
                <td>{$row->first_date}</td> 
                <td>{$start_city_name}</td>
                <td>{$work_city_name}</td>
                <td>{$end_city_name}</td>
                <td style='color: $color;'>{$row->approval_status}</td>
        </tr>";

        // Increment the counter
        $counter++;
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
