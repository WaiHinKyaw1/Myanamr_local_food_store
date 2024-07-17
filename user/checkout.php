<?php require_once("../storage/auth_user.php") ?>
<?php require_once("../storage/order_db.php") ?>
<?php require_once("../storage/product_db.php") ?>
<?php require_once("../storage/database.php") ?>
<?php require_once("../storage/order_item_db.php") ?>
<?php require_once("./layout/header.php") ?>
<?php require_once("./layout/navbar.php") ?>
<?php
require_once("../storage/auth_user.php");
if (!$user) {
    header("Location: ../auth/login.php");
    die();
} elseif ($user['is_admin']) {
    header("Location: ./layout/error.php");
}
?>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="./assets/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.php">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">

        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="#">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <h6 class="text-muted text-center  m-0 p-2">Express Checkout</h6>
                            <div class="col-lg-4 my-3 ">
                                <div class="">
                                    <a href=""><img src="./image/kpyay.png" style="width:100%;height:60px;" class="rounded" alt=""> </a>
                                </div>
                            </div>
                            <div class="col-lg-4 my-3">
                                <div class="">
                                    <a href=""><img src="./image/wave.png" style="width:100%;height:60px;" class="rounded" alt=""> </a>
                                </div>
                            </div>
                            <div class="col-lg-4 my-3">
                                <div class="">
                                    <a href=""><img src="./image/mytel.jpg" style="width:100%;height:60px;" class="rounded" alt=""> </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h6 class="text-muted text-center  m-0 p-2 mb-3">Delivery</h6>
                            <div class="checkout__input">
                                <p>Name<span>*</span></p>
                                <input type="text">

                            </div>
                            <div class="checkout__input">
                                <p>Country<span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input type="text" placeholder="Street Address" class="checkout__input__add">
                            </div>
                            <div class="checkout__input">
                                <p>Town/City<span>*</span></p>
                                <input type="text">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__input">
                                <p>Order notes<span>*</span></p>
                                <input type="text" placeholder="Notes about your order, e.g. special notes for delivery.">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <?php
                            $last_order = get_last_order($mysqli);
                            $last_order_id = $last_order['order_id'];

                            $order_item = get_all_order_item_by_order_id($mysqli, $last_order_id);

                            foreach ($order_item as $product) :
                                $product_id = $product['product_id'];
                                $product = get_product_by_order_item_id($mysqli, $product_id);


                            ?>
                                <ul>
                                    <li><?php echo $product['product_name'] ?> <span>$<?php echo $product['price'] ?></span></li>

                                </ul>
                            <?php endforeach ?>
                            <div class="checkout__order__subtotal">Subtotal <span>$<?php echo $last_order['total_amount'] ?></span></div>
                            <div class="checkout__order__total">Total <span>$<?php echo $last_order['total_amount'] ?></span></div>


                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Check Payment
                                    <input type="checkbox" id="payment">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">PAYMENT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
<?php require_once("./layout/footer.php") ?>