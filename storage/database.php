<?php
$mysqli = new mysqli("localhost", "root", "");
if ($mysqli->connect_error) {
    echo "Database Connection Error!";
}

function create_database($mysqli)
{
    $sql = "CREATE DATABASE IF NOT EXISTS myanmar_store";
    if ($mysqli->query($sql)) {
        return true;
    } else {
        return false;
    }
}

function select_db($mysqli)
{
    if ($mysqli->select_db("myanmar_store")) {
        return true;
    } else {
        return false;
    }
}

function create_tables($mysqli)
{
    $sql = "CREATE TABLE IF NOT EXISTS `user`(
    `user_id` int auto_increment,
    `name` varchar(255) not null,
    `email` varchar(50) unique not null,
    `phone` int not null,
    `address` varchar(255) not null,
    `password` varchar(255) not null,
    `is_admin` boolean default(false),
     primary key(`user_id`)
     )";
    if ($mysqli->query($sql) === false) return false;

    $sql = "CREATE TABLE IF NOT EXISTS `discount`(
        `discount_id` INT AUTO_INCREMENT PRIMARY KEY,
        `start_date` DATE NOT NULL,
        `end_date` DATE NOT NULL
    )";
    if ($mysqli->query($sql) === false) return false;


    $sql = "CREATE TABLE IF NOT EXISTS `category`(
        `category_id` INT AUTO_INCREMENT PRIMARY KEY,
        `category_name` VARCHAR(255) NOT NULL,
        `category_img`  TEXT NULL
        )";
    if ($mysqli->query($sql) === false) return false;

    $sql = "CREATE TABLE IF NOT EXISTS `brand`(
        `brand_id` INT AUTO_INCREMENT PRIMARY KEY,
        `brand_name` VARCHAR(255) NOT NULL,
        `brand_logo` TEXT NOT NULL
    )";
    if ($mysqli->query($sql) === false) return false;

    $sql = "create table IF NOT EXISTS `product` (
    `product_id` int auto_increment primary key,
    `product_name` varchar(255) not null, 
    `price` varchar(255) not null,
    `qty` int not null,
    `ex_date` date not null,
    `discount` int null,
    `image` text not null,
    `best_seller` boolean default(false),
    `is_new` boolean default(true),  
    `category_id` int,
    `brand_id` int,
    foreign key(`category_id`) references `category`(`category_id`) on delete cascade,
    foreign key(`brand_id`) references `brand`(`brand_id`) on delete cascade
    )";
    if ($mysqli->query($sql) === false) return false;

    $sql = "CREATE TABLE IF NOT EXISTS `order`(
        `order_id` INT AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `order_date` DATE NOT NULL,
        `total_amount` INT NOT NULL,
        `order_status` BOOLEAN DEFAULT(FALSE),
        `payment_status` BOOLEAN DEFAULT(FALSE),
         FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE
    ) ";
        if ($mysqli->query($sql) === false) return false;

    $sql = "CREATE TABLE IF NOT EXISTS `payment` (
        `payment_id` INT AUTO_INCREMENT PRIMARY KEY,
        `order_id` INT NOT NULL,
        `payment_date` DATE NOT NULL,
        `payment_img` TEXT NOT NULL,
        `payment_method` VARCHAR(255) NOT NULL,
        FOREIGN KEY (`order_id`) REFERENCES `order`(`order_id`) ON DELETE CASCADE
    )";
    
    if ($mysqli->query($sql) === false) return false;

   
    $sql = "CREATE TABLE IF NOT EXISTS `order_item`(
    `order_item_id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `qty` INT NOT NULL,
    `amount` INT NOT NULL,
    FOREIGN KEY(`order_id`) REFERENCES `order`(`order_id`) ON DELETE CASCADE,
    FOREIGN KEY(`product_id`) REFERENCES `product`(`product_id`) ON DELETE CASCADE
)";
    if ($mysqli->query($sql) === false) return false;

    $sql = "CREATE TABLE IF NOT EXISTS `deliver`(
        `deliver_id` int auto_increment primary key,
        `order_id` int not null,
        `user_id` int not null,
        `customer_name` varchar(255) not null,
        `email` varchar(50) unique not null,
        `phone` int not null,
        `city` varchar(255) not null,
        `street` varchar(255) not null,
        `order_note` varchar(255) null,
         FOREIGN KEY(`order_id`) REFERENCES `order`(`order_id`) ON DELETE CASCADE,
         FOREIGN KEY(`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE
         )";
        if ($mysqli->query($sql) === false) return false;

    $sql = "CREATE TABLE IF NOT EXISTS `feedback`(
    `feedback_id` int auto_increment primary key,
    `name` varchar(50) not null,
    `email` varchar(50) not null,
    `message`text not null,
    `submitted_at` datetime default CURRENT_TIMESTAMP
    )";
    if ($mysqli->query($sql) === false) return false;
}

create_database($mysqli);
select_db($mysqli);
create_tables($mysqli);