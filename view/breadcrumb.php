<?php
    $url = $_SERVER['REQUEST_URI'];
    $items = explode('/', $url);

     $request_body = $_REQUEST['module'];
     $request_view = $_REQUEST['view'];
?>
<div class="container-fluid">        
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h5><a href="index.php?module=<?php echo ucfirst($request_body); ?>&view=<?php echo ucfirst($request_view); ?>"><?php echo ucfirst($request_body); ?></a> / <?php echo ucfirst($request_view); ?></h5>
                <!-- <h3><?php 
                // echo ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)); 
                ?></h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php?module=Dashboard"><svg class="stroke-icon">
                      <use href="assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                    <li class="breadcrumb-item"><?php echo $items[sizeof($items) - 2]; ?></li>
                    <!-- <li class="breadcrumb-item active"><?php 
                    // echo ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
                     ?></li> -->
                    <li class="breadcrumb-item active"><?php echo ucfirst($request_body); ?> / <?php echo ucfirst($request_view); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

