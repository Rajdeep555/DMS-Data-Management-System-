<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
// ... existing code ...
header('Content-Type: application/json');
require './settings/database.php'; // Adjust the path as necessary

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $dbconn->prepare("SELECT id, user_fname, user_mname, user_lname, user_unique_id FROM users WHERE status = 'Active' AND (user_fname LIKE :query OR user_mname LIKE :query OR user_lname LIKE :query)");
    $stmt->execute(['query' => '%' . $query . '%']);

    // Fetch results
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return results as JSON
    echo json_encode($users);
} else {
    echo json_encode([]);
}
