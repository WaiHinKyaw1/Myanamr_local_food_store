<?php 
session_start();
$product_list = [];
if(isset($_SESSION['product_list'])){
    $product_list = $_SESSION['product_list'];
}

function save_order_item($mysqli,$order_id,$product_id,$qty,$amount){
    $sql = "insert into `order_item`(order_id,product_id,qty,amount) values ($order_id,$product_id,$qty,$amount)";
   if($mysqli->query($sql)){
    return true;
   }
   return false;
}
function get_all_order_item($mysqli){
    $sql = "select * from `order_item`" ;
   
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_all_order_item_by_order_id($mysqli,$order_id){
    $sql = "select * from `order_item` where `order_id` = $order_id LIMIT 2";
   
    $result = $mysqli->query($sql);
    return $result;
}