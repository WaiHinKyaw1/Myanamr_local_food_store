<?php

require_once("../stroage/auth_user.php");
require_once("../layout/header.php");
if (!$user) {
    header("Location:../auth/login.php");
} else {
    if (!$user['is_admin']) {
        header("Location:../layout/error.php");
    }
}



$b_name = $b_name_err = $success = $invalid = '';

if (isset($_GET["success"])) $success = $_GET["success"];
if (isset($_GET["invalid"])) $invalid = $_GET["invalid"];

if (isset($_POST['submit'])) {
    $b_name = $_POST['b_name'];
    if ($b_name === '') $b_name_err = "Brand can not be blank!";
    if ($b_name_err === '') {
        $status = save_brand($mysqli, $b_name);
        if ($status) {
            $success = "New brand is saved!";
            $b_name = "";
        } else {
            $invalid = "Brand can't save!";
        }
    }
}

if (isset($_GET["delete_id"])) {
    $brand_id = $_GET["delete_id"];
    $status = delete_brand($mysqli, $brand_id);
    if ($status) {
        $success = "This brand is deleted!";
        header("Location:../admin/index.php?success=$success");
    } else {
        $invalid = "This brand can't delete!";
        header("Location:../admin/index.php?invalid=$invalid");
    }
}

if (isset($_GET["update_id"])) {
    $brand_id = $_GET["update_id"];
    $brand = get_brand_by_id($mysqli, $brand_id);
    $b_name = $brand['brand_name'];
    if (isset($_POST["update"])) {
        $b_name = $_POST['b_name'];
        if ($b_name === '') $b_name_err = "Brand can not be blank!";
        if ($b_name_err === '') {
            $status = update_brand($mysqli,$brand_id, $b_name);
            if ($status) {
                $success = "Brand is Updated!";
                header("Location:../admin/index.php?success=$success");
            } else {
                $invalid = "Brand can't update!";
                header("Location:../admin/index.php?invalid=$invalid");
            }
        }
    }
}


?>

<div class="root row">
    <div class="sidebar col-2">
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/index.php">Brand</a>
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/item.php">Item</a>
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/order.php">Order</a>
    </div>
    <div class="content col-10 p-5 row">
    <div class="col p-5">
            <div class="card p-5">
                <?php if ($success !== "") { ?>
                    <div class="alert alert-success"><?php echo $success ?></div>
                <?php } ?>
                <?php if ($invalid !== "") { ?>
                    <div class="alert alert-danger"><?php echo $invalid ?></div>
                <?php } ?>
                <form method="post">
                    <div class="form-group my-3">
                        <label>Brand Name</label>
                        <input name="b_name" type="text" value="<?php echo $b_name ?>" class="form-control">
                        <small class="text-danger"><?php echo $b_name_err ?></small>
                    </div>
                    <?php if (isset($_GET['update_id'])) { ?>

                        <button name="update" class="btn btn-primary my-3">Update</button>
                    <?php } else { ?>
                        <button name="submit" class="btn btn-primary my-3">Submit</button>
                    <?php } ?>
                </form>
            </div>
        </div>
        <div class="col p-5">

            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Brand Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $brands = get_all_brand($mysqli);
                    $i = 1;
                    while ($brand = $brands->fetch_assoc()) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $i ?></th>
                            <td><?php echo $brand['brand_name'] ?></td>
                            <td>
                                <a href="../admin/index.php?update_id=<?php echo $brand['brand_id'] ?>" class="btn btn-secondary">Edit</a>
                                <a href="../admin/index.php?delete_id=<?php echo $brand['brand_id'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require_once("../layout/footer.php") ?>




