<?php
require_once("../storage/auth_user.php");
if (!$user) {
    header("Location: ./login.php");
    die();
} else {
    if (!$user['is_admin']) {
        header("Location: ../admin/layout/error.php");
        die();
    }
}
?>
<?php
require_once("../storage/product_db.php");
require_once("../storage/order_db.php");
require_once("../storage/payment_db.php");
require_once("../storage/user_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $payment = get_payment_by_id($mysqli, $order_id);
    $order = get_order_by_id($mysqli, $order_id);
    $user_id = $order['user_id'];
    $user = get_user_by_id($mysqli, $user_id);
}

if (isset($_POST['update'])) {

    $order_id = $_GET['order_id'];
    $payment_status = $_POST['payment_status'];
    $order_status = $_POST['order_status'];
    $order_update = update_order($mysqli, $payment_status, $order_status, $order_id);
    if($order_update){
        $_SESSION['status'] = "Update Success";
        $_SESSION['status_code'] = "success";
        header("location:./order_detail.php?order_id=$order_id");
        exit();
    }else{
        $_SESSION['status'] = "Update Fail";
        $_SESSION['status_code'] = "error";
        header("location:./order_detail.php?order_id=$order_id");
        exit();
    }
}
if (isset($_POST['confirm'])) {
    $order_id = $_GET['order_id'];
    $payment_status = 1;
    $order_status = 0;
    $order_update = update_order($mysqli, $payment_status, $order_status, $order_id);
    header("location:./order_detail.php?order_id=$order_id");
    exit();
}
if (isset($_POST['devivered'])) {
    $order_id = $_GET['order_id'];
    $payment_status = 1;
    $order_status = 1;
    $order_update = update_order($mysqli, $payment_status, $order_status, $order_id);
    header("location:./order_detail.php?order_id=$order_id");
    exit();
}
?>
<?php require_once("../admin/layout/navbar.php");  ?>
<?php require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Order Status</th>

                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="row"><?php echo $order['order_id'] ?></th>
                                <td><?php echo $user['name'] ?></td>
                                <td><?php echo $order['order_date'] ?></td>
                                <td><?php echo $order['total_amount'] ?></td>
                                <td><?php if ($order['payment_status'] == 0) : ?>
                                        <button class="btn btn-warning btn-sm">Pending</button>
                                    <?php else : ?>
                                        <button class="btn btn-success btn-sm">Completed</button>
                                    <?php endif ?>
                                </td>
                                <td><?php if ($order['order_status'] == 0) : ?>
                                        <button class="btn btn-warning btn-sm">Pending</button>
                                    <?php else : ?>
                                        <button class="btn btn-primary btn-sm">Delivered</button>
                                    <?php endif ?>
                                </td>

                            </tr>


                        </tbody>
                    </table>

                </div>
            </div>
            <div class="row d-flex">

                <div class="col-6 mt-5">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th class="text-danger"><?php echo $user['name'] ?></th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th class="text-danger"><?php echo $user['email'] ?></th>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td class="text-danger"><?php echo $user['phone'] ?></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td class="text-danger"><?php echo $user['address'] ?></td>
                                </tr>
                                <tr>
                                    <td>Payment Method:</td>
                                    <td class="text-danger">
                                        <?php
                                        if ($payment == null) {
                                            echo "Unpaid";
                                        } else {
                                            echo $payment['payment_method'];
                                        }
                                        ?></td>
                                </tr>
                                <tr>
                                    <td>ScreenShot</td>
                                    <td class="text-danger">
                                        <?php
                                            if($payment == null) :
                                                echo "Unpaid"; ?>
                                            <?php else : ?>
                                                <img style="width: 120px;height: 80px;" class="rounded" src="data:image/png;base64,<?php echo $payment['payment_img'] ?>" alt="">
                                            
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Payment Status</td>
                                    <td class=""><?php if ($order['payment_status'] == 0) : ?>
                                            <span class="text-warning ms-5">Pending</span>
                                        <?php else : ?>
                                            <span class="text-success ms-5">Confimed</span>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Order Status</td>
                                    <td class=""><?php if ($order['order_status'] == 0) : ?>
                                            <span class="text-warning ms-5">Deliverying</span>
                                        <?php else : ?>
                                            <span class="text-success ms-5">Delivered</span>
                                        <?php endif ?>
                                    </td>
                                </tr>

                        </table>
                        <form action="" method="post">
                            <div class="mt-1">
                                <?php if ($order['payment_status'] == 0) : ?>
                                    <button type="submit" class="btn btn-primary" name="confirm">Confirm</button>
                                <?php endif ?>
                                <?php if ($order['payment_status'] == 1 && $order['order_status'] == 0) : ?>
                                    <button type="submit" class="btn btn-primary" name="devivered">Delivered</button>
                                <?php endif ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6 mt-5">
                    <form action="" class="form-control" method="post">
                        <div class="mt-3">
                            <label for="">Payment Status</label>
                            <select class="form-select" aria-label="Default select example" name="payment_status">
                                <option value="1">Completed</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="">Order Status</label>
                            <select class="form-select" aria-label="Default select example" name="order_status">
                                <option value="1">Delivered</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>
                        <div class="mt-3 mb-3">
                            <button type="subit" class="btn btn-primary" name="update">Update</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>