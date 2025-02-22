<?php
$table_name = 'travel_log';
$redirection_page = "index.php?module=Market-Report&view=List";
$employee_id = $_SESSION['user_id'];

if (isset($_POST['update'])) {
    // Get form inputs
    $id               = $_POST['id'];
    $employee_id      = $_POST['employee_id'];
    $name             = $_POST['name'];
    $date             = $_POST['date'];
    $opening_km       = $_POST['opening_km'];
    $closing_km       = $_POST['closing_km'];
    $farm_visit       = $_POST['farm_visit'];
    $retailer_visit   = $_POST['retailer_visit'];
    $collection       = $_POST['collection'];
    $status           = 'Active'; // Default value

    // Calculate distance traveled, ensuring it's non-negative
    $km_travelled = max(0, $closing_km - $opening_km);

    // Prepare the update query
    $update_query = "UPDATE $table_name SET 
        employee_id = :employee_id,
        name = :name,
        date = :date,
        opening_km = :opening_km,
        closing_km = :closing_km,
        km_travel = :km_travelled,
        no_of_farm_visits = :farm_visit,
        no_of_retailer_visits = :retailer_visit,
        collection = :collection,
        status = :status,
        updated_at = NOW()
        WHERE id = :id";

    try {
        $stmt = $dbconn->prepare($update_query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':opening_km', $opening_km, PDO::PARAM_INT);
        $stmt->bindParam(':closing_km', $closing_km, PDO::PARAM_INT);
        $stmt->bindParam(':km_travelled', $km_travelled, PDO::PARAM_INT);
        $stmt->bindParam(':farm_visit', $farm_visit, PDO::PARAM_INT);
        $stmt->bindParam(':retailer_visit', $retailer_visit, PDO::PARAM_INT);
        $stmt->bindParam(':collection', $collection, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: $redirection_page&uid=$id"); // Redirect after update
            exit;
        } else {
            echo "<p style='color:red;'>Error: Unable to update data.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Database Error: " . $e->getMessage() . "</p>";
    }
}

// Fetch existing data for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $select_query = "SELECT * FROM $table_name WHERE id = :id";
    $stmt = $dbconn->prepare($select_query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo "<p style='color:red;'>Error: Record not found.</p>";
        exit;
    }
}
?>

<!-- Form for updating travel log -->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link btn btn-lg" href="index.php?module=Market-Report&view=List">All Reports</a>
                            <a class="nav-item nav-link active btn btn-lg text-primary">Edit Report</a>
                        </div>
                    </nav>
                </div>

                <form id="formID" method="POST" action="">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']) ?>">
                    <input type="hidden" name="employee_id" value="<?= htmlspecialchars($data['employee_id']) ?>">

                    <div class="card-body">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" style="background-color:#e3dfde;color:black;" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        Update Report
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show">
                                    <div class="accordion-body">

                                        <div class="row mb-4">
                                            <div class="col-md-2"><label><strong>Name</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="name" type="text" value="<?= htmlspecialchars($data['name']) ?>" required>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"><label><strong>Date</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="date" type="date" value="<?= htmlspecialchars($data['date']) ?>" required>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"><label><strong>Opening KM</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="opening_km" type="number" value="<?= htmlspecialchars($data['opening_km']) ?>" required>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"><label><strong>Closing KM</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="closing_km" type="number" value="<?= htmlspecialchars($data['closing_km']) ?>" required>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"><label><strong>No. of Farm Visits</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="farm_visit" type="number" value="<?= htmlspecialchars($data['no_of_farm_visits']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"><label><strong>No. of Retailer Visits</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="retailer_visit" type="number" value="<?= htmlspecialchars($data['no_of_retailer_visits']) ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"><label><strong>Collection</strong></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="collection" type="text" value="<?= htmlspecialchars($data['collection']) ?>">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-success" type="submit" name="update">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>