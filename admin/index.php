<?php require_once("../storage/auth_user.php"); ?>
<?php require_once("../storage/database.php");
require_once("../storage/product_db.php");
require_once("../storage/order_item_db.php");
require_once("../storage/order_db.php");
require_once("../storage/user_db.php");
require_once("../storage/brand_db.php");

?>
<?php
if (!$user['is_admin']) {
    header("Location: ../admin/layout/error.php");
    die();
}

?>
<?php require_once("./layout/header.php"); ?>
<?php require_once("./layout/navbar.php");  ?>
<?php require_once("./layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- pageheader  -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Myanmar Local Food Store</h2>

                    </div>
                </div>
            </div>
            <!-- end pageheader  -->
            <div class="ecommerce-widget">

                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Total Product</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                        <i class="fa-brands fa-product-hunt"></i>
                                        <?php
                                        $product = get_all_product($mysqli);
                                        echo count($product->fetch_all());
                                        ?>
                                    </h1>
                                </div>

                            </div>
                            <div id="sparkline-revenue"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Discount Product</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                        <i class="fa-brands fa-product-hunt"></i>
                                        <?php
                                        $discount_product = get_product_discount($mysqli);
                                        echo count($discount_product->fetch_all());
                                        ?>
                                    </h1>
                                </div>

                            </div>
                            <div id="sparkline-revenue2"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Best Seller Product</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                        <i class="fa-brands fa-product-hunt"></i>
                                        <?php
                                        $best_seller = get_product_best_seller($mysqli);
                                        echo count($best_seller->fetch_all());
                                        ?>
                                    </h1>
                                </div>

                            </div>
                            <div id="sparkline-revenue3"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-muted">Total User</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                    <i class="fa-solid fa-user"></i>
                                        <?php
                                        $user = get_all_user($mysqli);

                                        echo count($user->fetch_all());
                                        ?> 
                                    </h1>
                                </div>

                            </div>
                            <div id="sparkline-revenue4"></div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted"> Total Sales</h5>
                                <div class="d-flex justify-content-between mb-3">

                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">
                                            <i class="fa-solid fa-money-check-dollar"></i>
                                            
                                        </h1>
    
                                    </div>  
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Income Per Day
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php
                                            $total_price = get_total_price_order_per_day($mysqli);
                                            foreach ($total_price as $price):
    
                                            ?>
                                                <li value="<?php echo ($price['DATE(`order_date`)'] == $default_day) ? 'selected' : ''; ?>."><a class="dropdown-item" href="./index.php?price=<?= $price['SUM(total_amount)'] ?>"><?= $price['DATE(`order_date`)'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                                    <h1><?php if(isset($_GET['price'])){
                                                echo $_GET['price'] .  " Kyats";

                                            } ?>
                                    </h1>
                            </div>
                        </div>
                    </div>

                    <!-- end sales  -->

                    <!-- new customer  -->

                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted"> Total Sales</h5>
                                <div class="d-flex justify-content-between mb-3">

                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">
                                            <i class="fa-solid fa-money-check-dollar"></i>
                                            
                                        </h1>
    
                                    </div>  
                                    
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Income Per Month
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php
                                            $total_price = get_total_price_order_per_month($mysqli);
                                            foreach ($total_price as $price):
                                            ?>
                                                <li class="active"><a class="dropdown-item" href="./index.php?month=<?= $price['SUM(total_amount)'] ?>"><?= $price['MONTHNAME(`order_date`)'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                </div>
                                    <h1><?php if(isset($_GET['month'])){
                                                echo $_GET['month'] .  " Kyats";

                                            } ?>
                                    </h1>
                            </div>
                        </div>
                    </div>

                    <!-- end new customer  -->

                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted">Total Brand</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1"><i class="fa-brands fa-font-awesome"></i>
                                        <?php
                                        $brand = get_all_brand($mysqli);
                                        echo count($brand->fetch_all());
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- end visitor  -->

                    <!-- total orders  -->

                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <h5 class="text-muted">Total Orders</h5>
                                <div class="metric-value d-inline-block">
                                    <h1 class="mb-1">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <?php
                                        $order = get_all_order($mysqli);
                                        echo count($order->fetch_all());
                                        ?>

                                    </h1>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- end total orders  -->

                </div>
                <div class="row">
                    <!-- recent orders  -->

                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Recent Orders</h5>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-light">
                                            <tr class="border-0">

                                                <th class="border-0">Product Name</th>
                                                <th class="border-0">Order Date</th>
                                                <th class="border-0">Quantity</th>
                                                <th class="border-0">Price</th>
                                                <th class="border-0">Customer</th>
                                                <th class="border-0"> Order Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">

                                            <?php
                                            $orders = get_order_with_limit($mysqli);

                                            foreach ($orders as $order) :

                                                $order_id = $order['order_id'];
                                                $order_items = get_all_order_item_by_order_id($mysqli, $order_id);
                                                foreach ($order_items as $order_item) :
                                                    $product_id = $order_item['product_id'];
                                                    $product = get_product_by_id($mysqli, $product_id);
                                                    $user_id = $order['user_id'];
                                                    $user = get_user_by_id($mysqli, $user_id);
                                            ?>
                                                    <tr>

                                                        <td><?php echo $product['product_name'] ?> </td>
                                                        <td><?php echo $order['order_date'] ?> </td>
                                                        <td><?php echo $order_item['qty'] ?> </td>
                                                        <td><?php echo $order_item['qty'] * $product['price'] ?> Kyats </td>
                                                        <td><?php echo $user['name'] ?> </td>
                                                        <td><?php if ($order['order_status'] == 0) : ?>
                                                                <span class="badge-dot badge-warning mr-1"></span>Pending
                                                            <?php else : ?>
                                                                <span class="badge-dot badge-success mr-1"></span>Delivered
                                                            <?php endif ?>
                                                        </td>

                                                        <td></td>

                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endforeach ?>

                                            <td colspan="9"><a href="./order.php" class="btn btn-outline-light float-right">View Details</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- footer -->

    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    Copyright © 2024 Myanmar Local Food. Dashboard by <a href="http://localhost/myanmar_local_food_store/admin/index.php">Myanmar Local Food</a>.
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="text-md-right footer-links d-none d-sm-block">
                        <a href="javascript: void(0);">About</a>
                        <a href="javascript: void(0);">Support</a>
                        <a href="javascript: void(0);">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end footer -->
</div>

<?php require_once("./Layout/footer.php") ?>