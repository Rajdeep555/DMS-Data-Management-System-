<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Fahkwang:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Unbounded:wght@200..900&display=swap" rel="stylesheet">
<style>
  .newbtnedit {
    height: 20px;
    display: flex;
    width: 20px;
    border: 1px solid blue;
    padding: 15px;
    border-radius: 100%;
    align-items: center;
    justify-content: center;
  }

  .newbtnedit i {
    color: #7366ff;
  }

  .newbtnedit:hover {
    background-color: #0000ffbf;
    transition: all 0.5s ease-in-out;
  }

  .newbtnedit:hover i {
    color: #fff;
  }

  .newbtn {
    height: 20px;
    display: flex;
    width: 20px;
    border: 1px solid red;
    padding: 15px;
    border-radius: 100%;
    align-items: center;
    justify-content: center;
  }

  .newbtn i {
    color: red;
  }

  .newbtn:hover {
    background-color: red;
    transition: all 0.5s ease-in-out;
  }

  .newbtn:hover i {
    color: #fff;
  }

  h5 {
    font-family: "Unbounded", sans-serif;
    font-weight: 400;
    font-size: 18px;
  }

  .data h6 {
    font-size: 14px;
    font-weight: 500;
  }

  .card-1:hover {
    border: 1px solid #000000 !important;
    transition: border 0.5s ease-in-out;
  }
</style>

<?php

$table_name = 'users';
$redirection_page = "index.php?module=Users&view=List";
$action_name = "module=Users&view=List";

// For Displaying the table

// if (isset($_GET['pageno'])) {
//   $pageno = $_GET['pageno'];
// } else {
//   $pageno = 1;
// }
// $no_of_records_per_page = 7;
// $offset = ($pageno - 1) * $no_of_records_per_page;

$select_enquiry = "SELECT * FROM $table_name where status = 'Active' order by id desc";
$sql = $dbconn->prepare($select_enquiry);
$sql->execute();

// $total_rows = $sql->fetchColumn();
// $total_pages = ceil($total_rows / $no_of_records_per_page);

// $select_enquiry = "SELECT * FROM $table_name where status = 'Active' order by id asc LIMIT $offset, $no_of_records_per_page";
// $sql = $dbconn->prepare($select_enquiry);
// $sql->execute();
$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);


if (isset($_GET['sid'])) {
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo '<script type="text/javascript">';
  echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Created successfully"
    });';
  echo '</script>';
} elseif (isset($_GET['eid'])) {
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
  echo '<script type="text/javascript">';
  echo 'Swal.fire({
        icon: "success",
        title: "Success",
        text: "Edited successfully"
    });';
  echo '</script>';
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
              <a class="nav-item nav-link active btn btn-lg text-primary" href="#" aria-selected="true">Users</a>
              <a class="nav-item nav-link btn btn-lg" href="index.php?module=Users&view=Create" aria-selected="false"><i class="material-icons" style="font-size:12px;">&nbsp;&nbsp;&nbsp;add</i>Create New Users</a>
              <a class="nav-item nav-link btn btn-lg" href="index.php?module=Users&view=Inactive" aria-selected="false">Inactive Users</a>

            </div>
          </nav>
        </div>

        <div class="card-body">
          <div class="row">
            <?php

            $i = 1;
            if ($sql->rowCount() > 0) {
              foreach ($wlvd as $rows) {

                $field1 = $rows->id;
                $field2 = $rows->user_fname;
                $field3 = $rows->user_mname;
                $field4 = $rows->user_lname;
                $field5 = $rows->user_phone;
                $field6 = $rows->official_email;
                $field7 = $rows->user_role;
                // Split the user role into words
                $words = explode(" ", $field7);

                // Initialize an empty string to store the first letters
                $first_letters = '';

                // Loop through each word and get its first letter
                foreach ($words as $word) {
                  // Get the first letter of each word and append it to the string
                  $first_letters .= substr($word, 0, 1);
                }

                // Now $first_letters contains the acronym of the user role
                // You can use it wherever you want, for example:


            ?>

                <!-- user profile details code start from here -->



                <div class="col-md-6 pd-2">
                  <div class="card card-1 rounded border p-1" style=" height:250px;">
                    <div class="row p-2">
                      <div class="pt-2 pe-3 text-end d-flex align-items-baseline justify-content-between gap-1 mb-2" style="border-bottom: 1px solid #00000030; padding: 15px;">
                        <h5 class="ps-3 heading2"><?php echo $field2; ?> <?php echo $field3; ?> <?php echo $field4; ?> (<?php echo "$first_letters"; ?>)</h5>
                        <div class="d-flex align-items-center justify-content-end gap-1">
                          <a class="btn newbtnedit" href="index.php?module=Users&view=Update&id=<?php echo $field1; ?>"><i class="material-icons" style="font-size:18px; border:1px soild blue;">edit</i></a>
                          <a class="newbtn" href="index.php?module=Users&view=Delete&id=<?php echo $field1; ?>" target="_self" onclick="return confirm('Are you sure you want to Remove?');"><i class="material-icons" style="font-size:18px;">delete</i></a>

                        </div>
                      </div>

                      <div class="col-md-3">
                        <?php
                        if ($rows->user_image) {
                        ?>

                          <img class="profile rounded-circle" src="assets/uploads/<?php echo $rows->user_image; ?>" width="80px" height="80px">
                        <?php
                        } else {
                        ?>
                          <img class="profile rounded-circle" src="assets/images/user-icon.jpg" width="80px" height="80px">
                        <?php
                        }
                        ?>
                      </div>
                      <div class="col-md-9 data" style="margin:auto; cursor:pointer;">
                        <div class="row" style="flex-direction:column; margin:auto; text-align:left; padding:10px;">
                          <div class="col-md-12">
                            <h6 class="heading1"> <i class="material-icons" style="font-size:10px;color:#7366ff;">call</i> <?php echo $rows->user_phone; ?></h6>
                          </div>
                          <div class="col-md-12">
                            <h6 class="heading1" style="color: blue;"> <i class="material-icons" style="font-size:10px;color:#7366ff;">email</i> <?php echo $rows->official_email; ?></h6>
                          </div>
                          <div class="col-md-12">
                            <h6 class="heading1"><i class="material-icons" style="font-size:10px;color:#7366ff;">account_circle</i></span> <?php echo $rows->user_role; ?></h6>
                          </div>
                        </div>
                      </div>
                      <hr style="width: 95%; margin:0 auto; margin-top:8px; ">

                      <div class="row px-4 pt-2">
                        <p class="para"><?php echo substr($rows->user_desc, 0, 150);
                                        if ($rows->user_desc) { ?>...<?php } ?></p>
                      </div>

                    </div>

                  </div>
                </div>
            <?php
              }
            }
            ?>

            <!-- user profile details code end from here -->

          </div>
        </div>


      </div>
    </div>
  </div>
</div>
<!-- Container-fluid Ends-->