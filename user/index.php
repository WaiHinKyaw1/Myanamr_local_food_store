<?php
require_once("../storage/database.php");
require_once("../storage/product_db.php");
require_once("../storage/category_db.php");
require_once("./layout/header.php");
require_once("../storage/auth_user.php");

if (!$user) {
    header("Location: ../auth/login.php");
    die();
} elseif ($user['is_admin']) {
    header("Location: ./layout/error.php");
}

?>

<?php require_once("./layout/navbar.php") ?>
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Categories</span>
                    </div>
                    <ul>
                        <li><a href="#product">All</a></li>
                        <?php $categories = get_all_category($mysqli);
                        while ($category = $categories->fetch_assoc()) : ?>
                            <li><a href="./index.php?category_id=<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></a></li>
                        <?php endwhile ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="" method="get">
                            <input type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+95 9946386596</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="./image/People-Of-Myanmar.jpg">
                    <div class="hero__text">
                        <span>FRUIT FRESH</span>
                        <h2>Vegetable <br />100% Organic</h2>
                        <p>Free Pickup and Delivery Available</p>
                        <a href="#" class="primary-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Categories Section Begin -->
<section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <?php $categories = get_all_category($mysqli);
                while ($category = $categories->fetch_assoc()) : ?>
                    <div class="col-lg-3">
                        <div class="categories__item set-bg" data-setbg="./assets/img/categories/cat-2.jpg">
                            <h5><a href="./index.php?category_id=<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></a></h5>
                        </div>
                    </div>
                <?php endwhile ?>


            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container" id="product">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Product</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".oranges">Oranges</li>
                        <li data-filter=".Fresh Meat">Fresh Meat</li>
                        <li data-filter=".vegetables">Vegetables</li>
                        <li data-filter=".fastfood">Fastfood</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">

            <?php $products = get_all_product($mysqli);
            if (isset($_GET['category_id'])) {
                $products = get_product_by_category_id($mysqli, $_GET['category_id']);
            }
            while ($product = $products->fetch_assoc()) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix  fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="data:png/image;base64,<?php echo $product['image'] ?> ">
                            <ul class="featured__item__pic__hover">
                                <li><a href="./shop-details.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa-solid fa-eye"></i></a></li>
                                <li><a href="./shoping-cart.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#"><?php echo $product['product_name'] ?></a></h6>
                            <?php
                            if ($product['discount']) {
                                $discount_price = $product['price'] - $product['discount'];
                            ?>
                                <div class="d-flex justify-content-center">
                                <h5 class=" text-danger me-3">$<?php echo $discount_price ?> </h5>
                                <h6 class="text-decoration-line-through text-muted">$<?php echo $product['price'] ?> </h6>
                                </div>
                            <?php } else { ?>
                                <h5> $<?php echo $product['price'] ?></h5>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="./assets/img/banner/banner-1.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="./assets/img/banner/banner-2.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Latest Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <?php
                        $best_sellers = get_product_best_seller($mysqli);
                        foreach ($best_sellers as $best_seller) :
                        ?>
                            <div class="latest-prdouct__slider__item">
                                <?php
                                $best_sellers = get_product_best_seller($mysqli);
                                foreach ($best_sellers as $best_seller) :
                                ?>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="data:png/image;base64,<?php echo $best_seller['image'] ?>" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6><?php echo $best_seller['product_name'] ?></h6>
                                            <span>$<?php echo $best_seller['price'] ?></span>
                                        </div>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Top Rated Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <?php
                        $is_news = get_product_is_new($mysqli);
                        foreach ($is_news as $is_new) :
                        ?>
                            <div class="latest-prdouct__slider__item">
                                <?php
                                $is_news = get_product_is_new($mysqli);
                                foreach ($is_news as $is_new) :
                                ?>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="data:png/image;base64,<?php echo $is_new['image'] ?>" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6><?php echo $is_new['product_name'] ?></h6>
                                            <span>$<?php echo $is_new['price'] ?></span>
                                        </div>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Discount Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        <?php
                        $discounts = get_product_discount($mysqli);
                        foreach ($discounts as $discount) :
                        ?>
                            <div class="latest-prdouct__slider__item">
                                <?php
                                $discounts = get_product_discount($mysqli);
                                foreach ($discounts as $discount) :
                                ?>
                                    <a href="#" class="latest-product__item">
                                        <div class="latest-product__item__pic">
                                            <img src="data:png/image;base64,<?php echo $discount['image'] ?>" alt="">
                                        </div>
                                        <div class="latest-product__item__text">
                                            <h6><?php echo $discount['product_name'] ?></h6>
                                            <span>$<?php echo $discount['price'] ?></span>
                                        </div>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->

<!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <h2>From The Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="./assets/img/blog/blog-1.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Cooking tips make cooking simple</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="./assets/blog/blog-2.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="./assets/blog/blog-3.jpg" alt="">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="#">Visit the clean farm in the US</a></h5>
                        <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="./index.html"><img src="./assets/logo.png" alt=""></a>
                    </div>
                    <ul>
                        <li>Address: 60-49 Road 11378 New York</li>
                        <li>Phone: +65 11.188.888</li>
                        <li>Email: hello@colorlib.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">About Our Shop</a></li>
                        <li><a href="#">Secure Shopping</a></li>
                        <li><a href="#">Delivery infomation</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Our Sitemap</a></li>
                    </ul>
                    <ul>
                        <li><a href="#">Who We Are</a></li>
                        <li><a href="#">Our Services</a></li>
                        <li><a href="#">Projects</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Innovation</a></li>
                        <li><a href="#">Testimonials</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Join Our Newsletter Now</h6>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <form action="#">
                        <input type="text" placeholder="Enter your mail">
                        <button type="submit" class="site-btn">Subscribe</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                    <div class="footer__copyright__payment"><img src="./assets/payment-item.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<?php require_once("./layout/footer.php") ?>