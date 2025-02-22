<?php
$table_name = 'travel_log';
$redirection_page = "index.php?module=Market-Report&view=List";
$employee_id = $_SESSION['user_id'];


// echo $employee_id . "==========";
// get the user_unique_id 


if (isset($_POST['submit'])) {

    // Get form inputs
    $employee_id_      = $_POST['employee_id_'] ?? null; // Ensure employee ID is captured
    $name             = $_POST['name'];
    $date             = $_POST['date'];
    $opening_km       = $_POST['opening_km'];
    $closing_km       = $_POST['closing_km'];
    $km_travelled     = $closing_km - $opening_km; // Auto-calculate traveled km
    $farm_visit       = $_POST['farm_visit'];
    $retailer_visit   = $_POST['retailer_visit'];
    $collection       = $_POST['collection'];
    $status           = 'Active'; // Default value

    // Prepare the SQL insert statement
    $insert_query = "INSERT INTO $table_name 
        (employee_id, name, date, opening_km, closing_km, km_travel, no_of_farm_visits, no_of_retailer_visits, collection, status, created_at) 
        VALUES 
        (:employee_id, :name, :date, :opening_km, :closing_km, :km_travelled, :farm_visit, :retailer_visit, :collection, :status, NOW())";

    // Prepare and execute the statement
    $stmt = $dbconn->prepare($insert_query);
    $stmt->bindParam(':employee_id', $employee_id_, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':opening_km', $opening_km, PDO::PARAM_INT);
    $stmt->bindParam(':closing_km', $closing_km, PDO::PARAM_INT);
    $stmt->bindParam(':km_travelled', $km_travelled, PDO::PARAM_INT);
    $stmt->bindParam(':farm_visit', $farm_visit, PDO::PARAM_INT);
    $stmt->bindParam(':retailer_visit', $retailer_visit, PDO::PARAM_INT);
    $stmt->bindParam(':collection', $collection, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    // Execute and check for success
    if ($stmt->execute()) {
        $myid = $dbconn->lastInsertId();
        header("Location: $redirection_page&sid=$myid");
        exit;
    } else {
        echo 'Error: Unable to insert data';
    }
}

$user_unique_id_query = "SELECT user_unique_id FROM users WHERE status = 'Active' AND id = :employee_id";
$stmt_unique_id = $dbconn->prepare($user_unique_id_query);
$stmt_unique_id->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
$stmt_unique_id->execute();
$user_unique_id = $stmt_unique_id->fetchColumn();
?>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link btn btn-lg" href="index.php?module=Market-Report&view=List" aria-selected="true">All Reports</a>
                            <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="false">
                                <i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Report
                            </a>
                        </div>
                    </nav>
                </div>
                <form id="formID" method="POST" action="">
                    <div class="card-body mb-0">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" style="background-color:#e3dfde;color:black;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        New Module
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <!-- <input class="form-control" name="employee_id_" type="text" value="<?= $user_unique_id ?>" required> -->
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Name</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="name" type="text" placeholder="Name" required>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Date</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="date" type="date" required>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Opening KM</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="opening_km" type="number" placeholder="Opening KM" required>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Closing KM</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="closing_km" type="number" placeholder="Closing KM" required>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>No. of Farm Visits</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="farm_visit" type="number" placeholder="No. of Farm Visits">
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>No. of Retailer Visits</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="retailer_visit" type="number" placeholder="No. of Retailer Visits">
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Collection</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="collection" type="text" placeholder="Collection">
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" type="submit" name="submit">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>