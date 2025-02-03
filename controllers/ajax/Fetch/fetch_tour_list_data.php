<?php
// Include your database connection
session_start();
ob_start();
include('../.././settings/database.php');
DB::connect();


$no_of_records_per_page = 10;
$offset = 0; 

$table_name = "tour";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "User is not logged in.";
    exit; // Stop execution if no user ID is found in the session
}

// Check if the date is provided
if (isset($_POST['date_']) && !empty($_POST['date_'])) {
    $selectedDate = $_POST['date_'];

    // Query to filter data by date
    $query = "SELECT * FROM $table_name WHERE status = 'Active' AND tou_tour_date = :selected_date AND user_id = :user_id ORDER BY id DESC LIMIT :offset, :records_per_page";
    $stmt = $dbconn->prepare($query);
    $stmt->bindParam(':selected_date', $selectedDate);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $no_of_records_per_page, PDO::PARAM_INT);
} else {
    // Query to get all records by default
    $query = "SELECT * FROM $table_name WHERE status = 'Active' AND user_id = :user_id ORDER BY id DESC LIMIT :offset, :records_per_page";
    $stmt = $dbconn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':records_per_page', $no_of_records_per_page, PDO::PARAM_INT);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($stmt->rowCount() > 0) {
    foreach ($results as $row) {
        // Fetch the location names based on city IDs
        $startCityQuery = "SELECT loc_city_name FROM location WHERE id = :start_city AND status = 'Active'";
        $startCityStmt = $dbconn->prepare($startCityQuery);
        $startCityStmt->bindParam(':start_city', $row->tou_start_city);
        $startCityStmt->execute();
        $startCity = $startCityStmt->fetch(PDO::FETCH_OBJ);

        $workCityQuery = "SELECT loc_city_name FROM location WHERE id = :work_city AND status = 'Active'";
        $workCityStmt = $dbconn->prepare($workCityQuery);
        $workCityStmt->bindParam(':work_city', $row->tou_work_city);
        $workCityStmt->execute();
        $workCity = $workCityStmt->fetch(PDO::FETCH_OBJ);

        $endCityQuery = "SELECT loc_city_name FROM location WHERE id = :end_city AND status = 'Active'";
        $endCityStmt = $dbconn->prepare($endCityQuery);
        $endCityStmt->bindParam(':end_city', $row->tou_end_city);
        $endCityStmt->execute();
        $endCity = $endCityStmt->fetch(PDO::FETCH_OBJ);

        // Create table rows dynamically
        echo "<tr>
                <td>{$row->id}</td>
                <td>{$row->tou_tour_date}</td>
                <td>{$startCity->loc_city_name}</td>
                <td>{$workCity->loc_city_name}</td>
                <td>{$endCity->loc_city_name}</td>
                <td>" . (!empty($row->tou_doctor_visit) ? $row->tou_doctor_visit : 'No') . "</td>
                <td>" . (!empty($row->tou_chemist_visit) ? $row->tou_chemist_visit : 'No') . "</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}
?>
