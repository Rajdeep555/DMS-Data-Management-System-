
<?php

//Database Connectivity  Starts
ob_start();
include('settings/database.php');
DB::connect();
require_once("settings/session.php");



    include('view/header.php');
    include('view/loader.php');
    // page-wrapper Start
    echo '<div class="page-wrapper compact-wrapper" id="pageWrapper">';
    //  Page Header Start
    include('view/topbar.php');
    //    Page Header ends
    //    Page Body Start
    echo '<div class="page-body-wrapper">';
    // Page Sidebar Start
    include('view/sidebar.php');
    // Page Sidebar Ends
    echo '<div class="page-body">';
    include('view/breadcrumb.php');
    //Dashboard starts

    //$request_body = $_REQUEST['action'];
    $request_module = $_REQUEST['module'];
    $request_view = $_REQUEST['view'];
    if($request_view != ''){
        // include('functions/filter.php');
        include('functions/permission.php');
        $load_body = "functions/$request_module/$request_view.php";
        include("$load_body");
    }else{
        // include('functions/filter.php');
        include('functions/permission.php');
        $load_body = "functions/$request_module.php";
        include("$load_body");
    }
    // include('functions/Groups.php');
    // Dashboard Ends
    echo '</div>';
    //footer start
    include('view/footer.php');
    echo '</div>
    </div>';
    include('view/scripts.php');

    include('view/footer-end.php');

?>