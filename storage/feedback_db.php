<?php
function save_feedback($mysqli,$name,$email,$message){
    $sql = "insert into `feedback` (name,email,message) values('$name','$email','$message')";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}

function get_all_feedback($mysqli){
    $sql = "SELECT * FROM feedback";
    $result = $mysqli->query($sql);
    return $result;
}