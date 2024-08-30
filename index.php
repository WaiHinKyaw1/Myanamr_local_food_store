<?php
require_once("./storage/database.php");
require_once("./storage/product_db.php");
require_once("./storage/category_db.php");
require_once("./storage/brand_db.php");
require_once("./storage/order_item_db.php");
require_once("./user/layout/header.php");
require_once("./storage/order_db.php");
require_once("./storage/auth_user.php");

$result_per_page = 8;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $result_per_page;
$all_products = get_all_product_with_limit($mysqli, $start_from, $result_per_page);

?>

<?php require_once("./user/layout/navbar.php") ?>

<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Brands</span>
                    </div>
                    <ul>
                        <li><a href="#product">All</a></li>
                        <?php $brands = get_all_brand($mysqli);
                        while ($brand = $brands->fetch_assoc()) : ?>
                            <li><a href="./index.php?brand_id=<?php echo $brand['brand_id'] ?><?php if (isset($_GET['name'])) : ?>&name=<?php echo $_GET['name'] ?> <?php endif ?>"><?php echo $brand['brand_name'] ?></a></li>
                        <?php endwhile ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="./index.php" method="GET">
                            <input name="name" id="name-filter" type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text ">
                            <h5 class="mt-3">+95 9946386596</h5>

                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="./user/image/bg-myanmar.jpg">
                    <div class="hero__text">
                        <span>Myanmar Local Food</span>
                        <h2>Product <br />100% Quality</h2>
                        <p class="text-warning">Free Pickup and Delivery Available</p>
                        <a href="./shop-grid.php" class="primary-btn">SHOP NOW</a>
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
                        <div class="categories__item set-bg" data-setbg="data:png/image;base64,<?php echo $category['category_img'] ?>">
                            <h5><a href="./index.php?category_id=<?php echo $category['category_id'] ?><?php if (isset($_GET['name'])) : ?>&name=<?php echo $_GET['name'] ?> <?php endif ?>"><?php echo $category['category_name'] ?></a></h5>
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
            </div>
        </div>
        <?php if (isset($_GET['brand_id'])) : ?>
            <?php $brand = get_brand_by_id($mysqli, $_GET['brand_id']); ?>
            <div class="row my-5" style="background-color:#c9d1d1;">
                <div class="col d-flex justify-content-center align-items-center p-2">
                    <div class=" w-50 text-center "><?php echo $brand['brand_name'] ?></div>
                    <div class="w-50">
                        <img src="data:png/image;base64,<?php echo $brand['brand_logo'] ?>" style="width:200px;height:120px;" alt="">
                    </div>
                </div>

            </div>
        <?php endif ?>
        <div class="row featured__filter">

            <?php $products = $all_products;
            if (isset($_GET['category_id']) || isset($_GET['name']) || isset($_GET['brand_id'])) {
                $name = isset($_GET['name']) ? $_GET['name'] : null;
                $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
                $brand_id = isset($_GET['brand_id']) ? $_GET['brand_id'] : null;
                $products = get_product_by_filter($mysqli, $name, $category_id, $brand_id);
            }


            while ($product = $products->fetch_assoc()) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mix  fresh-meat">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="data:png/image;base64,<?php echo $product['image'] ?>">
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
                                    <h6 class=" text-danger me-3"><?php echo $discount_price ?>Kyats </h6>
                                    <h6 class="text-decoration-line-through text-muted"><?php echo $product['price'] ?>Kyats </h6>
                                </div>
                            <?php } else { ?>
                                <h6 class=" text-dark"><?php echo $product['price'] ?>Kyats</h6>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php endwhile ?>

            <div class="pagination">
                <?php
                $total_records = get_all_product($mysqli)->num_rows;

                echo "</br>";
                $total_pages = ceil($total_records / $result_per_page);
                $pagLink = "";

                if ($page >= 2) {
                    echo "<a href='index.php?page=" . ($page - 1) . "'>  Prev </a>";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        $pagLink .= "<a class = 'active' href='index.php?page="
                            . $i . "'>" . $i . " </a>";
                    } else {
                        $pagLink .= "<a href='index.php?page=" . $i . "'>   
                                                " . $i . " </a>";
                    }
                };
                echo $pagLink;

                if ($page < $total_pages) {
                    echo "<a href='index.php?page=" . ($page + 1) . "'>  Next </a>";
                }

                ?>
            </div>
        </div>
    </div>
</section>
<!-- Featured Section End -->


<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="latest-product__text">
                    <h4>Best Seller Products</h4>
                    <div class="latest-product__slider owl-carousel ">
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
                    <h4>New Arrival Products</h4>
                    <div class="latest-product__slider owl-carousel">
                       
                        
                         


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
                        <!-- <?php //endforeach ?> -->
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


<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 ">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="./index.html"><img src="./assets/logo.png" alt=""></a>
                    </div>
                    <ul>
                        <li>Address: Kamayut ,Yangon</li>
                        <li>Phone: +95 9946386596</li>
                        <li>Email: myanmar_local_food@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Useful Links</h6>
                    <ul>
                        <li><a href="#">All Product</a></li>
                        <li><a href="#">Instock Our Product</a></li>
                        <li><a href="./contact.php">About Our Shop</a></li>
                        <li><a href="#">Delivery infomation</a></li>


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
                            </script> All rights reserved <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                    <div class="footer__copyright__payment"><img src="./assets/payment-item.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<?php require_once("./user/layout/footer.php") ?>