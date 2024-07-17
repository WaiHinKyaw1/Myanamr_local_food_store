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
    $delete = delete_brand($mysqli, $delete_id);
    if ($delete) {
        $success = "Delete Success";
        header("Location:../admin/brand.php?success=$success");
    } else {
        $invalid = "Delete Unsuccess";
        header("Location: ../admin/brand.php?invalid=$invalid");
    }
}

if (isset($_GET['update_id'])) {
    $product_id = $_GET['update_id'];
    $update = get_brand_by_id($mysqli, $product_id);
    $product_name = $update['product_name'];
    if (isset($_POST['update'])) {
        $product_name = $_POST['product_name'];
        if ($brand_name == "") $brand_name_error = "brand Name is Blank";
        if ($brand_name_error == "") {
            $product = update_brand($mysqli, $brand_id, $brand_name);
            if ($brand) {
                $success = "Update is Success";
                header("Location: ../admin/brand.php?success=$success");
            } else {
                $invalid = "Update is Failed";
                header("Location: ../admin/brand.php?invalid=$invalid");
            }
        }
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
                                <!-- <th scope="col">Qty</th> -->
                                <th scope="col">Amount</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Status</th>
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
                                    <td>Payment_metod</td>
                                    <td>Paid</td> 
                                    <td>
                                        <a href="../admin/order.php?update_id=<?php echo $product['product_id'] ?>" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="../admin/order.php?delete_id=<?php echo $product['product_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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