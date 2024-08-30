<?php

function save_deliver($myqli,$order_id,$user_id,$name,$email,$phone,$city,$street,$order_note){
$sql = "INSERT INTO `deliver`(order_id,user_id,customer_name,email,phone,city,street,order_note) values($order_id,$user_id,'$name','$email',$phone,'$city','$street','$order_note')";
if($myqli->query($sql)){
    return true;
}else{
    return false;
}
}

function get_deliver_by_user_id($mysqli, $user_id)
{
    $sql = "SELECT * FROM `deliver` WHERE `user_id`=$user_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}