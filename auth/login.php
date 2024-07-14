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
        
        if($password_check){
            $success = true;
            setcookie("user",json_encode($user),time() + 3600 * 24 * 7, '/');
            if($user['is_admin']){
                header("Location: ../admin/index.php");
            } else {
                header("Location: ../user/index.php");
            }
        } else {
            $invalid = true;
        }
    }

}
?>
<?php require_once("./layout/header.php") ?>

<body>
    <!-- login page  -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="../index.html"><img class="logo-img" src="../assets/images/logo.png" alt="logo"></a><span class="splash-description">Please enter your user information.</span></div>
            <div class="card-body">
            <?php
            if ($success) echo '<div class="alert alert-primary">Login Successful!</div>';
            if ($invalid) echo '<div class="alert alert-danger">Invalid Password
            </div>';
            ?>
                <form method="post">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="email" id="username" type="email" placeholder="Email" required="" autocomplete="off">
                        <small class="text-danger"><?php echo $email_error ?></small>
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" id="password" name="password" type="password" placeholder="Password">
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