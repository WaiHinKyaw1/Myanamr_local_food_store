<?php

function save_product($mysqli,$product_name, $price,$qty,$exp_date,$discount,$product_logo,$category_id,$brand_id){
    $sql = "insert into product(product_name,price,qty,ex_date,discount,image,category_id,brand_id) values('$product_name', $price,$qty,'$exp_date',$discount,'$product_logo',$category_id,$brand_id)";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function get_all_product($mysqli){
    $sql = "SELECT * FROM product";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_by_id($mysqli,$product_id){
    $sql = "SELECT * FROM `product` WHERE `product_id`=$$product_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
function get_product_by_category_id($mysqli,$category_id){
    $sql = "SELECT * FROM `product` WHERE `category_id`=$category_id";
    $result = $mysqli->query($sql);
    return $result;
}

function update_product($mysqli,$i_id,$i_name,$price,$qty,$b_id,$description){
    $sql = "UPDATE `product` SET `i_name`='$i_name', `price`=$price,`qty`=$qty,`b_id`=$b_id,`description`='$description' WHERE `i_id`=$i_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function delete_product($mysqli,$i_id){
    $sql = "DELETE FROM `product`  WHERE `i_id`=$i_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}