<?php 
session_start();
$item_list = [];
if(isset($_SESSION['item_list'])){
    $item_list = $_SESSION['item_list'];
}