<?php

function save_category($mysqli,$category_name){
    $sql = "INSERT INTO `category`(`category_name`) VALUES ('$category_name')";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function get_all_category($mysqli){
    $sql = "SELECT * FROM `category`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_category_by_id($mysqli,$category_id){
    $sql = "SELECT * FROM `category` WHERE `category_id`=$category_id";
    $result = $mysqli->query($sql);
    return $result->fetch_assoc();
}

function update_category($mysqli,$category_id,$category_name){
    $sql = "UPDATE `category` SET `category_name`='$category_name' WHERE `category_id`=$category_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

function delete_category($mysqli,$category_id){
    $sql = "DELETE FROM `category`  WHERE `category_id`=$category_id";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}

