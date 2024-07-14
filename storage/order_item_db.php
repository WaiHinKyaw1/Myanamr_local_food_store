<?php 
session_start();
$product_list = [];
if(isset($_SESSION['product_list'])){
    $product_list = $_SESSION['product_list'];
}
