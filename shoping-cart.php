
<?php require_once("./storage/database.php") ?>
<?php require_once("./storage/auth_user.php") ?>
<?php require_once("./storage/user_db.php") ?>
<?php require_once("./storage/order_db.php") ?>
<?php require_once("./storage/product_db.php") ?>
<?php require_once("./storage/order_item_db.php") ?>

<?php

if (isset($_GET['del_id'])) {
    $index = $_GET['del_id'];
    unset($product_list[$index]);
    $product_list = array_values($product_list);
    $_SESSION['product_list'] = $product_list;
    header("Location:./shoping-cart.php");
}

if (isset($_GET['dec'])) {
    $index = $_GET['dec'];
    $current = --$product_list[$index]['qty'];
    if ($current >= 1) {
        $product_list[$index]['amount'] =
            $product_list[$index]['qty'] * $product_list[$index]['price'];
    } else {
        unset($product_list[$index]);
    }
    $product_list = array_values($product_list);
    $_SESSION['product_list'] = $product_list;
    header("Location: ./shoping-cart.php");
}

if (isset($_GET['inc'])) {
    $index = $_GET['inc'];
    $item = get_product_by_id($mysqli, $product_list[$index]['product_id']);
    if ($item['qty'] > $product_list[$index]['qty']) {
        $product_list[$index]['qty']++;
        $product_list[$index]['amount'] =
            $product_list[$index]['qty'] * $product_list[$index]['price'];
        $_SESSION['product_list'] = $product_list;
        header("Location: ./shoping-cart.php");
    }
}
if (isset($_POST['order'])) {
    $user_id = $user['user_id'];
    $order_date = date('Y-m-d');
    $total_amount = $_POST['amount'];
    $order = save_order($mysqli, $user_id, $order_date, $total_amount);
    if ($order) {
        $lest_order = get_last_order($mysqli);
        $order_id = $lest_order['order_id'];
        foreach ($product_list as $product_item) {
            $order_id = $order_id;
            $product_id = $product_item['product_id'];
            $qty = $product_item['qty'];
            $amount = $product_item['amount'];
            $order_item = save_order_item($mysqli, $order_id, $product_id, $qty, $amount);
        }
        session_destroy();
        header("Location: ./checkout.php");
    }
}
?>

<?php require_once("./user/layout/header.php") ?>
<?php require_once("./user/layout/navbar.php") ?>

<?php
if (isset($_GET['product_id'])) {
    $is_new = true;
    $product = get_product_by_id($mysqli, $_GET['product_id']);
    for ($i = 0; $i < count($product_list); $i++) {
        if ($_GET['product_id'] == $product_list[$i]['product_id']) {
            $is_new = false;
            if ($product['qty'] > $product_list[$i]['qty']) {
                $product_list[$i]['qty']++;
                $product_list[$i]['amount'] = $product_list[$i]['qty'] * $product_list[$i]['price'];
            }
        }
    }
    if ($is_new) {
        if ($product['discount'] != null) {
            $price = $product['price'] - $product['discount'];
        } else {
            $price = $product['price'];
        }
        array_push($product_list, [
            'product_id' => $product['product_id'],
            'user_id' => $user['user_id'],
            'price' => $price,
            'product_name' => $product['product_name'],
            'qty' => 1,
            'image' => $product['image'],
            'amount' => $price,
        ]);
    }
    $_SESSION['product_list'] = $product_list;
}

?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="./user/assets/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if($_SESSION['product_list']) :?>
                    <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < count($product_list); $i++) :
                            ?>
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="data:png/image;base64,<?php echo $product_list[$i]['image'] ?>" style="width: 50px; height:50px;" alt="">
                                        <h5><?php echo $product_list[$i]['product_name'] ?></h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                         <?php echo $product_list[$i]['price'] ?>Kyats
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity ">
                                            <div class="bg-success w-50 ms-5">
                                                <a href="./shoping-cart.php?dec=<?php echo $i ?>" class="btn"> <i class="fa-solid fa-minus"></i> </a>
                                                <?php echo $product_list[$i]['qty'] ?>
                                                <a href="./shoping-cart.php?inc=<?php echo $i ?>" class="btn"><i class="fa-solid fa-plus"></i></a>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        <?php echo $product_list[$i]['amount'] ?>Kyats
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a href="?del_id=<?php echo $i ?>"><button type="submit" class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button></a>
                                    </td>
                                </tr>
                            <?php endfor ?>

                        </tbody>
                    </table>
                </div>
                
                <?php else :?>
                    <div class="row">
                        <div class="col-12">
                            <img src="./image/images.png" style="width: 200px; height:200px;display: block;margin-left: auto;margin-right: auto;" alt="">
                            <div class="d-grid justify-content-center my-2">
                                <a href="./index.php"><button class="btn btn-dark text-light p-2">RETURN TO SHOP</button></a>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-6 mt-5">
                <div class="shoping__cart__btns">
                    <a href="./shop-grid.php" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    
                </div>
            </div>
            <!-- <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div> -->
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <?php
                        $total_amount = 0;
                        foreach ($product_list as $product)
                            $total_amount = $total_amount + $product['amount'];
                        ?>

                        <li>Total <span>$<?php echo $total_amount ?></span></li>
                    </ul>

                    <form action="" method="post">
                        <input type="hidden" name="amount" value="<?php echo $total_amount ?>" id="">
                        <a href="./checkout.php"><button type="submit" class="primary-btn w-100" name="order">PROCEED TO CHECKOUT</button></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->


<?php require_once("./user/layout/footer.php") ?>