<?php require_once("../storage/database.php") ?>
<?php require_once("../storage/user_db.php") ?>
<?php require_once("./layout/header.php") ?>
<?php
$name = $email = $phone = $address =$password = $confirm_password ="";
$success = $invalid = false;
$pass_error = "";
if (isset($_POST['register'])) {
    $name=htmlspecialchars($_POST['user_name']);
    $email=htmlspecialchars($_POST['email']);
    $phone=htmlspecialchars($_POST['phone']);
    $address=htmlspecialchars($_POST['address']);
    $password=htmlspecialchars($_POST['password']);
    $confirm_password=htmlspecialchars($_POST['confirm_password']);
    
    
        if(strlen($password)>=4 && strlen($confirm_password)>=4){
            if($password == $confirm_password){
               $password = password_hash($password,PASSWORD_DEFAULT);
               $save_user = save_user($mysqli, $name, $email, $phone, $address, $password);
                if($save_user){
                   $success = true;
                } else {
                    $invalid = true;
                }
            } else {
                 $pass_error = "Password not correct";
            }

        } else {
             $pass_error= "Password must be 4";
        }
    
    }
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
        <?php
            if ($success) echo '<div class="alert alert-primary"> Registeration Success!</div>';
            if ($invalid) echo '<div class="alert alert-danger">Invalid Registeration!</div>';
            ?>
            <form method="post">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-1">Registrations Form</h3>
                        <p>Please enter your user information.</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="user_name" required="" placeholder="Username" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="email" name="email" required="" placeholder="E-mail" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="int" name="phone" required="" placeholder="Phone" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="address" required="" placeholder="Address" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" id="pass1" type="password" name="password" required="" placeholder="Password">
                            <small class="text-danger"><?php echo $pass_error ?></small>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" required="" name="confirm_password" placeholder="Password Confirm">
                            <small class="text-danger"><?php echo $pass_error ?></small>
                        </div>
                        <div class="form-group pt-2">
                            <button class="btn btn-block btn-primary" type="submit" name="register">Register My Account</button>
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox"><span class="custom-control-label">By creating an account, you agree the <a href="#">terms and conditions</a></span>
                            </label>
                        </div>

                    </div>
                    <div class="card-footer bg-white">
                        <p>Already member? <a href="./login.php" class="text-secondary">Login Here.</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once("./layout/footer.php") ?>