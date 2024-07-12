<?php
require_once("../layout/header.php");
require_once("../stroage/customer_db.php");
require_once("../stroage/db.php");
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
    if ($user['is_admin']) {
        header("Location:../admin/index.php");
    } else {
        header("Location:../user/index.php");
    }
}

$email = $password = "";
$email_err = $password_err = "";
$validate = true;
$success = false;
$invalid = false;

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    if ($email === "") {
        $validate = false;
        $email_err = "Email must not be blank!";
    }
    if ($password === "") {
        $validate = false;
        $password_err = "Password must not be blank!";
    }

    if ($validate) {
        $customer = get_customer_by_email($mysqli, $email);
        $match = password_verify($password, $customer['password']);
        if ($match) {
            $success = true;
            setcookie("user", json_encode($customer), time() + 3600 * 24 * 7, '/');
            if ($customer['is_admin']) {
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

<div class="container">
    <h1 class="text-center my-5">Login Form</h1>
    <div class="d-flex justify-content-center">
        <div class="card p-5 col-6">
            <?php
            if ($success) echo '<div class="alert alert-primary">Login Successful!</div>';
            if ($invalid) echo '<div class="alert alert-danger">Invalid Credentials!</div>';
            ?>
            <form method="post">
                <div class="form-group row my-4">
                    <div class="col-4">User Email</div>
                    <div class="col-8">
                        <input type="email" name="email" value="<?php echo $email ?>" placeholder="Enter email" class="form-control">
                        <small class="text-danger"><?php echo $email_err ?></small>
                    </div>
                </div>
                <div class="form-group row my-4">
                    <div class="col-4">Password</div>
                    <div class="col-8">
                        <input type="password" name="password" value="<?php echo $password ?>" placeholder="Enter password" class="form-control">
                        <small class="text-danger"><?php echo $password_err ?></small>
                    </div>
                </div>
                <div class="form-group row my-4 pt-4">
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
                <p class="text-center">Don't have an account? <a href="./signup.php">Register</a></p>
            </form>
        </div>
    </div>
</div>

<?php require_once("../layout/footer.php") ?>