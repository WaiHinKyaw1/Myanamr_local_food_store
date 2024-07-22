<?php
require_once("../storage/database.php");
require_once("../storage/product_db.php");
if(isset($_GET)){
    $action = $_GET['action'];
    if($action == 'no'){

        $product_id = $_GET['product_id'];
        
        $product = get_product_by_id($mysqli,$product_id);
        $product['is_new'] = 1;
        $is_new = $product['is_new'];
        $is_new = update_product_is_new($mysqli,$is_new,$product_id);
        header("Location: ./product_list.php");
    }

    $action = $_GET['action'];
    if($action == 'yes'){

        $product_id = $_GET['product_id'];
        
        $product = get_product_by_id($mysqli,$product_id);
        $product['is_new'] = 0;
        $is_new = $product['is_new'];
        $is_new = update_product_is_new($mysqli,$is_new,$product_id);
        header("Location: ./product_list.php");
    }
    
}

