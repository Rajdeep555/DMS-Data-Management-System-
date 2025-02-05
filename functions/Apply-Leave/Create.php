<?php
session_start();
// require 'db_connection.php'; // Ensure your database connection is included

$table_name = 'leave_request';
$redirection_page = "index.php?module=Apply-Leave&view=List";

$employee_id = $_SESSION['user_id'];

// Fetch employee details
$get_employee_name = "SELECT * FROM `users` WHERE `id` = :employee_id AND `status` = 'Active'";
$sql = $dbconn->prepare($get_employee_name);
$sql->execute(['employee_id' => $employee_id]);
$employee_name = $sql->fetch(PDO::FETCH_OBJ);

if (!$employee_name) {
    die("Employee not found or inactive.");
}

$employee_id = $employee_name->user_unique_id;

// For Submitting The Form
if (isset($_POST['submit'])) {
    $field1 = $_POST['field1'];
    $field2 = $_POST['field2'];
    $field4 = $_POST['field4'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];

    // Handle file upload
    $leave_document = null;
    if (isset($_FILES["field3"]) && $_FILES["field3"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "./assets/images/leave-document/";
        

        // Ensure the directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["field3"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name; // Avoid filename conflicts
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "png", "pdf"];
        $uploadOk = 1;

        // Validate file type
        if (!in_array($fileType, $allowed_types)) {
            echo "Error: Only JPG, PNG & PDF files are allowed.";
            $uploadOk = 0;
        }

        // Validate file size (limit to 5MB)
        if ($_FILES["field3"]["size"] > 5000000) {
            echo "Error: Your file is too large.";
            $uploadOk = 0;
        }

        // Upload file if validation passes
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["field3"]["tmp_name"], $target_file)) {
                $leave_document = $target_file;
            } else {
                echo "Error: There was an issue uploading your file.";
            }
        }
    }

    // Insert into database
    $insert_bookings = "INSERT INTO `$table_name` (employee_id, date_from, date_to, title, description, leave_document, leave_type, leave_status, status) 
                        VALUES (:employee_id, :date_from, :date_to, :title, :description, :leave_document, :leave_type, 'Pending', 'Active')";

    $sql_insert = $dbconn->prepare($insert_bookings);
    $sql_insert->execute([
        'employee_id'   => $employee_id,
        'date_from'     => $date_from,
        'date_to'       => $date_to,
        'title'         => $field1,
        'description'   => $field2,
        'leave_document' => $leave_document,
        'leave_type'    => $field4,
    ]);

    $myid = $dbconn->lastInsertId();

    if ($myid) {
        header("Location: $redirection_page&sid=$myid");
        exit;
    } else {
        echo 'Error: Unable to submit leave request.';
    }
}
?>

<!-- Container-fluid starts -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link btn btn-lg" href="index.php?module=Apply-Leave&view=List" aria-selected="true">Applied Leaves</a>
                            <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Apply Leave</a>
                        </div>
                    </nav>
                </div>
                <form id="formID" method="POST" action="" enctype="multipart/form-data">
                    <div class="card-body mb-0">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" style="background-color:#e3dfde;color:black;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        New Leave Request
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-4">
                                            <label class="col-md-2 offset-md-2"><strong>Date From</strong> <span style="color:red;">*</span></label>
                                            <div class="col-md-6">
                                                <input class="form-control" name="date_from" type="date" required min="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label class="col-md-2 offset-md-2"><strong>Date To</strong> <span style="color:red;">*</span></label>
                                            <div class="col-md-6">
                                                <input class="form-control" name="date_to" type="date" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label class="col-md-2 offset-md-2"><strong>Reason</strong> <span style="color:red;">*</span></label>
                                            <div class="col-md-6">
                                                <input class="form-control" name="field1" type="text" placeholder="Leave reason" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label class="col-md-2 offset-md-2"><strong>Description</strong> <span style="color:red;">*</span></label>
                                            <div class="col-md-6">
                                                <input class="form-control" name="field2" type="text" placeholder="Leave description" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label class="col-md-2 offset-md-2"><strong>Attachment</strong></label>
                                            <div class="col-md-6">
                                                <input class="form-control" name="field3" type="file" accept=".jpg,.png,.pdf">
                                                <small class="form-text text-muted">Max size: 5MB. Allowed formats: JPG, PNG, PDF.</small>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label class="col-md-2 offset-md-2"><strong>Leave Type </strong> <span style="color:red;">*</span></label>
                                            <div class="col-md-6">
                                                <select class="form-select" name="field4" required>
                                                    <option selected disabled>Select Leave Type</option>
                                                    <option value="CL/SL">CL/SL</option>
                                                    <option value="EL">EL</option>
                                                    <option value="LOP">LOP</option>
                                                    <option value="Maternity">Maternity</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 mb-0 pt-0 text-center">
                        <button class="btn btn-md btn-success" type="submit" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>