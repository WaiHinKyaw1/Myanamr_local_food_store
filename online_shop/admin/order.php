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
?>

<div class="root row">
    <div class="sidebar col-2">
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/index.php">Brand</a>
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/item.php">Item</a>
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/order.php">Order</a>
    </div>
    <div class="content col-10 p-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Invoid ID</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $orders = get_all_order($mysqli);
                $i = 1;
                while ($order = $orders->fetch_assoc()) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $i ?></th>
                        <td>INVNO<?php echo $order['o_name'] ?></td>
                        <td><?php echo $order['i_name'] ?></td>
                        <td><?php echo $order['c_name'] ?></td>
                        <td><?php echo $order['qty'] ?></td>
                        <td><?php echo $order['amount'] ?></td>
                    </tr>
                <?php
            $i++;
            } ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once("../layout/footer.php") ?>