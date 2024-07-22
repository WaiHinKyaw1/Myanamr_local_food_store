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
if(isset($_POST)){
    $last_order = get_last_order($mysqli);
    $last_order_id = $last_order['order_id'];
    $order_item = get_all_order_item_by_order_id($mysqli, $last_order_id);
    foreach ($order_item as $order){
        $product_id =$order['product_id'];
        $product = get_product_by_id($mysqli,$product_id);      
        $product['qty'] = $product['qty'] - $order['qty'];
            $qty = $product['qty'];
            $product_qty = update_product_qty($mysqli,$qty,$product_id);
        
    }
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
                            <div class="col-lg-4 my-3">
                                
                            <img src="./image/kpay.png" style="width:100%;height:50px;" class="rounded" data-toggle="modal" data-target="#modal-notification" alt="">
                                
                                <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                    <div class="modal-dialog modal-info modal-dialog-centered" role="document">
                                        <div class="modal-content bg-gradient-secondary">
                                            <div class="modal-header">
                                                <p class="modal-title" id="modal-title-notification">KBZ Pay</p>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="py-3 text-center">
                                                    <img src="./image/kpay_qr.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="./checkout.php"><button type="button" class="btn btn-sm btn-white">Go to Checkout</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                  
                            </div>
                            <div class="col-lg-4 my-3">
                                
                            <img src="./image/wave.png" style="width:100%;height:50px;" class="rounded" data-toggle="modal" data-target="#wave" alt="">
                                
                                <div class="modal fade" id="wave" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                    <div class="modal-dialog modal-info modal-dialog-centered" role="document">
                                        <div class="modal-content bg-gradient-secondary">
                                            <div class="modal-header">
                                                <p class="modal-title" id="modal-title-notification">Wave Pay</p>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="py-3 text-center">
                                                    <img src="./image/wave_qr.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <a href="./checkout.php"><button type="button" class="btn btn-sm btn-white">Go to Checkout</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                  
                            </div>
                            <div class="col-lg-4 my-3">
                            <img src="./image/mytel.jpg" style="width:100%;height:50px;" class="rounded" data-toggle="modal" data-target="#mytel" alt="">
                                
                                <!-- Modal Content -->
                                <div class="modal fade" id="mytel" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                                    <div class="modal-dialog modal-info modal-dialog-centered" role="document">
                                        <div class="modal-content bg-gradient-secondary">
                                            <div class="modal-header">
                                                <p class="modal-title" id="modal-title-notification">Mytel Pay</p>
                                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="py-3 text-center">
                                                    <img src="./image/mytel_qr.jpg" style="width: 80%;height:70%;" alt="">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <a href="./checkout.php"><button type="button" class="btn btn-sm btn-white">Go to Checkout</button></a>
                                            </div>
                                        </div>
                                    </div>
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
                            <form action="./checkout.php" method="post">

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
                                <li>
                                <?php echo $product['product_name'] ?>
                                <span><?php if(isset($product['discount'])){ ?>
                                 $<?php  echo  $price = $product['price'] - $product['discount']; ?>
                                <?php } else { ?>
                                 $<?php echo $product['price'] ?>
                                <?php } ?></span>
                                </li>
    
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
                            </form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
<?php require_once("./layout/footer.php") ?>