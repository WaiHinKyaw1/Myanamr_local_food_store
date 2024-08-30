<?php
require_once("./storage/database.php");
require_once("./storage/auth_user.php");
require_once("./storage/user_db.php");
require_once("./user/layout/header.php");

if (!$user) {
    header("Location: ./auth/login.php");
}
$name_error = $email_error = $phone_error = $address_error = $name = $email = $address = $phone = $current_pass_error = $new_pass_error = "";
$success = $invalid = "";
$validation = true;
$user_id = $user['user_id'];

if (isset($_POST['edit_account'])) {
    

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
            header("Location: ./my_account.php");
            exit();
        } else {
            $_SESSION['status'] = "Update Fail";
            $_SESSION['status_code'] = "error";
            header("Location: ./my_account.php");
            exit();
        }
    }
}
if (isset($_POST['change_password'])) {
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
                $success = "Password Update Success";
                header("Location: ./my_account.php?success=$success");
            }
        } else {
            $invalid = "Password not same";
            header("Location: ./my_account.php?invalid=$invalid");
        }
    }
}

require_once("./user/layout/navbar.php");
?>

<section class="breadcrumb-section set-bg" data-setbg="./user/assets/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>My Account</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>My Account</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <?php $user = get_user_by_id($mysqli, $user_id); ?>
            <div class="card p-3 my-4 justify-content-center">
                <form action="" method="post">

                    <h3 class="text-black text-center  m-0 p-2 mb-3"><i class="fa-duotone fa-solid fa-user"></i> Account Details</h3>
                    <div class="checkout__input">
                        <p>Name<span>*</span></p>
                        <input type="text" name="name" value="<?= $user['name'] ?>">

                    </div>

                    <div class="checkout__input">
                        <p>Address<span>*</span></p>
                        <input type="text" name="address" placeholder="Street Address" class="checkout__input__add" value="<?php echo $user['address'] ?>">
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Phone<span>*</span></p>
                                <input type="text" name="phone" value="<?= $user['phone'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Email<span>*</span></p>
                                <input type="text" name="email" class="required" value="<?= $user['email'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="ms-2 p-2">
                        <button class="btn site-btn" type="submit" name="edit_account">Save Change</button>
                    </div>

                </form>
            </div>

        </div>
        <div class="col-lg-4  mb-4">

            <div class="card mt-4">
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
                <h3 class="text-black text-center  m-0 p-2 mb-3 mt-3"> <i class="fa-solid fa-gear"></i> Change Password</h3>
                <form action="" method="post">

                    <div class="col-lg-8">
                        <div class="checkout__input ms-3">
                            <p>Current Password</p>
                            <input type="password" name="current_password" placeholder="Current Password">
                            <small class="text-danger"><?php echo $current_pass_error ?></small>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="checkout__input ms-3">
                            <p>New Password<span>*</span></p>
                            <input type="password" name="new_password" class="required" placeholder="New Password">
                            <small class="text-danger"><?php echo $new_pass_error ?></small>
                        </div>
                    </div>
                    <div class="ms-4 p-2">
                        <button class="btn site-btn" name="change_password" type="submit">Save Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once("./user/layout/footer.php") ?>