<?php require_once("../storage/database.php") ?>
<?php require_once("../storage/user_db.php")  ?>

<?php  
$email = $password = $email_error = $password_error = "";
$success = $invalid = false;
$validate = true;
if(isset($_POST['submit'])){
    $email=htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    
    if ($email === "" ) {
        $validate = false;
        $email_error = "Email must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_error = "Password must not be blank!";
    }
    if($validate){
        $user = get_user_by_email($mysqli,$email);
        $password_check = password_verify($password,$user['password']);
        if($user['email'] == $_POST['email']){
            if($password_check){
                $success = "Login Success";
                setcookie("user",json_encode($user),time() + 3600 * 24 * 7, '/');
                if($user['is_admin']){
                    header("Location: ../admin/index.php");
                } else {
                    header("Location: ../index.php");
                }
            } else {
                $invalid = "Invalid Password!. Please Check Your Password";
            }
        }else{
            $invalid = "Your Email Don't Found";
        }
        
    }

}
?>
<?php require_once("./layout/header.php") ?>

    <!-- login page  -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><img class="logo-img rounded" src="../image/zen_mark.jpg" style="width:85%;height:50px;"  alt="logo"><span class="splash-description mt-3">Please enter your user information.</span></div>
            <div class="card-body">
                    <?php if ($success) : ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong><?php echo $success ?>!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <?php if ($invalid) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?php echo $invalid ?>!</strong> 
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                <form method="post">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="email" id="username" type="email" placeholder="Email" required=""  autocomplete="off">
                        <small class="text-danger"><?php echo $email_error ?></small>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="password" name="password" type="password" required="" placeholder="Password">
                        <small class="text-danger"><?php echo $password_error ?></small>
                    </div>
                    
                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="./register.php" class="footer-link">Create An Account</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
<?php require_once("./layout/footer.php") ?>