<?php

ob_start();
include('settings/database.php');
DB::connect();
//require_once("check.php");

$id = $_REQUEST['id'];
$start = $_REQUEST['start'];


// if (isset($_POST['register'])) {

// 	$user_fname    =  $_POST['user_fname'];
// 	$user_lname    =  $_POST['user_lname'];
// 	$user_phone = $_POST['user_phone'];
// 	$user_password = $_POST['user_password'];
// 	$user_role = $_POST['user_role'];
// 	$user_status = $_POST['user_status'];


// 	$temp_password = md5($user_password);



// 	$insert_bookings = "INSERT `users` SET

// 	user_fname   = '" . addslashes($user_fname) . "',
//     user_lname   = '" . addslashes($user_lname) . "',
//      user_phone   = '" . addslashes($user_phone) . "',
//      user_password   = '$temp_password',
//      user_role   = 'Admin',
// 	status   = 'Active'";


// 	$sql_insert = $dbconn->prepare($insert_bookings);
// 	$sql_insert->execute();
// 	$myid = $dbconn->lastInsertId();

// 	$message = "Details successfully updated.";
// 	$status = "success";
// 	header("Location: index.php?module=Dashboard&id=$myid");
// }

if (isset($_POST['login'])) {

	$user_phone = $_POST['user_phone'];
	$user_password = $_POST['user_password'];
	$password = md5($user_password);

	// Use prepared statement to prevent SQL injection
	$select = "SELECT * FROM `users` WHERE user_phone = :phone AND user_password = :password AND status = 'Active'";
	$sql = $dbconn->prepare($select);
	$sql->bindParam(':phone', $user_phone, PDO::PARAM_STR);
	$sql->bindParam(':password', $password, PDO::PARAM_STR);
	$sql->execute();

	$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);
	if ($sql->rowCount() > 0) {
		foreach ($wlvd as $row5) {
			$_SESSION['user_id'] = $row5->id;
			$_SESSION['user_name'] = $row5->user_name;
			$_SESSION['user_role'] = $row5->user_role;

			// Secure redirection using allowed modules mapping
			$allowed_modules = [
				'Admin' => 'Dashboard',
				'Manager' => 'Dashboard',
				'Student' => 'Welcome'
			];

			$redirect_module = isset($allowed_modules[$_SESSION['user_role']])
				? $allowed_modules[$_SESSION['user_role']]
				: 'Dashboard';

			header("Location: index.php?module=" . $redirect_module);
			exit();
		}
	} else {
		$error = "Invalid Mobile Number or Password";
	}
}


