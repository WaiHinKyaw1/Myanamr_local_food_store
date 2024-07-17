<?php
require_once("../storage/auth_user.php");
if (!$user) {
    header("Location: ../auth/login.php");
    die();
} elseif ($user['is_admin']) {
    header("Location: ./layout/error.php");
}
?>
<?php 
require_once("../storage/database.php");
require_once("../storage/product_db.php");
require_once("../storage/category_db.php");
require_once("../storage/user_db.php");
?>

<?php require_once("./layout/header.php") ?>
<?php require_once("./layout/navbar.php") ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="./assets/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Vegetable’s Package</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            
                            <span>Vegetable’s Package</span>
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
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="data:png/image;base64,<?php echo $product['image'] ?>" alt="">
                        </div>
                        <div class="product__details__pic__slider owl-carousel">
                            <img data-imgbigurl="./assets/img/product/details/product-details-2.jpg"
                                src="./assets/img/product/details/thumb-1.jpg" alt="">
                            <img data-imgbigurl="./assets/img/product/details/product-details-3.jpg"
                                src="./assets/img/product/details/thumb-2.jpg" alt="">
                            <img data-imgbigurl="./assets/img/product/details/product-details-5.jpg"
                                src="./assets/img/product/details/thumb-3.jpg" alt="">
                            <img data-imgbigurl="./assets/img/product/details/product-details-4.jpg"
                                src="./assets/img/product/details/thumb-4.jpg" alt="">
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
                            <span>(<?php echo count($user) .'view' ?>)</span>
                        </div>
                        <div class="product__details__price">$<?php echo $product['price'] ?></div>
                        <!-- <p>Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ac diam sit amet quam
                            vehicula elementum sed sit amet dui. Sed porttitor lectus nibh. Vestibulum ac diam sit amet
                            quam vehicula elementum sed sit amet dui. Proin eget tortor risus.</p> -->
                        
                        <a href="./shoping-cart.php?product_id=<?php echo $product['product_id'] ?>" class="primary-btn">ADD TO CARD</a>
                        
                        <ul>
                            <li><b>Availability</b> <span><?php echo $product['qty'] ?></span></li>
                            <li><b>Shipping</b> <span>01 day shipping. <samp>Free pickup today</samp></span></li>
                            
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
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
                            <li><a href="./shop-details.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa-solid fa-eye"></i></a></li>
                            <li><a href="./shoping-cart.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#"><?php echo $related_product['product_name'] ?></a></h6>
                            <h5>$<?php echo $related_product['price']  ?></h5>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
    <?php require_once("./layout/footer.php") ?>