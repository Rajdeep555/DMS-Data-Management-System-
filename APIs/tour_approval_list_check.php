<?php
session_start();
require_once('../settings/database.php');

$table_name = 'tour';
$user_id = $_SESSION['user_id'];

$date = isset($_POST['date_']) ? $_POST['date_'] : ''; // full year in YYYY format
$month = isset($_POST['month']) ? $_POST['month'] : ''; // month in MM format

// SQL query to fetch the active tours with accepted/rejected status
// Joining with covering_area to get the names of the cities
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
    AND t.approval_status IN ('Accepted', 'Rejected')
";

// Only add the date range if both month and year are provided
if (!empty($date) && !empty($month)) {
    // Create the start and end date for the month
    $startDate = $date . '-' . $month . '-01';
    $endDate = date("Y-m-t", strtotime($startDate)); // Get last day of the month
    $query .= " AND t.tou_tour_date BETWEEN :start_date AND :end_date";
}

$query .= " ORDER BY t.id DESC";

$stmt = $dbconn->prepare($query);

// Bind parameters for date range if month and year are set
if (!empty($date) && !empty($month)) {
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($stmt->rowCount() > 0) {
    foreach ($results as $row) {
        echo "<tr>
            <td>{$row->id}</td>
            <td>{$row->tou_tour_date}</td>
            <td>{$row->start_city_name}</td>  <!-- Start city name -->
            <td>{$row->work_city_name}</td>   <!-- Work city name -->
            <td>{$row->end_city_name}</td>    <!-- End city name -->
            <td style='color: " . ($row->approval_status == 'Accepted' ? 'green' : 'red') . "'>
                {$row->approval_status}
            </td>
          </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}

// <td>{$row->tou_doctor_visit}</td>
// <td>{$row->tou_chemist_visit}</td>
?>
