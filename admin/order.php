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
        $_SESSION['status'] = "Delete Success";
        $_SESSION['status_code'] = "success";
        header("Location:../admin/order.php");
        exit();
    } else {
        $_SESSION['status'] = "Delete Fail";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/order.php");
        exit();
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
                                <th scope="col">Deliver Info</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $result_per_page = 8;
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $start_from = ($page - 1) * $result_per_page;

                            $orders = get_all_limit_order($mysqli, $start_from, $result_per_page);
                            if (isset($_GET['search'])) {
                                $name = isset($_GET['search']) ? $_GET['search'] : null;
                                $products = get_product_by_filter($mysqli, $name);
                            }
                                $i=1;
                            foreach ($orders as $order) :
                                $user_id = $order['user_id'];
                                $user = get_user_by_id($mysqli,$user_id);                               
                            ?>

                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?php echo $user['name'] ?></td>
                                    <td><?php echo $order['order_date'] ?></td>
                                    <td><?php echo $order['total_amount'] ?></td>
                                    <td><?php if($order['payment_status'] == 0) : ?>
                                    <button class="btn btn-primary btn-sm rounded">Unpaid</button>
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
                                    <td><a href="../admin/deliver.php?order_id=<?= $order['order_id'] ?>&user_id=<?= $user['user_id'] ?>" class="btn btn-sm btn-info"><i class="fa-solid fa-truck"></i></a>                                        
                                    </td> 
                                    <td>
                                    <a href="../admin/order_detail.php?order_id=<?php echo $order['order_id'] ?>" class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                                    <a href="../admin/order.php?delete_id=<?php echo $order['order_id'] ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                            $i++;
                             endforeach ?>    
                        </tbody>
                    </table>
                    <div class="pagination">
                    <?php
                    $total_records = get_all_order($mysqli)->num_rows;

                    echo "</br>";
                    $total_pages = ceil($total_records / $result_per_page);
                    $pagLink = "";

                    if ($page >= 2) {
                        echo "<a href='order.php?page=" . ($page - 1) . "'>  Prev </a>";
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $pagLink .= "<a class = 'active' href='order.php?page="
                                . $i . "'>" . $i . " </a>";
                        } else {
                            $pagLink .= "<a href='order.php?page=" . $i . "'>   
                                                " . $i . " </a>";
                        }
                    };
                    echo $pagLink;

                    if ($page < $total_pages) {
                        echo "<a href='order.php?page=" . ($page + 1) . "'>  Next </a>";
                    }

                    ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>