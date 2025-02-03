<?php
require_once('../settings/database.php');

if (isset($_GET['month']) && isset($_GET['year']) && isset($_GET['user'])) {
    $month = (int)$_GET['month'];
    $year = (int)$_GET['year'];
    $user_id = (int)$_GET['user'];

    // Create DateTime objects for the start and end of the month
    $startDate = new DateTime("$year-$month-01");
    $endDate = clone $startDate;
    $endDate->modify('last day of this month'); // Get the last day of the month

    // Format the dates to be used in the SQL query
    $startDateFormatted = $startDate->format('Y-m-d');
    $endDateFormatted = $endDate->format('Y-m-d');

    $table_name = 'expenses_report';

    // Select the minimum date for each month
    $select_enquiry = "SELECT * FROM `$table_name` 
                       WHERE status = 'Active' 
                       AND ex_date BETWEEN :start_date AND :end_date 
                       AND user_id = :user_id 
                       AND approval_statuss = 'Approved'
                       GROUP BY YEAR(ex_date), MONTH(ex_date)
                       ORDER BY ex_date ASC";

    $sql = $dbconn->prepare($select_enquiry);
    $sql->bindParam(':start_date', $startDateFormatted, PDO::PARAM_STR);
    $sql->bindParam(':end_date', $endDateFormatted, PDO::PARAM_STR);
    $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $sql->execute();

    $wlvd = $sql->fetchAll(PDO::FETCH_OBJ);

    // Return the results as JSON
    if (empty($wlvd)) {
        // Return a message if no data found
        echo json_encode(['message' => 'No data found']);
    } else {
        // Return the results if found
        echo json_encode($wlvd);
    }
}
