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
  $user_desc = $rows->user_desc;
  $user_image = $rows->user_image;
  $user_email = $rows->user_email;
  $user_phone = $rows->user_phone;


  $select_doctor = "SELECT * FROM `doctor` where status = 'Active' order by id desc";
  $sql1 = $dbconn->prepare($select_doctor);
  $sql1->execute();


  ?>

<!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="user-profile">
      <div class="row">
        <!-- user profile first-style start-->
        <div class="col-sm-12">
          <div class="card  text-center">
              <div class="row pt-2">
                  <div class="col-md-10 col-sm-10 col-lg-10"></div>
                  <div class="col-md-2 col-sm-2 col-lg-2">
                    <a href="index.php?module=Profile&view=Update" class="btn btn-lg text=right"><i class="icofont icofont-pencil-alt-5"></i></a>
                  </div>
              </div>
            <div class="card-body">
            <div class="info border" style="margin-left:40px;margin-right:40px;padding:20px;">
            <div class="user-image">
              <div class="avatar">
                <?php if(!$user_image){ ?>
                <img alt="" src="assets/uploads/<?php echo $user_image; ?>" height="180" weight="150" class=" pb-2">
              <?php }else{ ?>
              <img alt="" src="assets/uploads/" height="180" weight="150" class=" pb-2">
              <?php } ?>
                </div>
              <!--<div class="icon-wrapper"><i class="icofont icofont-pencil-alt-5"></i></div>-->
            </div>
           
              <div class="row">
                <div class=" col-md-2 col-sm-2 col-lg-2 order-sm-1 order-xl-0"></div>
                <div class=" col-md-8 col-sm-8 col-lg-8">
                    <h5><b><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?></b></h5>
                    <h6><?php echo $user_role; ?></h6>
                </div>
                <div class=" col-md-2 col-sm-2 col-lg-2 order-sm-1 order-xl-0"></div>
              </div>
              <div class="row">
                <div class="col-sm-2 col-lg-2 order-sm-2 order-xl-0"></div>
                <div class="col-sm-8 col-lg-8 order-sm-8 order-xl-0">
                  <div class="row pb-2">
                    <div class="col-md-6">
                      <div class="ttl-info text-center">
                        <h6><i class="fa fa-envelope"></i>   Email</h6><span><?php echo $user_email; ?></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="ttl-info text-center">
                        <h6><i class="fa fa-phone"></i>   Contact Us</h6><span><?php echo $user_phone; ?></span>
                        
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1 col-lg-1 col-md-1 order-sm-0 order-xl-1"></div>
                <div class="col-sm-10 col-lg-10 col-md-10 order-sm-0 order-xl-1">
                  <div class="ttl-info text-center">
                    <h6><i class="fa fa-envelope"></i>   Description</h6><p><?php echo $user_desc; ?></p>
                  </div>
                </div>
                <div class="col-sm-1 col-lg-1 col-md-1 order-sm-0 order-xl-1"></div>
            </div>
            </div>
            </div>
          </div>
        </div>
        <!-- user profile first-style end-->
      </div>
    </div>
 </div>