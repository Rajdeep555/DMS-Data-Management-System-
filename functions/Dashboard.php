<!-- Container-fluid starts-->
<link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.4.0/fonts/remixicon.css"
    rel="stylesheet" />
<?php
session_start();

$user_id = $_SESSION["user_id"];
$select_user = "SELECT * FROM `users` where status = 'Active' and id = '$user_id' ";
$sql = $dbconn->prepare($select_user);
$sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);
foreach ($wlvd as $rows);
$field1 = $rows->id;
$user_role = $rows->user_role;
$user_fname = $rows->user_fname;
$user_mname = $rows->user_mname;
$user_lname = $rows->user_lname;
$user_image = $rows->user_image;


?>


<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        border: none;
        position: relative;
        margin-bottom: 30px;
        box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
    }

    .l-bg-cherry {
        background: linear-gradient(to right, #493240, #f09) !important;
        color: #fff;
    }

    .l-bg-blue-dark {
        background: linear-gradient(to right, #373b44, #4286f4) !important;
        color: #fff;
    }

    .l-bg-green-dark {
        background: linear-gradient(to right, #0a504a, #38ef7d) !important;
        color: #fff;
    }

    .l-bg-orange-dark {
        background: linear-gradient(to right, #a86008, #ffba56) !important;
        color: #fff;
    }

    .card .card-statistic-3 .card-icon-large .fas,
    .card .card-statistic-3 .card-icon-large .far,
    .card .card-statistic-3 .card-icon-large .fab,
    .card .card-statistic-3 .card-icon-large .fal {
        font-size: 110px;
    }

    .card .card-statistic-3 .card-icon {
        text-align: center;
        line-height: 50px;
        margin-left: 15px;
        color: #000;
        position: absolute;
        right: -5px;
        top: 20px;
        opacity: 0.1;
    }

    .l-bg-cyan {
        background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
        color: #fff;
    }

    .l-bg-green {
        background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
        color: #fff;
    }

    .l-bg-orange {
        background: linear-gradient(to right, #f9900e, #ffba56) !important;
        color: #fff;
    }

    .l-bg-cyan {
        background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
        color: #fff;
    }


    b {
        cursor: pointer;
        /* color: green; */
        text-align: end;
    }

    .widget-content {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .widget-child {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .widget-content .widget-child img {
        height: 70px;
        width: 70px;
    }

    .profile_img {
        height: 140px;
        width: 150px;
        border-radius: 60%;
    }

    .border {

        border-radius: 60%;
        border: 4px solid #fff !important;
    }

    a h4 {
        color: black;
    }

    @media (max-width: 575px) {
        .profile-box .cartoons img {
            width: 90px;
            height: 90px;
        }

        .profile_img {
            height: 140px;
            width: 150px;
            border-radius: 50%;
        }

        .profile-box .cartoons {
            right: 10px;
        }
    }

    .flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 3px;
        cursor: pointer;
    }

    .flex div {
        display: flex;
        align-items: flex-end;
        flex-direction: column;
        justify-content: center;
    }

    .flex div h5 {
        margin-top: 10px;
        font-size: 16px;
        font-weight: 600;
        font-family: 'Courier New', Courier, monospace;
    }

    .flex div h5:hover {
        color: green;
        transition: color 0.5s ease-in-out;
    }

    .flex div span {
        display: inline-block;
        height: 20px;
        width: 20px;
        background-color: #2F2F3B;
        border-radius: 100%;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .flex div span i {
        font-size: 10px;
        color: #fff;
    }

    #imgs:hover {
        scale: 1.03;
        transition: scale 0.5s ease-in-out;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
<div class="container-fluid">
    <div class="row widget-grid">

        <!-- card starts  -->
        <div class="container">
            <div class="row ">
                <div class="col-xl-4 col-lg-4">
                    <div class="card l-bg-cherry">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">Reports</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        <?php
                                        $select_report = "SELECT count(*) as total_report FROM `travel_log` WHERE status='Active'";
                                        $sql = $dbconn->prepare($select_report);
                                        $sql->execute();
                                        $report = $sql->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($report as $rows);
                                        $total_report = $rows->total_report;
                                        echo $total_report;
                                        ?>
                                    </h2>
                                </div>
                                <div class="col-4 text-right">
                                    <!-- <span>12.5% <i class="fa fa-arrow-up"></i></span> -->
                                </div>
                            </div>
                            <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="card l-bg-blue-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">Leave Request</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        <?php
                                        $select_report = "SELECT count(*) as total_report FROM `leave_request` WHERE leave_status='Pending' AND status='Active'";
                                        $sql = $dbconn->prepare($select_report);
                                        $sql->execute();
                                        $report = $sql->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($report as $rows);
                                        $total_report = $rows->total_report;
                                        echo $total_report;
                                        ?>
                                    </h2>
                                </div>
                                <div class="col-4 text-right">
                                    <!-- <span>9.23% <i class="fa fa-arrow-up"></i></span> -->
                                </div>
                            </div>
                            <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="card l-bg-green-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">Department</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        <?php
                                        $select_report = "SELECT count(*) as total_report FROM `departments` WHERE status='Active'";
                                        $sql = $dbconn->prepare($select_report);
                                        $sql->execute();
                                        $report = $sql->fetchAll(PDO::FETCH_OBJ);
                                        foreach ($report as $rows);
                                        $total_report = $rows->total_report;
                                        echo $total_report;
                                        ?>
                                    </h2>
                                </div>
                                <div class="col-4 text-right">
                                    <!-- <span>10% <i class="fa fa-arrow-up"></i></span> -->
                                </div>
                            </div>
                            <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xl-4 col-lg-4">
                    <div class="card l-bg-orange-dark">
                        <div class="card-statistic-3 p-4">
                            <div class="card-icon card-icon-large"><i class="fas fa-dollar-sign"></i></div>
                            <div class="mb-4">
                                <h5 class="card-title mb-0">Revenue Today</h5>
                            </div>
                            <div class="row align-items-center mb-2 d-flex">
                                <div class="col-8">
                                    <h2 class="d-flex align-items-center mb-0">
                                        $11.61k
                                    </h2>
                                </div>
                                <div class="col-4 text-right">
                                    <span>2.5% <i class="fa fa-arrow-up"></i></span>
                                </div>
                            </div>
                            <div class="progress mt-1 " data-height="8" style="height: 8px;">
                                <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- card ends  -->

    </div>
</div>


<script>
    window.onload = function() {
        document.querySelector(".customizer-links").style.display = "none";
    };
</script>