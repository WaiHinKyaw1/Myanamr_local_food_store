
<?php 
require_once("./storage/database.php");
require_once("./storage/product_db.php");
require_once("./storage/category_db.php");
require_once("./storage/user_db.php");
?>

<?php require_once("./user/layout/header.php") ?>
<?php require_once("./user/layout/navbar.php") ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="./user/assets/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Myanmar Local Food Store</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            
                            <span>Product Details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <?php 
                        if(isset($_GET['product_id'])){
                            $product = get_product_by_id($mysqli,$_GET['product_id']);
                        }
                    ?>
                    <div class="product__details__pic">
                        <div class="ms-5">
                            <img class="" style="width: 350px; height:350px;"
                                src="data:png/image;base64,<?php echo $product['image'] ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $product['product_name'] ?></h3>
                        <div class="product__details__rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <span><?php if($user) echo count($user) .'view' ?></span>
                        </div>
                        <div class="product__details__price">
                            <?php if(isset($product['discount'])){ ?>
                            <?php  echo  $price = $product['price'] - $product['discount']; ?>Kyats
                            <?php } else { ?>
                            <?php echo $product['price'] ?>Kyats
                            <?php } ?>   
                        </div>
                        <a href="./shoping-cart.php?product_id=<?= $product['product_id'] ?>" class="primary-btn">ADD TO CARD</a>
                        
                        <ul>
                            <li><b>Availability</b> <span><?php echo $product['qty'] ?></span></li>
                            <li><b>Exp Date</b> <span><?php echo $product['ex_date'] ?></span></li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href=""><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>You Might Also Like These</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php 
                $category_id = $product['category_id'];
                $related_products = get_product_by_category_id($mysqli,$category_id);
                foreach($related_products as $related_product) :
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="data:png/image;base64,<?php echo $related_product['image']  ?>">
                            <ul class="product__item__pic__hover">
                            <li><a href="./shop-details.php?product_id=<?php echo $related_product['product_id'] ?>"><i class="fa-solid fa-eye"></i></a></li>
                            <li><a href="./shoping-cart.php?product_id=<?php echo $related_product['product_id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#"><?php echo $related_product['product_name'] ?></a></h6>
                            <h5><?php echo $related_product['price']  ?> Kyats</h5>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
    <?php require_once("./user/layout/footer.php") ?>