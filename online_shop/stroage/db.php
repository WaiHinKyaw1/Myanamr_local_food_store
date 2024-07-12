<?php

$mysqli = new mysqli("localhost", "root", "");

if ($mysqli->connect_error) {
    echo "Error occuring";
}

function create_db($mysqli)
{
    $sql = "CREATE DATABASE IF NOT EXISTS v2_online_shop";
    if ($mysqli->query($sql)) {
        return true;
    }
    return false;
}

function select_db($mysqli)
{
    if ($mysqli->select_db("v2_online_shop")) {
        return true;
    }
    return false;
}

function create_tables($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS `brand`(
        `brand_id` INT AUTO_INCREMENT,
        `brand_name` VARCHAR(20) NOT NULL,
        PRIMARY KEY(`brand_id`)
        )";
    if ($mysqli->query($sql) === false) return false;
    $sql = "CREATE TABLE IF NOT EXISTS `item`(
        `i_id` INT AUTO_INCREMENT,
    `i_name` VARCHAR(45) NOT NULL,
    `price` INT NOT NULL,
    `qty` INT NOT NULL,
    `b_id` INT NOT NULL,
    `description` TEXT NOT NULL,
    `img` TEXT,
    PRIMARY KEY(`i_id`),
    FOREIGN KEY(`b_id`) REFERENCES `brand`(`brand_id`)
    )";
    if ($mysqli->query($sql) === false) return false;
    $sql = "CREATE TABLE IF NOT EXISTS `customer`(
        `c_id` INT AUTO_INCREMENT , 
        `c_name` VARCHAR (20) NOT NULL,
        `email` VARCHAR (45) NOT NULL,
        `address` VARCHAR (255) NOT NULL,
        `password` VARCHAR (255) NOT NULL,
        `is_admin` BOOLEAN DEFAULT(false),
        PRIMARY KEY(`c_id`),
        UNIQUE (`email`)
        ) ";
    if ($mysqli->query($sql) === false) return false;
    $sql = "CREATE TABLE IF NOT EXISTS `order`(
        `o_id` INT AUTO_INCREMENT,
        `o_name` VARCHAR (20) NOT NULL,
        `amount` INT NOT NULL,
        `qty` INT NOT NULL,
        `i_id` INT NOT NULL,
        `c_id` INT NOT NULL,
        PRIMARY KEY(`o_id`),
        FOREIGN KEY(`i_id`) REFERENCES `item`(`i_id`),
        FOREIGN KEY(`c_id`) REFERENCES `customer`(`c_id`) 
        )";
    if ($mysqli->query($sql) === false) return false;
    return true;
}

create_db($mysqli);
select_db($mysqli);
create_tables($mysqli);
