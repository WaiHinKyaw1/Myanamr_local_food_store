<?php

function save_brand($mysqli,$brand_name){
    $sql = "INSERT INTO `brand`(`brand_name`) VALUES ('$brand_name')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function get_all_brand($mysqli){
    $sql = "SELECT * FROM `brand`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_brand_by_id($mysqli,$brand_id){
    $sql = "SELECT * FROM `brand` WHERE `brand_id`=$brand_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function update_brand($mysqli,$brand_id,$brand_name){
    $sql = "UPDATE `brand` SET `brand_name`='$brand_name' WHERE `brand_id`=$brand_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function delete_brand($mysqli,$brand_id){
    $sql = "DELETE FROM `brand`  WHERE `brand_id`=$brand_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

