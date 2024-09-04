<?php
require_once("./storage/database.php");
require_once("./storage/product_db.php");
require_once("./storage/brand_db.php");
require_once("./storage/auth_user.php");
require_once("./user/layout/navbar.php");
require_once("./user/layout/header.php");
?>

<section class="breadcrumb-section set-bg" data-setbg="./user/assets/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Myanmar Local Food Store</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.php">Home</a>
                        <span>Shop</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-7">
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Sale Off</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">
                            <?php
                            $dis_products = get_product_discount($mysqli);
                            foreach ($dis_products as $product) :
                            ?>
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg" data-setbg="data:image/png;base64,<?php echo $product['image'] ?>">
                                            <div class="product__discount__percent">-10%</div>
                                            <ul class="product__item__pic__hover">
                                                <li><a href="./shop-details.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa-solid fa-eye"></i></a></li>
                                                <li><a href="./shoping-cart.php?product_id=<?php echo $product['product_id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span class="text-danger">Discount Products</span>
                                            <h5><?php echo $product['product_name'] ?></h5>
                                            <div class="product__item__price mt-3">
                                                <?php
                                                if ($product['discount']) {
                                                    $discount_price = $product['price'] - $product['discount'];
                                                ?>
                                                    <div class="d-flex justify-content-center">
                                                        <h6 class=" text-danger me-3"><?php echo $discount_price ?> Kyats</h6>
                                                        <h6 class="text-decoration-line-through text-muted"><?php echo $product['price'] ?> Kyats</h6>
                                                    </div>
                                                <?php } else { ?>
                                                    <h6 class=" text-dark"> <?php echo $product['price'] ?> Kyats</h6>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort d-flex">
                                <span class="me-3">Sort By</span>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Brand
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php $brands = get_all_brand($mysqli);
                                        foreach ($brands as $brand):
                                        ?>
                                            <li><a class="dropdown-item" href="./shop-grid.php?brand_id=<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></a></li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php

                $result_per_page = 9;
                if (isset($_GET["page"])) {
                    $page  = $_GET["page"];
                } else {
                    $page = 1;
                }

                $start_from = ($page - 1) * $result_per_page;
                $all_products = get_all_product_with_limit($mysqli, $start_from, $result_per_page);
                if(isset($_GET['brand_id'])){
                    $brand_id = $_GET['brand_id'];
                    $all_products = get_product_limit_by_brand_id($mysqli,$brand_id,$start_from,$result_per_page);
                }
                foreach ($all_products as $product) :
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="data:image/png;base64,<?= $product['image'] ?>">
                                <ul class="product__item__pic__hover">
                                    <li><a href="./shop-details.php?product_id=<?= $product['product_id'] ?>"><i class="fa-solid fa-eye"></i></a></li>
                                    <li><a href="./shoping-cart.php?product_id=<?= $product['product_id'] ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><?= $product['product_name'] ?></h6>
                                <h5>
                                    <?php
                                    if ($product['discount']) {
                                        $discount_price = $product['price'] - $product['discount'];
                                    ?>
                                        <div class="d-flex justify-content-center">
                                            <h6 class=" text-danger me-3"><?php echo $discount_price ?> Kyats</h6>
                                            <h6 class="text-decoration-line-through text-muted"><?php echo $product['price'] ?> Kyats</h6>
                                        </div>
                                    <?php } else { ?>
                                        <h6 class=" text-dark"> <?php echo $product['price'] ?> Kyats</h6>
                                    <?php } ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="pagination">
                    <?php
                    $total_records = get_all_product($mysqli)->num_rows;

                    echo "</br>";  
                    $total_pages = ceil($total_records / $result_per_page);
                    $pagLink = "";

                    if ($page >= 2) {
                        echo "<a href='shop-grid.php?page=" . ($page - 1) . "'>  Prev </a>";
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $pagLink .= "<a class = 'active' href='shop-grid.php?page=" . $i . "'>
                                " . $i . " </a>";
                        } else {
                            $pagLink .= "<a href='shop-grid.php?page=" . $i . "'>   
                                 " . $i . " </a>";
                        }
                    };
                    echo $pagLink;

                    if ($page < $total_pages) {
                        echo "<a href='shop-grid.php?page=" . ($page + 1) . "'>  Next </a>";
                    }

                    ?>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>



<?php require_once("./user/layout/footer.php") ?>