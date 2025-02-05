<?php

$table_name = 'leave_report';
$redirection_page = "index.php?module=Leave-Output-Report&view=Lists";
$action_name = "module=Leave-Output-Report&view=List";

?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 23px;
            margin-bottom: 20px;
        }

        .form-container {
            margin-bottom: 20px;
            text-align: center;
        }

        select {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }

        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<div class="container-fluid">
    <h1>Leave Output Report</h1>
    <div class="form-container">
        <form method="GET" id="leaveReportForm">
            <label for="year">Select Year:</label>
            <select name="year" id="year">
                <option value="">--Select Year--</option>
                <?php
                // Generate options for the last 10 years
                for ($i = date("Y"); $i >= date("Y") - 5; $i--) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <a href="javascript:void(0);" onclick="submitForm();" style="padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Submit</a>
        </form>
    </div>
</div>

<script>
    function submitForm() {
        var year = document.getElementById('year').value;
        if (year) {
            window.location.href = "index.php?module=Leave-Output-Report&view=Lists&year=" + year;
        } else {
            alert("Please select a year.");
        }
    }
</script>