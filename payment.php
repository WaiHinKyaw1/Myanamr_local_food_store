<?php
require_once("./storage/database.php");
require_once("./storage/order_db.php");
require_once("./storage/payment_db.php");
require_once("./storage/auth_user.php");
require_once("./storage/order_item_db.php");
require_once("./storage/product_db.php");
require_once("./storage/deliver_db.php");

$name = $email = $phone = $city = $street = "";
$name_error = $email_error = $phone_error = $city_error = $street_error = "";
$product_image_error = $payment_method_eror = "";
$validate = true;
if (isset($_POST['payment'])) {
    
    $last_order = get_last_order($mysqli);
    $last_order_id = $last_order['order_id'];
    $user_id = $user['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $street =$_POST['street'];
    $order_note =$_POST['order_note'];
    if ($name === "" ) {
        $validate = false;
        $name_error = "Name must not be blank!";
    }
    if ($phone === "") {
        $validate = false;
        $phone_error = "Phone must not be blank!";
    }
    if ($email === "" ) {
        $validate = false;
        $email_error = "Email must not be blank!";
    }
    if ($city === "") {
        $validate = false;
        $city_error = "City must not be blank!";
    }
    if($street === ""){
        $validate= false;
        $street_error = "Street must not be blank!";
    }
    if($order_note === ""){
        $validate= false;
        $order_note_error = "Order Note not be blank!";
    }
    $deliver = save_deliver($mysqli,$last_order_id,$user_id,$name,$email,$phone,$city,$street,$order_note);
    $order_item = get_all_order_item_by_order_id($mysqli, $last_order_id);
    foreach ($order_item as $order) {
        $product_id = $order['product_id'];
        $product = get_product_by_id($mysqli, $product_id);
        $product['qty'] = $product['qty'] - $order['qty'];
        $qty = $product['qty'];
        $product_qty = update_product_qty($mysqli, $qty, $product_id);
    }
    $order_id = $_POST['order'];
    $payment_date = date('Y-m-d');
    $payment_method = $_POST['payment_method'];
    if($payment_method === ""){
        $validate = false;
        $payment_method_eror = "please choose payment method";
    }
    $photo = $_FILES['screenshot']['tmp_name'];
    $photo_name = $_FILES['screenshot']['name'];
    if (!str_contains($_FILES['screenshot']['type'],'image/')) {
        $product_image_error = "please upload only image!";
    }
    $image = file_get_contents($photo);
    $payment_photo = base64_encode($image);
    $payment = save_payment($mysqli,$order_id,$payment_date,$payment_photo,$payment_method);
    session_destroy();
    if ($payment) {
        $_SESSION['status'] = "Payment Success";
        $_SESSION['status_code'] = "success";
        header('Location: ./index.php');
        exit();
    } else {
        $_SESSION['status'] = "Payment Fail!";
        $_SESSION['status_code'] = "error";
        header('Location: ./index.php');
        exit();
    }
    
}
?>
