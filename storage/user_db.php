
<?php  
function save_user($mysqli, $name, $email, $phone, $address, $password){
    $sql = "insert into user(`name`,`email`,`phone`,`address`,`password`) values('$name','$email','$phone','$address','$password')";
    if($mysqli->query($sql)){
        return true;
    }else{
        return false;
    }
}

function get_user_by_email($mysqli,$email){
    $sql = "select * from user where `email`='$email'";
    $result = $mysqli->query($sql);
    if($result){
        return $result->fetch_assoc();
    }
}
function get_user_by_id($mysqli,$user_id){
    $sql = "select * from user where `user_id` = '$user_id'";
    $result = $mysqli->query($sql);
    if($result){
        return $result->fetch_assoc();
    }
}

?>