if (isset($_GET['module'])) {
	$module = $_GET['module'];
	switch ($module) {
		case "lo":
			$msg = "You are now logged out.";
			break;
	}
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
	<meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
	<meta name="author" content="pixelstrap">
	<link rel="icon" href="assets/images/logo/logo.png" type="image/x-icon">
	<link rel="shortcut icon" href="assets/images/logo/logo.png" type="image/x-icon">
	<title><?php echo 'India Web Designs - Admin Panel'; ?></title>
	<!-- Google font-->
	<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
	<!-- ico-font-->
	<link rel="stylesheet" type="text/css" href="ssets/css/vendors/icofont.css">
	<!-- Themify icon-->
	<link rel="stylesheet" type="text/css" href="assets/css/vendors/themify.css">
	<!-- Flag icon-->
	<link rel="stylesheet" type="text/css" href="assets/css/vendors/flag-icon.css">
	<!-- Feather icon-->
	<link rel="stylesheet" type="text/css" href="ssets/css/vendors/feather-icon.css">
	<!-- Plugins css start-->
	<!-- Plugins css Ends-->
	<!-- Bootstrap css-->
	<link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">
	<!-- App css-->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
	<!-- Responsive css-->
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
</head>

<body>

	<!-- start loader -->
	<div id="pageloader-overlay" class="visible incoming">
		<div class="loader-wrapper-outer">
			<div class="loader-wrapper-inner">
				<div class="loader"></div>
			</div>
		</div>
	</div>
	<!-- end loader -->


	<!-- Start wrapper-->
	<div id="wrapper">

		<div class="card-authentication2 mx-auto my-3">
			<div class="card-group">
				<div class="card mb-0">
					<div class="bg-signup2"></div>
					<div class="card-img-overlay rounded-left my-5">
						<h2 class="text-white">Login</h2>
						<h1 class="text-white">To Your Portal</h1>
						<p class="card-text text-white pt-3">Login to your portal and gets tons of exciting new features and updates.</p>
					</div>
				</div>

				<?php

				$action = $_REQUEST['module'];

				if ($action == 'Register') {
				?>

					<!-- login page start-->
					<div class="container-fluid p-0">
						<!-- <div class="row m-0">
							<div class="col-12 p-0">
								<div class="login-card login-dark">
									<div>
										<div><a class="logo" href="index.html"><img class="img-fluid for-light" width="300px" src="assets/images/logo/logo.png" alt="looginpage"><img  width="300px" class="img-fluid for-dark" src="../assets/images/logo/logo_dark.png" alt="looginpage"></a></div>
										<div class="login-main">
											<form class="theme-form" method="post" action="">
												<h4>Create your account</h4>
												<p>Enter your personal details to create account</p>
												<div class="form-group">
													<label class="col-form-label pt-0">Your Name</label>
													<div class="row g-2">
														<div class="col-6">
															<input class="form-control" type="text" name="user_fname" required="" placeholder="First name">
														</div>
														<div class="col-6">
															<input class="form-control" type="text" required="" name="user_lname" placeholder="Last name">
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-form-label">Email Address</label>
													<input class="form-control" type="text" required="" name="user_phone" placeholder="Test@gmail.com">
												</div>
												<div class="form-group">
													<label class="col-form-label">Password</label>
													<div class="form-input position-relative">
														<input class="form-control" type="password" name="user_password" required="" placeholder="*********">
														<div class="show-hide"><span class="show"></span></div>
													</div>
												</div>
												<div class="form-group mb-0">
													<div class="checkbox p-0">
														<input id="checkbox1" type="checkbox">
														<label class="text-muted" for="checkbox1">Agree with<a class="ms-2" href="#">Privacy Policy</a></label>
													</div>
													<button class="btn btn-primary btn-block w-100" type="submit" name="register">Create Account</button>
												</div>
												<h6 class="text-muted mt-4 or">Or signup with</h6>
												<div class="social mt-4">
													<div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
												</div>
												<p class="mt-4 mb-0">Already have an account?<a class="ms-2" href="authentication.php?action=Login">Sign in</a></p>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div> -->

					</div>


					<!-- <div class="card mb-0">
	    		<div class="card-body">
	    			<div class="card-content p-3">
	    				<div class="text-center">
					 		<img src="assets/images/logo-icon.png" alt="logo icon">
					 	</div>
					 <div class="card-title text-uppercase text-center py-3">Sign Up</div>
					   <form id="formID" class="m-t-30" method="post" action="">
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="exampleInputName" class="sr-only">Name</label>
							  <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Name">
							  <div class="form-control-position">
								  <i class="icon-user"></i>
							  </div>
						   </div>
						  </div>
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="exampleInputEmailId" class="sr-only">Email ID</label>
							  <input type="text" id="exampleInputEmailId" name="user_email" class="form-control" placeholder="Email ID">
							  <div class="form-control-position">
								  <i class="icon-envelope-open"></i>
							  </div>
						   </div>
						  </div>
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="exampleInputPassword" class="sr-only">Phone</label>
							  <input type="text" id="exampleInputPassword" name="user_phone" class="form-control" placeholder="Phone">
							  <div class="form-control-position">
								  <i class="icon-phone"></i>
							  </div>
						   </div>
						  </div>
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="exampleInputPassword" class="sr-only">Password</label>
							  <input type="text" id="exampleInputPassword" name="user_password" class="form-control" placeholder="Password">
							  <div class="form-control-position">
								  <i class="icon-key"></i>
							  </div>
						   </div>
						  </div>
						  
						  <div class="form-group">
						   <div class="icheck-material-primary">
			                <input type="checkbox" id="user-checkbox" checked="" />
			                <label for="user-checkbox">I Accept terms & conditions</label>
						  </div>
						 </div>
						  <br>
						  <br>
						  <br>
						  <br>
						 <input type="submit" class="btn btn-primary btn-block waves-effect waves-light" name="register" value="Register Now">
						 </form>
						 <div class="text-center pt-3"> -->

					<!--- Social Login Hidden ->
						 
						 <div class="form-row mt-4">
						  <div class="form-group mb-0 col-6">
						   <button type="button" class="btn bg-facebook text-white btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
						 </div>
						 <div class="form-group mb-0 col-6 text-right">
						  <button type="button" class="btn bg-twitter text-white btn-block"><i class="fa fa-twitter-square"></i> Twitter</button>
						 </div>
						</div>


						<--Social Login Ends ---->
					<!-- <div style="padding-bottom: 100px"></div>

						 <hr>

						 <p class="text-dark">Already have an account? <a href="authentication.php?action=Login"> Sign In here</a></p>
						 </div>
					
				 </div>
				</div>
	    	</div> -->

				<?php
				} elseif ($module == 'Login') {
				?>
					<!-- login page start-->
					<div class="container-fluid p-0">
						<div class="row m-0">
							<div class="col-12 p-0">
								<div class="login-card login-dark">
									<div>
										<div><a class="logo" href="authentication.php?module=Login"><img class="img-fluid for-light" width="300px" src="assets/images/logo/logo.png" alt="looginpage"></a></div>
										<div class="login-main">
											<form class="theme-form" method="post" action="">
												<h4>Sign in to account</h4>
												<p>Enter your phone number & password to login</p>
												<div class="form-group">
													<label class="col-form-label">Phone Number</label>
													<input class="form-control" type="text" required="" name="user_phone" placeholder="Phone Number">
												</div>
												<div class="form-group">
													<label class="col-form-label">Password</label>
													<div class="form-input position-relative">
														<input class="form-control" type="password" name="user_password" required="" placeholder="*********">
													</div>
												</div>
												<div class="form-group mb-0">
													<div class="text-end mt-3">
														<button class="btn btn-primary btn-block w-100" type="submit" name="login">Sign in</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="card mb-0">
	    		<div class="card-body">
	    			<div class="card-content p-3">
	    				<div class="text-center">
					 		<img src="assets/images/logo-icon.png" alt="logo icon">
					 	</div>
					 <div class="card-title text-uppercase text-center py-3">Sign In</div>
					     <form id="formID" class="m-t-30" method="post" action="">
						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="exampleInputName" class="sr-only">Registered Phone</label>
							  <input type="text" id="user_phone" name="user_phone" class="form-control" placeholder="Registered Phone">
							  <div class="form-control-position">
								  <i class="icon-phone"></i>
							  </div>
						   </div>
						  </div>
						   						  <div class="form-group">
						   <div class="position-relative has-icon-left">
							  <label for="exampleInputPassword" class="sr-only">Password</label>
							  <input type="password" id="exampleInputPassword" name="user_password" class="form-control" placeholder="Password">
							  <div class="form-control-position">
								  <i class="icon-key"></i>
							  </div>
						   </div>
						  </div>
						  
						   <div class="form-group">
						   <div class="icheck-material-primary">
			                <input type="checkbox" id="user-checkbox" checked="" />
			                <label for="user-checkbox">I Accept terms & conditions</label>
			                <br>
			                <br>
			                <br>
			                <br>
						  </div>
						 </div>
						  
						 <input type="submit" class="btn btn-primary btn-block waves-effect waves-light" name="login" value="Login Now">
						 </form>

						 <div class="text-center pt-3">
						  
						  Social Login Hidden ->
						 
						 <div class="form-row mt-4">
						  <div class="form-group mb-0 col-6">
						   <button type="button" class="btn bg-facebook text-white btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
						 </div>
						 <div class="form-group mb-0 col-6 text-right">
						  <button type="button" class="btn bg-twitter text-white btn-block"><i class="fa fa-twitter-square"></i> Twitter</button>
						 </div>
						</div>


						<--Social Login Ends ---->
					<!--	<div style="padding-bottom: 100px"></div>

						 <hr>

						 <p class="text-dark">Create A New Account? <a href="authentication.php?action=Register"> Sign Up here</a></p>
						 </div>
				 </div>
				</div>
	    	</div> -->

				<?php
				} elseif ($module == 'RegisterMessage') {
				?>


					<div class="card mb-0">
						<div class="card-body">
							<div class="card-content p-3">
								<div class="text-center">
									<img src="assets/images/logo-icon.png" alt="logo icon">
								</div>
								<div class="card-title text-uppercase text-center py-3">Registration Status</div>

								<p style="text-align: center;">

									<?php

									$pid = $_REQUEST['id'];
									if ($id != '') {
										$select_bookings = "SELECT * FROM `users` WHERE id = '" . $_REQUEST['id'] . "'";
										$sql = $dbconn->prepare($select_bookings);
										$sql->execute();
										$wlvd = $sql->fetchAll(PDO::FETCH_OBJ);
										foreach ($wlvd as $rows);
									}

									$user_name = $rows->user_name;
									$user_phone = $rows->user_phone;
									$user_password = $rows->user_password;

									/* 

$mss = "Dear $user_name, 
Greetings from WeBotApp!
Use your Username = $user_phone and Password = $user_password.

Regards";  
$encodedMessage = urlencode($mss); 

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://103.233.79.246/submitsms.jsp?user=PabanPT&key=14e4082d07XX&mobile=91$cus_mobile&message=$encodedMessage&senderid=RPSCAB&accusage=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} 
else {
  echo $response;
}  

*/

									if ($pid == 0) {
										echo "Dear $user_name, your registration is unsuccesful. <br>
								Kindly try again changing your phone number<br>
								";
									} else {
										echo "Dear $user_name, your registration is successful. <br>
								You can now login with your registered mobile number and password<br>
								";
									}

									?>

								</p>

								<hr>

								<p class="text-dark">Already have an account? <a href="authentication.php?module=Login"> Sign In</a></p>
								<p class="text-dark">Already have an account? <a href="authentication.php?module=Register"> Sign Up </a></p>
							</div>

						</div>
					</div>
			</div>

		<?php
				} elseif ($module == 'ForgetPassword') {

		?>

			<div class="card mb-0">
				<div class="card-body">
					<div class="card-content p-3">
						<div class="text-center">
							<img src="assets/images/logo-icon.png" alt="logo icon">
						</div>
						<div class="card-title text-uppercase text-center py-3">Forgot Password</div>
						<form>
							<div class="form-group">
								<div class="position-relative has-icon-left">
									<label for="exampleInputName" class="sr-only">Name</label>
									<input type="text" id="exampleInputName" class="form-control" placeholder="Name">
									<div class="form-control-position">
										<i class="icon-user"></i>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="position-relative has-icon-left">
									<label for="exampleInputEmailId" class="sr-only">Email ID</label>
									<input type="text" id="exampleInputEmailId" class="form-control" placeholder="Email ID">
									<div class="form-control-position">
										<i class="icon-envelope-open"></i>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="position-relative has-icon-left">
									<label for="exampleInputPassword" class="sr-only">Password</label>
									<input type="text" id="exampleInputPassword" class="form-control" placeholder="Password">
									<div class="form-control-position">
										<i class="icon-lock"></i>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="position-relative has-icon-left">
									<label for="exampleInputRetryPassword" class="sr-only">Retry Password</label>
									<input type="password" id="exampleInputRetryPassword" class="form-control" placeholder="Retry Password">
									<div class="form-control-position">
										<i class="icon-lock"></i>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="icheck-material-primary">
									<input type="checkbox" id="user-checkbox" checked="" />
									<label for="user-checkbox">I Accept terms & conditions</label>
								</div>
							</div>
							<button type="button" class="btn btn-primary btn-block waves-effect waves-light">Sign Up</button>
							<div class="text-center pt-3">
								<p>or Sign up with</p>
								<div class="form-row mt-4">
									<div class="form-group mb-0 col-6">
										<button type="button" class="btn bg-facebook text-white btn-block"><i class="fa fa-facebook-square"></i> Facebook</button>
									</div>
									<div class="form-group mb-0 col-6 text-right">
										<button type="button" class="btn bg-twitter text-white btn-block"><i class="fa fa-twitter-square"></i> Twitter</button>
									</div>
								</div>

								<hr>

								<p class="text-dark">Already have an account? <a href="authentication-signin2.html"> Sign In here</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php
				} elseif ($module == 'Logout') {
					session_start();
					if (isset($_SESSION['user_id'])) {
						unset($_SESSION['user_id']);
						session_destroy();
					}
					echo '<script language="javascript">window.parent.location.href="authentication.php?module=Login";</script>';
				}


		?>

		</div>
	</div>

	<!--Start Back To Top Button-->
	<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
	<!--End Back To Top Button-->

	</div><!--wrapper-->

	<!-- latest jquery-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- Bootstrap js-->
	<script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
	<!-- feather icon js-->
	<script src="assets/js/icons/feather-icon/feather.min.js"></script>
	<script src="assets/js/icons/feather-icon/feather-icon.js"></script>
	<!-- scrollbar js-->
	<!-- Sidebar jquery-->
	<script src="assets/js/config.js"></script>
	<!-- Plugins JS start-->
	<!-- Plugins JS Ends-->
	<!-- Theme js-->
	<script src="assets/js/script.js"></script>
	<!-- Plugin used-->
	</div>
</body>

</html>