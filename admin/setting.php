<?php require_once("./layout/header.php") ?>
<?php require_once("../storage/user_db.php") ?>
<?php require_once("../storage/database.php") ?>
<?php require_once("./layout/navbar.php") ?>
<?php require_once("./layout/sidebar.php") ?>
<?php 
$name_error = $email_error = $phone_error = $address_error = $name = $email = $address = $phone= "";
$success = $invalid = "";
$user_id = $user['user_id'];

if(isset($_POST['update'])){

	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];

if($name === "") $name_error = "Name is blank";
if($email === "") $email_error = "email is blank";
if($phone === "") $phone_error = "phone is blank";
if($address === "") $address_error = "address is blank";

$user_update = update_user($mysqli,$user_id,$name,$email,$phone,$address);
if($user_update){
	$success = "Update is Success";
}
	$invalid = "Update is invalid";
}



?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
        <div class="row">
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
						<?php if ($success) : ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong><?php echo $success ?>!</strong> .
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif ?>
                    <?php if ($invalid) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?php echo $invalid ?>!</strong> .
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif ?>
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
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
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
									<input type="text" class="form-control" name="email" value="<?php echo $user['email'] ?>" >
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
							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-9 text-secondary">
									<button type="submit" class="btn btn-primary" name="update">Save Change</button>
								</div>
							</div>
						</div>
					</div>
					</form>
					<!-- <div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<h5 class="d-flex align-items-center mb-3">Project Status</h5>
									<p>Web Design</p>
									<div class="progress mb-3" style="height: 5px">
										<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									<p>Website Markup</p>
									<div class="progress mb-3" style="height: 5px">
										<div class="progress-bar bg-danger" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									<p>One Page</p>
									<div class="progress mb-3" style="height: 5px">
										<div class="progress-bar bg-success" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									<p>Mobile Template</p>
									<div class="progress mb-3" style="height: 5px">
										<div class="progress-bar bg-warning" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									<p>Backend API</p>
									<div class="progress" style="height: 5px">
										<div class="progress-bar bg-info" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
				</div>
			</div>
        </div>
    </div>
</div>
<?php require_once("./layout/footer.php") ?>