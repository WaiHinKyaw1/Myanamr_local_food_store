<?php 

function save_payment($mysqli,$order_id,$payment_date,$payment_img,$payment_method){
    $sql = "insert into `payment`(order_id,payment_date,payment_img,payment_method) values($order_id,'$payment_date','$payment_img','$payment_method')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}
 function get_payment_by_id($mysqli,$order_id){
    $sql = "select * from payment where `order_id` = $order_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
 }