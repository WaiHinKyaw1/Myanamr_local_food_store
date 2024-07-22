<?php
function save_order($mysqli, $user_id, $order_date, $total_amount, $status)
{
    $sql = "insert into `order`(user_id,order_date,total_amount,status) values($user_id,'$order_date',$total_amount,'$status')";
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

function get_last_order($mysqli)
{
    $sql = "SELECT * FROM `order` ORDER BY `order_id` DESC LIMIT 1";
    $result = $mysqli->query($sql);
    if ($result) {
        return $result->fetch_assoc();
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

function update_order($mysqli,$category_id,$category_name){
    $sql = "UPDATE `category` SET `category_name`='$category_name' WHERE `category_id`=$category_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}
