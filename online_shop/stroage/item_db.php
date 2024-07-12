<?php

function save_item($mysqli,$i_name,$price,$qty,$b_id,$description,$img){
    $sql = "INSERT INTO `item`(`i_name`,`price`,`qty`,`b_id`,`description`,`img`) VALUES ('$i_name',$price,$qty,$b_id,'$description','$img')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function get_all_item($mysqli){
    $sql = "SELECT item.i_id, item.i_name, item.price, item.qty, item.b_id, 
    item.description, brand.brand_name,item.img FROM `item` INNER JOIN `brand` 
    ON item.b_id = brand.brand_id;";
    $result = $mysqli->query($sql);
    return $result;
}

function get_all_item_by_b_id($mysqli,$b_id){
    $sql = "SELECT item.i_id, item.i_name, item.price, item.qty, item.b_id, 
    item.description, brand.brand_name FROM `item` INNER JOIN `brand` 
    ON item.b_id = brand.brand_id WHERE item.b_id=$b_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_item_by_id($mysqli,$i_id){
    $sql = "SELECT * FROM `item` WHERE `i_id`=$i_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function update_item($mysqli,$i_id,$i_name,$price,$qty,$b_id,$description){
    $sql = "UPDATE `item` SET `i_name`='$i_name', `price`=$price,`qty`=$qty,`b_id`=$b_id,`description`='$description' WHERE `i_id`=$i_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function delete_item($mysqli,$i_id){
    $sql = "DELETE FROM `item`  WHERE `i_id`=$i_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}