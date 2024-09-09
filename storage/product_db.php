<?php

function save_product($mysqli, $product_name, $price, $qty, $exp_date, $discount, $product_logo, $category_id, $brand_id)
{
    $sql = "insert into product(product_name,price,qty,ex_date,discount,image,category_id,brand_id) values('$product_name', $price,$qty,'$exp_date','$discount','$product_logo',$category_id,$brand_id)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function get_all_product($mysqli)
{
    $sql = "SELECT * FROM product";
    $result = $mysqli->query($sql);
    return $result;
}

function get_all_product_with_limit($mysqli, $start_from, $count_per_page) {
    $sql = "SELECT * FROM product LIMIT $start_from, $count_per_page";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_is_new($mysqli)
{
    $sql = "SELECT * FROM product where `is_new` = true";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_best_seller($mysqli)
{
    $sql = "SELECT * FROM product where `best_seller` = true";
    $result = $mysqli->query($sql);
    return $result;
}

function get_all_discount_product($mysqli){
    $sql = "SELECT * FROM product where `ex_date`!= 'null' ";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_discount($mysqli){
    $sql = "SELECT * FROM product where `discount` != 'null' ";
    $result= $mysqli->query($sql);
    return $result;
}


function update_discount_product($mysqli,$discounted_product,$product_id)
{
    $sql = "UPDATE product SET `discount` = $discounted_product WHERE `product_id`= $product_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_by_id($mysqli, $product_id)
{
    $sql = "SELECT * FROM `product` WHERE `product_id`=$product_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function get_product_by_order_item_id($mysqli, $product_id)
{
    $sql = "SELECT * FROM `product` WHERE `product_id`=$product_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}
function get_product_by_category_id($mysqli, $category_id)
{
    $sql = "SELECT * FROM `product` WHERE `category_id`=$category_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_by_brand_id($mysqli, $brand_id)
{
    $sql = "SELECT * FROM `product` WHERE `brand_id`=$brand_id";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_limit_by_brand_id($mysqli,$brand_id,$start_from,$result_per_page)
{
    $sql = "SELECT * FROM `product` WHERE `brand_id`=$brand_id LIMIT $start_from, $result_per_page ";
    $result = $mysqli->query($sql);
    return $result;
}

function get_product_by_filter($mysqli, $product_name = null, $category_id = null ,$brand_id = null)
{
    if ($product_name && $category_id && $brand_id) {
        $sql = "SELECT * FROM `product` WHERE `product_name` LIKE '%$product_name%' AND `category_id`=$category_id AND `brand_id`=$brand_id ";
    }elseif ($product_name && $category_id) {
        $sql = "SELECT * FROM `product` WHERE `product_name` LIKE '%$product_name%' AND `category_id`=$category_id";
    }elseif ($product_name && $brand_id) {
        $sql = "SELECT * FROM `product` WHERE `product_name` LIKE '%$product_name%' AND `brand_id`=$brand_id ";
    }elseif ($product_name) {
        $sql = "SELECT * FROM `product` WHERE `product_name` LIKE '%$product_name%'";
    } elseif ($category_id) {
        $sql = "SELECT * FROM `product` WHERE `category_id` = $category_id";
    }
    elseif ($brand_id) {
        $sql = "SELECT * FROM `product` WHERE `brand_id` = $brand_id";
    }

    $result = $mysqli->query($sql);
    return $result;
}

function get_product_by_name($mysqli, $product_name)
{
    $sql = "SELECT * FROM `product` WHERE `product_name` LIKE '%$product_name%'";
    $result = $mysqli->query($sql);
    return $result;
}

function update_product($mysqli,$product_name, $price, $qty, $exp_date, $discount, $product_id)
{
    $sql = "UPDATE `product` SET `product_name`='$product_name', `price`=$price,`qty`=$qty,`ex_date`='$exp_date',`discount`='$discount' WHERE `product_id`=$product_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_product_best_seller($mysqli,$best_seller,$product_id){
    $sql = "update `product` set `best_seller`=$best_seller where `product_id` = $product_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_product_qty($mysqli,$add_qty,$product_id){
    $sql = "update `product` set `qty`=$add_qty where `product_id`= $product_id ";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_product_is_new($mysqli,$is_new,$product_id){
    $sql = "update `product` set `is_new`=$is_new where `product_id` = $product_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function update_product_image($mysqli,$image,$product_id){
    $sql = "update `product` set `image`='$image' where `product_id` = $product_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}


function delete_product($mysqli, $i_id)
{
    $sql = "DELETE FROM `product`  WHERE `product_id`=$i_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
