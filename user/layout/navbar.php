<?php 
require_once("./storage/auth_user.php");
require_once("./storage/order_item_db.php");

if (isset($_POST['logout'])) {
    setcookie("user", "", -1, "/");
    header("Location:./index.php");
}

?>

<header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> myanmar_local_food@gmail.com</li>
                                <li>Free Shipping for all Order </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right d-flex justify-content-end align-items-center">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                
                            </div>
                            <div class="header__top__right__auth me-2">
                            <a href="./my_account.php"><i class="fa fa-user"></i> My Account</a>
                            </div>
                            <div class="header__top__right__auth d-flex justify-content-center align-items-center">
                            
                                <?php if($user) :?>
                                    <form method="post">
                                        <button name="logout" class="btn btn-none " style="line-height: 2;"><i class="fa-solid fa-power-off"></i> Logout</button>
                                    </form>
                                <?php else :?>
                                    <a href="./auth/login.php"><i class="fa-solid fa-power-off"></i> Login</a>
                                    <a href="./auth/register.php"> /Register</a>
                                    <?php endif ?>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="./index.php"><img src="./image/zen_mark.jpg" class="logo" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="./index.php">Home</a></li>
                            <li><a href="./shop-grid.php">Shop</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="header__menu__dropdown">
                                    <!-- <li><a href="./shop-details.php">Shop Details</a></li> -->
                                    <li><a href="./shoping-cart.php">Shoping Cart</a></li>
                                    <li><a href="./checkout.php">Check Out</a></li>
                                    <!-- <li><a href="./blog-details.php">Blog Details</a></li> -->
                                </ul>
                            </li>
                            <!-- <li><a href="./blog.php">Blog</a></li> -->
                            <li><a href="./contact.php">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            
                            <li><a href="./shoping-cart.php"><i class="fa fa-shopping-bag"></i> <span><?php echo count($product_list) ?></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>