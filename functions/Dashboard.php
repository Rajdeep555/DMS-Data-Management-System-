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

<div class="container-fluid">
    <div class="row widget-grid">

    </div>
</div>


<script>
    window.onload = function() {
        document.querySelector(".customizer-links").style.display = "none";
    };
</script>