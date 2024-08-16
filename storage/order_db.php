<?php
function save_order($mysqli, $user_id, $order_date, $total_amount)
{
    $sql = "insert into `order`(user_id,order_date,total_amount) values($user_id,'$order_date',$total_amount)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_order($mysqli){
    $sql = "select * from `order`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_order_with_limit($mysqli){
    $sql = "SELECT * FROM `order` ORDER BY order_id DESC LIMIT 2";
    $result = $mysqli->query($sql);
    return $result;
}

function get_order_by_id($mysqli,$order_id){
    $sql = "select * from `order` where `order_id` = $order_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_last_order($mysqli)
{
    $sql = "SELECT * FROM `order` ORDER BY `order_id` DESC LIMIT 1";
    $result = $mysqli->query($sql);
    if ($result) {
        return $result->fetch_assoc();
    }
}

function get_order_by_filter($mysqli,$search = null){
    $sql = "select * from `order` where `user_name` LIKE '%$search%' ";
    $result = $mysqli->query($sql);
    if ($result) {
        return $result;
    }
}

function delete_order($mysqli,$order_id)
{
    $sql = "delete from `order` where `order_id` = $order_id";
   if($mysqli->query($sql)){
    return true;
   }
   return false;
}

function update_order($mysqli,$payment_status,$order_status,$order_id){
    $sql = "UPDATE `order` SET `payment_status`='$payment_status' , `order_status` = '$order_status' WHERE `order_id`=$order_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}
