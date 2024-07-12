<?php

function save_customer($mysqli, $c_name, $email, $address, $password)
{
    $sql = "INSERT INTO `customer`(`c_name`,`email`,`address`,`password`) VALUES ('$c_name','$email','$address','$password')";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function save_admin($mysqli)
{
    $password = password_hash("admin", PASSWORD_DEFAULT);
    $sql = "INSERT INTO `customer`(`c_name`,`email`,`address`,`password`,`is_admin`) VALUES ('admin','admin@gmail.com','admin address','$password',true)";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}




function get_all_customer($mysqli)
{
    $sql = "SELECT * FROM `customer`";
    $result = $mysqli->query($sql);
    return $result;
}

function get_customer_by_id($mysqli, $c_id)
{
    $sql = "SELECT * FROM `costomer` WHERE `c_id`=$c_id";
    $result = $mysqli->query($sql);
    if ($result)  return $result->fetch_assoc();
}

function get_customer_by_email($mysqli, $email)
{
    $sql = "SELECT * FROM `customer` WHERE `email`='$email'";
    $result = $mysqli->query($sql);
    if ($result) return $result->fetch_assoc();
}

function update_customer($mysqli, $c_id, $c_name, $email, $address, $password)
{
    $sql = "UPDATE `customer` SET `c_name`='$c_name', `email`='$email',`address`='$address',`password`='$password' WHERE `c_id`=$c_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function delete_customer($mysqli, $c_id)
{
    $sql = "DELETE FROM `customer`  WHERE `c_id`=$c_id";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}
