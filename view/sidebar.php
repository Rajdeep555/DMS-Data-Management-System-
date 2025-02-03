<?php
include('../functions/permission.php');
$user_role = $_SESSION["user_role"];

$user_id = $_SESSION['user_id'];

?>

<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
  <div>
    <div class="logo-wrapper" style="padding: 13px 30px;"><a href="index.php?module=Dashboard"><img class="img-fluid for-light" src="assets/images/logo/logo.png" alt="Monsut Logo" width="100px"><img class="img-fluid for-dark" src="assets/images/logo/logo_dark.png" alt=""></a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
      <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
    </div>
    <div class="logo-icon-wrapper"><a href="index.php?module=Dashboard"><img class="img-fluid" style="max-width: 36px; height: 23px;" src="assets/images/logo/logo-icon.png" alt=""></a></div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
          <li class="back-btn"><a href="index.php?module=Dashboard"><img class="img-fluid" style="max-width: 36px; height: 23px;" src="assets/images/logo/logo-icon.png" alt=""></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          </li>
          <li class="sidebar-main-title">
            <div>
              <h6 class="lan-1">General</h6>
            </div>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="index.php?module=Dashboard">
              <svg class="stroke-icon">
                <use href="assets/svg/icon-sprite.svg#stroke-home"></use>
              </svg>
              <svg class="fill-icon">
                <use href="assets/svg/icon-sprite.svg#fill-file"></use>
              </svg><span><b>Dashboard</b></span></a></li>
          <?php
          if ($user_role == 'Admin') {
          ?>
            <li class="sidebar-list">
              <!-- <label class="badge badge-light-primary">5</label> -->
              <a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon">
                  <use href="assets/svg/icon-sprite.svg#stroke-file"></use>
                </svg>
                <svg class="fill-icon">
                  <use href="assets/svg/icon-sprite.svg#fill-file"></use>
                </svg>
                <span><b>Admin Management</b></span>
              </a>
              <ul class="sidebar-submenu">
                <li><a href="index.php?module=Groups&view=List"><b>Groups</b></a></li>
                <li><a href="index.php?module=Application&view=List"><b>Application</b></a></li>
                <li><a href="index.php?module=Module&view=List"><b>Module</b></a></li>
                <li><a href="index.php?module=Groups Mapping&view=List"><b>Groups Mapping</b></a></li>
                <li><a href="index.php?module=Users&view=List"><b>Users Profile</b></a></li>
                <li><a href="index.php?module=User Mapping&view=List"><b>User Mapping</b></a></li>
                <li><a href="index.php?module=Permissions&view=List"><b>Permissions</b></a></li>
              </ul>
            </li>
          <?php
          } else {
          ?>
            <!--<li class="sidebar-list">-->
            <!-- <label class="badge badge-light-primary">5</label> -->
            <!--    <a class="sidebar-link sidebar-title" href="#">-->
            <!--      <svg class="stroke-icon">-->
            <!--        <use href="assets/svg/icon-sprite.svg#stroke-file"></use>-->
            <!--      </svg>-->
            <!--      <svg class="fill-icon">-->
            <!--        <use href="assets/svg/icon-sprite.svg#fill-file"></use>-->
            <!--      </svg>-->
            <!--      <span><b>Management</b></span>-->
            <!--    </a>-->
            <!--    <ul class="sidebar-submenu">-->
            <!--      <li><a href="index.php?module=User Mapping&view=List"><b>User Mapping</b></a></li>-->
            <!--    </ul>-->
            <!--  </li>-->
          <?php
          }
          ?>
          <li class="sidebar-main-title">
            <div>
              <h6 class="">Applications</h6>
            </div>
          </li>

          <?php

          // $select_bookings= "SELECT * FROM `module` where `status` = 'Active' and `module_application`='$application_id' ";
          // $sql1=$dbconn->prepare($select_bookings);
          // $sql1->execute();
          // $wlvd1=$sql1->fetchAll(PDO::FETCH_OBJ);

          // foreach($wlvd1 as $rows1);
          //   $mid = $rows1->id;
          //   $module_name = $rows1->module_name;
          //   $module_name = $rows1->module_application;

          $select_bookings = "SELECT * FROM `groups` where status = 'Active' and `user_grp_name`='$user_role'";
          $sql = $dbconn->prepare($select_bookings);
          $sql->execute();
          $wlvd = $sql->fetchAll(PDO::FETCH_OBJ);
          foreach ($wlvd as $rows);
          $user_grp_id = $rows->id;


          // SELECT A.application_name, B.module_name, C.* FROM application as A, module as B, `module_permission` as C WHERE A.id=B.module_application and B.id=C.mod_per_module_id and C.mod_per_view='1';

          $select_bookings = "SELECT distinct C.id FROM `module_permission` as A, module as B, application as C WHERE C.id=B.module_application and B.id=A.mod_per_module_id and A.mod_per_user_role='$user_grp_id' and (A.mod_per_view='1' or A.mod_per_create='1') and A.status='Active' and B.status='Active'";
          $sql123 = $dbconn->prepare($select_bookings);
          $sql123->execute();
          $wlvd123 = $sql123->fetchAll(PDO::FETCH_OBJ);
          foreach ($wlvd123 as $rows123) {
            $application = $rows123->id;



            $select_bookings = "SELECT * FROM `application` where status = 'Active' and id='$application' ";
            $sql11 = $dbconn->prepare($select_bookings);
            $sql11->execute();
            $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
            foreach ($wlvd11 as $rows11);
            $application_name = $rows11->application_name;



          ?>
            <li class="sidebar-list">
              <!-- <label class="badge badge-light-primary">5</label> -->
              <a class="sidebar-link sidebar-title" href="#">
                <svg class="stroke-icon">
                  <use href="assets/svg/icon-sprite.svg#stroke-file"></use>
                </svg>
                <svg class="fill-icon">
                  <use href="assets/svg/icon-sprite.svg#fill-file"></use>
                </svg>
                <span><b><?php echo "$application_name"; ?></b></span>
              </a>

              <ul class="sidebar-submenu">
                <?php
                $select_bookings = "SELECT distinct B.module_name FROM application as A, module as B, `module_permission` as C WHERE A.id=B.module_application and B.id=C.mod_per_module_id  and C.mod_per_user_role='$user_grp_id' and B.module_application='$application'  and (C.mod_per_view='1' or C.mod_per_create='1') and C.status='Active' and B.status='Active'";
                $sql1234 = $dbconn->prepare($select_bookings);
                $sql1234->execute();
                $wlvd1234 = $sql1234->fetchAll(PDO::FETCH_OBJ);
                foreach ($wlvd1234 as $rows1234) {
                  $module_name = $rows1234->module_name;

                  // $select_bookings = "SELECT * FROM `module` where status = 'Active' and  `module_application`='$application_id'";
                  // $sql11 = $dbconn->prepare($select_bookings);
                  // $sql11->execute();
                  // $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
                  // if ($sql11->rowCount() > 0) {
                  //   foreach ($wlvd11 as $rows11) {
                  //     $module_id = $rows11->id;
                  //     $module_name = $rows11->module_name;
                  //     $module_group = $rows11->module_group;
                  //     $module_application = $rows11->module_application;



                ?>

                  <li><a href="index.php?module=<?php echo "$module_name"; ?>&view=List"><b><?php echo "$module_name"; ?></b></a></li>
                <?php
                }
                // }
                ?>
              </ul>

            </li>
          <?php
          }


          // }
          ?>
          <?php


          //   }
          // }
          ?>

        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>