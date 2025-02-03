<?php
require_once('../settings/database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare your SQL statement to fetch all doctor's reports
    $sql = "SELECT doc_report_doc_id, doc_report_gift, doc_report_sample, doc_report_lbl FROM doctors_report WHERE doc_report_searchid = :id AND status='Active'";
    $stmt = $dbconn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all report data
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare an array to hold the complete results
    $finalResults = [];

    if ($results) {
        // Loop through each report to get the doctor's name
        foreach ($results as $result) {
            // Get the doctor ID from the report
            $doctorId = $result['doc_report_doc_id'];

            // Prepare your SQL statement to fetch the doctor's name
            $sqlDoctor = "SELECT doc_name FROM doctor WHERE id = :doctor_id AND status='Active'";
            $stmtDoctor = $dbconn->prepare($sqlDoctor);
            $stmtDoctor->bindParam(':doctor_id', $doctorId, PDO::PARAM_INT);
            $stmtDoctor->execute();

            // Fetch the doctor's name
            $doctorResult = $stmtDoctor->fetch(PDO::FETCH_ASSOC);

            // Add the doctor's name to the report result
            if ($doctorResult) {
                $result['doctor_name'] = $doctorResult['doc_name'];
            } else {
                $result['doctor_name'] = 'Unknown Doctor'; // Handle case if doctor not found
            }

            // Add the complete result to the final results array
            $finalResults[] = $result;
        }

        // Return the final results as JSON
        echo json_encode($finalResults);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
} else {
    echo json_encode(['error' => 'Invalid ID']);
}
?>
