<?php
require_once("./storage/database.php");
require_once("./storage/order_db.php");
require_once("./storage/payment_db.php");
require_once("./storage/order_item_db.php");
require_once("./storage/product_db.php");

$product_image_error = $payment_method_eror = "";
$validate = true;
if (isset($_POST)) {
    
    $last_order = get_last_order($mysqli);
    $last_order_id = $last_order['order_id'];
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
    
    if ($payment) {
        $_SESSION['payment_success'] = 'Payment was successful!';
    } else {
        
        $_SESSION['payment_error'] = 'Payment failed. Please try again.';
    }

    header('Location: ./index.php');
    exit();

    
}
