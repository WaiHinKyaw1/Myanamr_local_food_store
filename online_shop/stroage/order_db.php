<?php

function save_order($mysqli,$o_name,$amount,$qty,$i_id,$c_id){
    $sql = "INSERT INTO `order`(`o_name`,`amount`,`qty`,`i_id`,`c_id`) VALUES ('$o_name',$amount,$qty,$i_id,$c_id)";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function get_all_order($mysqli){
    $sql = "SELECT `item`.`i_name`,`customer`.`c_name` , `order`.`o_name`, `order`.`qty`,`order`.`amount` FROM `order` LEFT JOIN `item` ON `order`.`i_id`= `item`.`i_id` LEFT JOIN `customer` ON `order`.`c_id`=`customer`.`c_id`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_last_order($mysqli){
    $sql = "SELECT * FROM `order` ORDER BY `o_id` DESC LIMIT 1";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_last_order_by_subquery($mysqli){
    $sql = "SELECT * FROM `order` WHERE `o_id`=(SELECT MAX(`o_id`) FROM `order`)";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_order_by_id($mysqli,$o_id){
    $sql = "SELECT * FROM `order` WHERE `o_id`=$o_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function update_order($mysqli,$o_id,$o_name,$amount,$qty,$i_id,$c_id){
    $sql = "UPDATE `order` SET `o_name`='$o_name', `amount`=$amount,`qty`=$qty,`i_id`=$i_id,`c_id`=$c_id WHERE `c_id`=$c_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function delete_order($mysqli,$o_id){
    $sql = "DELETE FROM `order`  WHERE `o_id`=$o_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}