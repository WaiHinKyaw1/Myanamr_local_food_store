<?php session_start(); ?>
<?php require_once("../storage/database.php") ?>
<?php require_once("../storage/user_db.php") ?>
<?php require_once("./layout/header.php") ?>
<?php
$name = $email = $phone = $address =$password = $confirm_password ="";
$status = $status_code = "";
$pass_error = $phone_error = "";
$validate = true;
if (isset($_POST['register'])) {
    $name=htmlspecialchars($_POST['user_name']);
    $email=htmlspecialchars($_POST['email']);
    $phone=htmlspecialchars($_POST['phone']);
    $address=htmlspecialchars($_POST['address']);
    $password=htmlspecialchars($_POST['password']);
    $confirm_password=htmlspecialchars($_POST['confirm_password']);
    if(strlen($phone) != 11){
        $validate = false;
        $phone_error = "Phone Number Must Be 11";
    }
    if($validate){

        if(strlen($password)>=4 && strlen($confirm_password)>=4){
            if($password == $confirm_password){
               $password = password_hash($password,PASSWORD_DEFAULT);
               $save_user = save_user($mysqli, $name, $email, $phone, $address, $password);
                if($save_user){
                    $_SESSION['status'] = "success";
                    $_SESSION['status_code'] = "success";
                    header("Location: ./login.php");
                    exit();
                } else {
                    $_SESSION['status'] = "Invalid Registertion";
                    $_SESSION['status_code'] = "error";
                    header("Location: ./register.php");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Password Not Correct";
                $_SESSION['status_code'] = "warning";
                header("Location: ./register.php");
                exit();
            }
    
        } else {
             $pass_error= "Password must be 4";
        }
    
    }
    }
    
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
                    
            <form method="post">
                <div class="card rounded">
                    <div class="card-header text-center text-info">
                        <h3 class="mb-2 mt-2 text-danger">Registrations Form</h3>
                        <p>Please Enter Your User Information</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="user_name" required="" placeholder="Username" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="email" name="email" required="" placeholder="E-mail" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="phone" required="" placeholder="Phone" autocomplete="off">
                            <small class="text-danger"><?php echo $phone_error ?></small>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="address" required="" placeholder="Address" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" id="pass1" type="password" name="password" required="" placeholder="Password">
                            <small class="text-danger"><?php echo $pass_error ?></small>
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" required="" type="password" name="confirm_password" placeholder="Password Confirm">
                            <small class="text-danger"><?php echo $pass_error ?></small>
                        </div>
                        <div class="form-group pt-2">
                            <button class="btn btn-block btn-primary" type="submit" name="register">Register My Account</button>
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