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
require_once("../storage/user_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$success = $invalid = "";

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_order($mysqli, $delete_id);
    if ($delete) {
        $success = "Delete Success";
        header("Location:../admin/order.php?success=$success");
    } else {
        $invalid = "Delete Unsuccess";
        header("Location: ../admin/order.php?invalid=$invalid");
    }
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
                                <th scope="col">Payment status</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $orders = get_all_order($mysqli);
                            foreach ($orders as $order) :
                                $user_id = $order['user_id'];
                                $user = get_user_by_id($mysqli,$user_id);
                                

                            ?>

                                <tr>
                                    <th scope="row"><?php echo $order['order_id'] ?></th>
                                    <td><?php echo $user['name'] ?></td>
                                    <td><?php echo $order['order_date'] ?></td>
                                    <td><?php echo $order['total_amount'] ?></td>
                                    <td><?php if($order['payment_status'] == 0) : ?>
                                    <button class="btn btn-primary btn-sm rounded">Cash on Delivery</button>
                                    <?php else : ?>
                                    <button class="btn btn-success btn-sm rounded">Completed</button>
                                    <?php endif ?>
                                    </td>
                                    <td><?php if($order['order_status'] == 0) : ?>
                                    <button class="btn btn-warning btn-sm rounded">Pending</button>
                                    <?php else : ?>
                                    <button class="btn btn-success btn-sm rounded">Delivered</button>
                                    <?php endif ?>
                                    </td>  
                                    <td>
                                    <a href="../admin/order_detail.php?order_id=<?php echo $order['order_id'] ?>" class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                                    <a href="../admin/order.php?delete_id=<?php echo $order['order_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>