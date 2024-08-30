<?php require_once("./storage/auth_user.php") ?>
<?php require_once("./storage/user_db.php") ?>
<?php require_once("./storage/order_db.php") ?>
<?php require_once("./storage/product_db.php") ?>
<?php require_once("./storage/database.php") ?>
<?php require_once("./storage/order_item_db.php")?>
<?php require_once("./user/layout/header.php") ?>
<?php require_once("./user/layout/navbar.php") ?>
<?php
require_once("./storage/auth_user.php");
$payment_method_error = "";

?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="./user/assets/img/breadcrumb.jpg">
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
            
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="row">
                            <h6 class="text-muted text-center  m-0 p-2">Express Checkout</h6>
                            <div class="col-lg-4 my-3">

                                <img src="./user/image/kpay.png" style="width:100%;height:50px;" class="rounded" data-toggle="modal" data-target="#modal-notification" alt="">

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

                                <img src="./user/image/wave.png" style="width:100%;height:50px;" class="rounded" data-toggle="modal" data-target="#wave" alt="">

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
                                <img src="./user/image/mytel.jpg" style="width:100%;height:50px;" class="rounded" data-toggle="modal" data-target="#mytel" alt="">

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
                            <form action="./payment.php" method="post" enctype="multipart/form-data">
                            
                            <h6 class="text-muted text-center  m-0 p-2 mb-3">Delivery</h6>
                            <div class="checkout__input">
                                <p>Name<span>*</span></p>
                                <input type="text" name="name" required="">

                            </div>
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text" name="phone" required="" value="<?php   ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="text" name="email" required="" class="required" value="<?php  ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>City<span>*</span></p>
                                        <input type="text" name="city" required="" value="<?php   ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Street<span>*</span></p>
                                        <input type="text" name="street" required="" value="<?php  ?>">
                                    </div>
                                </div>
                            </div>
 
                            <div class="checkout__input">
                                <p>Order notes<span>*</span></p>
                                <input type="text" name="order_note" required="" placeholder="Notes about your order, e.g. special notes for delivery.">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <div class="checkout__order">

                                <!-- <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <?php
                                $last_order = get_last_order($mysqli);
                                $last_order_id = $last_order['order_id'];
                                $order_item = get_all_order_item_by_order_id($mysqli, $last_order_id);
                                foreach ($order_item as $product) :
                                    $product_id = $product['product_id'];
                                    $products = get_product_by_order_item_id($mysqli, $product_id);

                                ?>
                                    <ul>
                                        <li class="d-flex justify-content-between">
                                            <?php echo $products['product_name'] ?>
                                             <span><?php if (isset($product['discount'])) { ?>
                                                    $<?php echo  $price = $product['price'] - $product['discount']; ?>
                                                <?php } else { ?>
                                                    $<?php echo $product['price'] ?>
                                                <?php } ?></span>
                                                <span><?= $product['amount'] ?></span>
                                        </li>

                                    </ul>
                                <?php endforeach ?>
                                <div class="checkout__order__total"></div>
                                <div class="checkout__order__total">Total <span>$<?php echo $last_order['total_amount'] ?></span></div> -->

                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <?php
                                $total_price=0;
                                foreach ($product_list as $product) :
                                    

                                ?>
                                    <ul>
                                        <li class="d-flex justify-content-between">
                                            <?php echo $product['product_name'] ?>
                                            <!-- <span><?php if (isset($product['discount'])) { ?>
                                                    $<?php echo  $price = $product['price'] - $product['discount']; ?>
                                                <?php } else { ?>
                                                    $<?php echo $product['price'] ?>
                                                <?php } ?></span> -->
                                                <span><?= $product['amount'] ?></span>
                                        </li>

                                    </ul>
                                    <?php 
                                    $total_price = $total_price + $product['amount'];
                                
                                endforeach ?>
                                <div class="checkout__order__total"></div>
                                <div class="checkout__order__total">Total <span>$<?= $total_price ?></span></div>

                                <div class="d-flex">
                                    
                                        <div class="form-check ">
                                            <input class="form-check-input" type="radio" name="payment_method" value="Kbz Pay" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Kpz Pay
                                            </label>
                                            <small class="text-danger"><?php echo $payment_method_error ?></small>
                                        </div>

                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="radio" name="payment_method" value="Wave Pay" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Wave Pay
                                            </label>
                                            <small class="text-danger"><?php echo $payment_method_error ?></small>
                                        </div>
                                        
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="radio" name="payment_method" value="Mytel Pay" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Mytel Pay
                                            </label>
                                            <small class="text-danger"><?php echo $payment_method_error ?></small>
                                        </div>
                                    
                                </div>

                                    <div class="checkout__input__radio mt-3">
                                        <label for=""><i class="fa-solid fa-image"></i>Upload Your Secreanshoot</label>
                                        <input type="file" name="screenshot" id="" required="">
                                    </div>
                                    <input type="hidden" name="order" value="<?php echo $last_order_id; ?>">
                                    <button type="submit" name="payment" class="site-btn">PAYMENT</button>
                            </form>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</section>
<!-- Checkout Section End -->
<?php require_once("./user/layout/footer.php") ?>