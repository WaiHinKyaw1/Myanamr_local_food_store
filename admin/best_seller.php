<?php
require_once("../storage/database.php");
require_once("../storage/product_db.php");
if(isset($_GET)){
    $action = $_GET['action'];
    if($action == 'no'){

        $product_id = $_GET['product_id'];
        
        $product = get_product_by_id($mysqli,$product_id);
        $product['best_seller'] = 1;
        $best_seller = $product['best_seller'];
        $best_seller = update_product_best_seller($mysqli,$best_seller,$product_id);
        header("Location: ./product_list.php");
    }

    $action = $_GET['action'];
    if($action == 'yes'){

        $product_id = $_GET['product_id'];
        
        $product = get_product_by_id($mysqli,$product_id);
        $product['best_seller'] = 0;
        $best_seller = $product['best_seller'];
        $best_seller = update_product_best_seller($mysqli,$best_seller,$product_id);
        header("Location: ./product_list.php");
    }
    
}

