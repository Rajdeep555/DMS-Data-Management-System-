<?php

$table_name = 'leave_report';
$redirection_page = "index.php?module=Leave-Output-Report&view=List";


// For Submitting The Form

if (isset($_POST['submit'])) {
    $field1    =  $_POST['year'];
    $field2    =  $_POST['user'];
    $field3    =  $_POST['sl_cl'];
    $field4    =  $_POST['el'];
    $field5    =  $_POST['lop'];
    $field6    =  $_POST['maternity_leave'];

    $insert_bookings = "INSERT `$table_name` SET
    leave_year   = '" . addslashes($field1) . "',   
    employee_id   = '" . addslashes($field2) . "',
    sl_eligible   = '" . addslashes($field3) . "',
    el_eligible   = '" . addslashes($field4) . "',
    lop_eligible   = '" . addslashes($field5) . "',
    mat_eligible   = '" . addslashes($field6) . "',
    status   = 'Active'";


    $sql_insert = $dbconn->prepare($insert_bookings);
    $sql_insert->execute();
    $myid = $dbconn->lastInsertId();

    $message = "Details successfully updated.";
    $status = "success";
    if ($myid) {
        header("Location: $redirection_page&sid=$myid");
    } else {
        echo 'error';
    }
}


?>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-0">
                    <nav style="font-size:20px;">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link  btn btn-lg" href="index.php?module=Leave-Output-Report&view=List" aria-selected="true">Leave Report</a>
                            <a class="nav-item nav-link active btn btn-lg  text-primary" href="#" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Module</a>
                        </div>
                    </nav>
                </div>
                <form id="formID" method="POST" action="">
                    <div class="card-body mb-0">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" style="background-color:#e3dfde;color:black;" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        New Leave Report
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Year</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <select class="form-control" id="yearSelect" name="year" required>
                                                    <option value="" disabled selected>Select Year</option>
                                                    <?php
                                                    $currentYear = date("Y");
                                                    for ($i = 0; $i <= 5; $i++) {
                                                        echo "<option value='" . ($currentYear + $i) . "'>" . ($currentYear + $i) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>User</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="user" id="userSearch" type="text" placeholder="Search User" onkeyup="searchUsers()" required>
                                                <div id="userResults" class="dropdown-menu" style="display:none;"></div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>SL/CL</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="sl_cl" id="sl-cl" type="text" placeholder="Eg. 10" required>

                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>EL</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="el" id="el" type="text" placeholder="Eg. 10" required>

                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>LOP</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="lop" id="lop" type="text" placeholder="Eg. 10" required>

                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-2"><label><strong>Maternity Leave</strong> <span style="color:red;">*</span></label></div>
                                            <div class="col-md-6">
                                                <input class="form-control" name="maternity_leave" id="maternity-leave" type="text" placeholder="Eg. 10" required>

                                            </div>
                                            <div class="col-md-2"></div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer border-0 mb-0 pt-0">
                        <div class="row">
                            <div class="col-md-5"></div>
                            <div class="col-md-1">
                                <!-- <button type="button" class="btn btn-md btn-danger">Close</button> -->
                            </div>
                            <div class="col-md-1">
                                <button class="btn  btn-md btn-success me-3" type="submit" name="submit" value="submit">Save</button>
                            </div>
                            <div class="col-md-5"></div>
                        </div>
                    </div>
                    <input type="hidden" name="user" id="userUniqueId" required>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function searchUsers() {
        var input = document.getElementById('userSearch').value;
        var resultsContainer = document.getElementById('userResults');

        if (input.length === 0) {
            resultsContainer.style.display = 'none';
            return;
        }

        fetch('search_users.php?query=' + input)
            .then(response => response.json())
            .then(data => {
                resultsContainer.innerHTML = ''; // Clear previous results

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(user => {
                        var fullName = `${user.user_fname || ''} ${user.user_mname || ''} ${user.user_lname || ''}`.trim();
                        var uniqueId = user.user_unique_id || '';

                        var item = document.createElement('div');
                        item.className = 'dropdown-item';
                        item.textContent = `${fullName} (${uniqueId})`;

                        item.onclick = function() {
                            document.getElementById('userSearch').value = `${fullName} (${uniqueId})`;
                            document.getElementById('userUniqueId').value = uniqueId;
                            resultsContainer.style.display = 'none';
                        };

                        resultsContainer.appendChild(item);
                    });

                    resultsContainer.style.display = 'block'; // Show results
                } else {
                    resultsContainer.style.display = 'none'; // Hide if no results
                }
            })
            .catch(error => console.error('Error fetching users:', error));
    }
</script>