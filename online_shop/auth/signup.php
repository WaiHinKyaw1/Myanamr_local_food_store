<?php 
require_once("../layout/header.php");
require_once("../stroage/db.php");
require_once("../stroage/customer_db.php");
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
    if ($user['is_admin']) {
        header("Location:../admin/index.php");
    } else {
        header("Location:../user/index.php");
    }
}

$c_name = $email = $address = $password = $con_password = "";
$c_name_err = $email_err = $address_err = $password_err = $con_password_err = "";
$validate = true;
$success = false;
$invalid = false;

if (isset($_POST['submit'])) {
    $c_name = htmlspecialchars($_POST["c_name"]);
    $email = htmlspecialchars($_POST["email"]);
    $address = htmlspecialchars($_POST["address"]);
    $password = htmlspecialchars($_POST["password"]);
    $con_password = htmlspecialchars($_POST["con_password"]);
    if ($c_name === "") {
        $validate = false;
        $c_name_err = "Name must not be blank!";
    }
    if ($email === "") {
        $validate = false;
        $email_err = "Email must not be blank!";
    }
    if ($address === "") {
        $validate = false;
        $address_err = "Address must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }
    if ($password !==  $con_password) {
        $validate = false;
        $con_password_err = "Confirm password must be match with password!";
    }

    if ($validate) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $status = save_customer($mysqli, $c_name, $email, $address, $password_hash);
        if ($status) {
            $success = true;
        } else {
            $invalid = true;
        }
    }
}

?>

<div class="container">
    <h1 class="text-center my-5">Registeration Form</h1>
    <div class="d-flex justify-content-center">
        <div class="card p-5 col-6">
            <?php
            if ($success) echo '<div class="alert alert-primary">User Registeration Done!</div>';
            if ($invalid) echo '<div class="alert alert-danger">Invalid Registeration!</div>';
            ?>


            <form method="post">
                <div class="form-group row my-4">
                    <div class="col-4">User Name</div>
                    <div class="col-8">
                        <input type="text" name="c_name" value="<?php echo $c_name ?>" placeholder="Enter name" class="form-control">
                        <small class="text-danger"><?php echo $c_name_err ?></small>
                    </div>
                </div>
                <div class="form-group row my-4">
                    <div class="col-4">User Email</div>
                    <div class="col-8">
                        <input type="text" name="email" value="<?php echo $email ?>" placeholder="Enter email" class="form-control">
                        <small class="text-danger"><?php echo $email_err ?></small>
                    </div>
                </div>
                <div class="form-group row my-4">
                    <div class="col-4">Address</div>
                    <div class="col-8">
                        <input type="text" name="address" value="<?php echo $address ?>" placeholder="Enter address" class="form-control">
                        <small class="text-danger"><?php echo $address_err ?></small>
                    </div>
                </div>
                <div class="form-group row my-4">
                    <div class="col-4">Password</div>
                    <div class="col-8">
                        <input type="password" name="password" value="<?php echo $password ?>" placeholder="Enter password" class="form-control">
                        <small class="text-danger"><?php echo $password_err ?></small>
                    </div>
                </div>
                <div class="form-group row my-4">
                    <div class="col-4">Confirm-assword</div>
                    <div class="col-8">
                        <input type="password" name="con_password" value="<?php echo $con_password ?>" placeholder="Enter password" class="form-control">
                        <small class="text-danger"><?php echo $con_password_err ?></small>
                    </div>
                </div>
                <div class="form-group row my-4 pt-4">
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>
                <p class="text-center">Already have an account? <a href="./login.php">Login</a></p>
            </form>
        </div>
    </div>
</div>


<?php require_once("../layout/footer.php") ?>