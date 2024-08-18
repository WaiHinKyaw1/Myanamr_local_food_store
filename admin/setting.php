<?php
require_once("../storage/user_db.php");
require_once("../storage/auth_user.php");
require_once("../storage/database.php");
require_once("./layout/header.php");


$name_error = $email_error = $phone_error = $address_error = $name = $email = $address = $phone = $current_pass_error = $new_pass_error = "";
$validation = true;
$user_id = $user['user_id'];

if (isset($_POST['profile_update'])) {

	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];

	if ($name === "") $name_error = "Name is blank";
	if ($email === "") $email_error = "email is blank";
	if ($phone === "") $phone_error = "phone is blank";
	if ($address === "") $address_error = "address is blank";
	if ($validation) {

		$user_update = update_user($mysqli, $user_id, $name, $email, $phone, $address);
		if ($user_update) {
			$_SESSION['status'] = "Update Success";
			$_SESSION['status_code'] = "success";
			header("Location: ./setting.php");
			exit();
		} else {
			$_SESSION['status'] = "Update Fail";
			$_SESSION['status_code'] = "error";
			header("Location: ./setting.php");
			exit();

		}
	}
}

if (isset($_POST['change_pass'])) {
	$current_pass = $_POST['current_password'];
	$new_password = $_POST['new_password'];
	$old_pass = $user['password'];
	if ($current_pass === "") {
		$validation = false;
		$current_pass_error = "Password is Null";
	}

	if ($new_password === "") {
		$validation = false;
		$new_pass_error = "Password is Null";
	}
	if ($validation) {

		if (password_verify($current_pass, $old_pass)) {
			$newhash = password_hash($new_password, PASSWORD_DEFAULT);
			$update_pass = update_password_user($mysqli, $user_id, $newhash);
			if ($update_pass) {
				$_SESSION['status'] = " Password Update Success";
                $_SESSION['status_code'] = "success";
				header("Location: ./setting.php");
				exit();
			}else{
				$_SESSION['status'] = "Password Update Fail";
                $_SESSION['status_code'] = "error";
				header("Location: ./setting.php");
				exit();
			}
		} else {
			$_SESSION['status'] = "Password not same";
			$_SESSION['status_code'] = "warning";
			header("Location: ./setting.php");
			exit();
		}
	}
}
require_once("./layout/navbar.php");
require_once("./layout/sidebar.php");
?>


<div class="dashboard-wrapper">
	<div class="dashboard-ecommerce">
		<div class="container-fluid dashboard-content ">
			<div class="row">
				<div class="col-lg-4 col-sm-4">
						<div class="card">
							<div class="card-body">
							
							<div class="d-flex flex-column align-items-center text-center">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">

							</div>
							<ul class="list-group list-group-flush">
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0">Name</h6>
									<span class="text-secondary"><?php echo $user['name'] ?></span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0">Email</h6>
									<span class="text-secondary"><?php echo $user['email'] ?></span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0">Phone</h6>
									<span class="text-secondary"><?php echo $user['phone'] ?></span>
								</li>
								<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
									<h6 class="mb-0">Address</h6>
									<span class="text-secondary"><?php echo $user['address'] ?></span>
								</li>
								<li>
									<button class="btn btn-primary w-100" data-toggle="modal" data-target="#profile" alt="">Edit</button>
									<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
										<div class="modal-dialog modal-info modal-dialog-centered" role="document">
											<div class="modal-content bg-gradient-secondary">
												<div class="modal-header">
													<p class="modal-title" id="modal-title-notification">Profile</p>
													<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													<div class="py-3 text-center">
														<form action="" method="post">
															<div class="card">
																<div class="card-body">
																	<div class="row mb-3">
																		<div class="col-sm-3">
																			<h6 class="mb-0">Full Name</h6>
																		</div>
																		<div class="col-sm-9 text-secondary">
																			<input type="text" name="name" class="form-control" value="<?php echo $user['name'] ?>">
																		</div>
																	</div>
																	<div class="row mb-3">
																		<div class="col-sm-3">
																			<h6 class="mb-0">Email</h6>
																		</div>
																		<div class="col-sm-9 text-secondary">
																			<input type="text" class="form-control" name="email" value="<?php echo $user['email'] ?>">
																		</div>
																	</div>
																	<div class="row mb-3">
																		<div class="col-sm-3">
																			<h6 class="mb-0">Phone</h6>
																		</div>
																		<div class="col-sm-9 text-secondary">
																			<input type="text" class="form-control" name="phone" value="<?php echo $user['phone'] ?>">
																		</div>
																	</div>

																	<div class="row mb-3">
																		<div class="col-sm-3">
																			<h6 class="mb-0">Address</h6>
																		</div>
																		<div class="col-sm-9 text-secondary">
																			<input type="text" class="form-control" name="address" value="<?php echo $user['address'] ?>">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-primary" name="profile_update">Save Change</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</li>
							</ul>

							</div>
						</div>
				</div>
				<div class="col-lg-8 col-sm-8">
					<form action="./setting.php" method="post">
						<div class="card ms-3">
							<div class="card-header">Change Password</div>
							<div class="card-body d-flex justify-content-between">
								<div>
									<label for="">Current Password</label>
									<input type="password" name="current_password" id="" required="">
									<small class="text-danger"><?php echo $current_pass_error ?></small>
								</div>
								<div><label for="">New Password</label>
									<input type="password" name="new_password" id="" required="">
									<small class="text-danger"><?php echo $new_pass_error ?></small>
								</div>
							</div>
							<div class="footer">
								<button type="submit" class="btn btn-primary" name="change_pass">Change Password</button>
							</div>
						</div>
					</form>

				</div>
			</div>
			
		</div>
	</div>
</div>
<?php require_once("./layout/footer.php") ?>