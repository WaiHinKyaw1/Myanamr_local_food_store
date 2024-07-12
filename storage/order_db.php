<?php 
function save_order($mysqli,$user_id,$order_date,$total_amount,$status){
    $sql = "insert into order(user_id,order_date,total_amount,status) values($user_id,$order_date,$total_amount,$status)";
    if($mysqli->query($sql)){
        return true;
    }
    return false;
}