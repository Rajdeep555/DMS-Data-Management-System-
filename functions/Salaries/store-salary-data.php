<?php
session_start();
header('Content-Type: application/json');

// Raw input को विस्तार से लॉग करें
$raw_input = file_get_contents('php://input');
error_log('Raw input received: ' . $raw_input);
error_log('Raw input length: ' . strlen($raw_input));
error_log('Raw input type: ' . gettype($raw_input));

// Request headers को लॉग करें
$headers = getallheaders();
error_log('Request headers: ' . print_r($headers, true));

// Request method को लॉग करें
error_log('Request method: ' . $_SERVER['REQUEST_METHOD']);

// JSON validation से पहले इनपुट की जांच करें
if (empty($raw_input)) {
    error_log('Empty input received');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Empty input received',
        'details' => 'No data was sent to the server'
    ]);
    exit;
}

// JSON डीकोड करें और एरर को कैप्चर करें
$data = json_decode($raw_input, true);
$json_error = json_last_error();
error_log('JSON decode error code: ' . $json_error . ' - ' . json_last_error_msg());

// डीकोड किए गए डेटा को लॉग करें
error_log('Decoded data: ' . print_r($data, true));

if ($json_error === JSON_ERROR_NONE && $data) {
    // Store data in session
    $_SESSION['salary_create_data'] = [
        'employee_id' => $data['employee_id'],
        'employee_name' => $data['employee_name'],
        'designation' => $data['designation'],
        'month' => $data['month'],
        'year' => $data['year'],
        'timestamp' => $data['timestamp']
    ];

    // Debug log
    error_log('Session data set: ' . print_r($_SESSION['salary_create_data'], true));

    // Send success response
    echo json_encode(['success' => true]);
} else {
    error_log('JSON decode failed. Raw input was: ' . $raw_input);
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid JSON data received',
        'details' => json_last_error_msg(),
        'received_data' => $raw_input
    ]);
}
