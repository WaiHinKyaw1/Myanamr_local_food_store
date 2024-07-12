<?php

use function PHPSTORM_META\elementType;

require_once("../stroage/auth_user.php");
require_once("../layout/header.php");
require_once("../stroage/item_list.php");
$message = false;
if ($user['is_admin']) {
    header("Location:../layout/error.php");
}
if (isset($_GET['dec'])) {
    $index = $_GET['dec'];
    $current = --$item_list[$index]['qty'];
    if ($current > 0) {
        $item_list[$index]['amount'] =
            $item_list[$index]['qty'] * $item_list[$index]['price'];
    } else {
        unset($item_list[$index]);
    }
    $item_list = array_values($item_list);
    $_SESSION['item_list'] = $item_list;
    header("Location:../user/order.php");
}

if (isset($_GET['inc'])) {
    $index = $_GET['inc'];
    $item = get_item_by_id($mysqli, $item_list[$index]['i_id']);
    if ($item['qty'] > $item_list[$index]['qty']) {
        $item_list[$index]['qty']++;
        $item_list[$index]['amount'] =
            $item_list[$index]['qty'] * $item_list[$index]['price'];
        $_SESSION['item_list'] = $item_list;
        header("Location:../user/order.php");
    } else {
        $message = true;
    }
}

if (isset($_POST['order'])) {
    $orders = get_all_order($mysqli);
    $all_orders = $orders->fetch_all();
    // $lest_item = get_last_order($mysqli);
    $lest_item = get_last_order_by_subquery($mysqli);
    $o_name = $lest_item['o_name'] + 1;
    foreach ($item_list as $item) {
        $update_item = get_item_by_id($mysqli, $item['i_id']);
        $update_item['qty'] = $update_item['qty'] - $item['qty'];
        update_item(
            $mysqli,
            $update_item['i_id'],
            $update_item['i_name'],
            $update_item['price'],
            $update_item['qty'],
            $update_item['b_id'],
            $update_item['description']
        );
        if (count($all_orders) === 0) {
            $status =  save_order($mysqli, "1", $item['amount'], $item['qty'], $item['i_id'], $item['c_id']);
        } else {
            // $o_name = $all_orders[count($all_orders)-1][1]+1;

            $status =  save_order($mysqli, "$o_name", $item['amount'], $item['qty'], $item['i_id'], $item['c_id']);
        }
    }
    session_destroy();
    header("Location:../user/order.php");
}

?>
<div class="root row">
    <div class="sidebar col-2">
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../user/index.php">All</a>
        <?php
        $brands = get_all_brand($mysqli);
        while ($brand = $brands->fetch_assoc()) {
        ?>
            <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../user/index.php?b_id=<?php echo $brand['brand_id'] ?>"><?php echo $brand['brand_name'] ?></a>

        <?php
        }
        ?>
    </div>
    <div class="content col-10 p-5">
        <?php if ($message) { ?>
            <div class="alert alert-danger">This item is not enought to add more!</div>
        <?php } ?>
        <div class="card p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Item Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < count($item_list); $i++) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <td><?php echo $item_list[$i]['i_name'] ?></td>
                            <td><?php echo $item_list[$i]['price'] ?> MMK</td>
                            <td><?php echo $item_list[$i]['qty'] ?></td>
                            <td><?php echo $item_list[$i]['amount'] ?> MMK</td>
                            <td><img style="width: 50px;height: 50px;" class="rounded" 
                                src="<?php if( $item_list[$i]['img']) {
                                echo  $item_list[$i]['img']; } else{
                                    echo "../upload/noimg.png";
                                }
                                 ?>"></td>
                            <td>
                                <a href="../user/order.php?dec=<?php echo $i ?>" class="btn btn-danger"> - </a>
                                <a href="../user/order.php?inc=<?php echo $i ?>" class="btn btn-primary">+</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="4"></td>
                        <?php
                        $total_amount = 0;
                        foreach ($item_list as $item) {
                            $total_amount = $total_amount + $item['amount'];
                        }
                        ?>
                        <td><?php echo $total_amount ?> MMK</td>
                        <td></td>
                        <td>
                            <form method="post">
                                <button type="submit" name="order" class="btn btn-primary">Order</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>


<?php require_once("../layout/footer.php") ?>