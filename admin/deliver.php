<?php
require_once("../storage/auth_user.php");
if (!$user) {
    header("Location: ./login.php");
    die();
} else {
    if (!$user['is_admin']) {
        header("Location: ../admin/layout/error.php");
        die();
    }
}
?>
<?php
require_once("../storage/deliver_db.php");
require_once("../storage/user_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
?>
<?php require_once("../admin/layout/navbar.php");  ?>
<?php require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row justify-content-center">
                <div>
                    <a href="../admin/order.php" class="btn btn-primary">Back</a>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <?php $deliver = get_deliver_by_order_id($mysqli, $_GET['order_id']); ?>
                            <h3 class="text-center my-3"><i class="fa-solid fa-truck"></i> DELIVER INFO</h3>
                            <table class="table table-striped">
                                
                                <tbody>
                                    <tr>
                                        <th scope="row">Full Name</th>
                                        <td><?php if($deliver){
                                            echo $deliver['customer_name'];
                                        }else{
                                            echo " ";
                                        } ?></td>                                        
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td><?php if($deliver){
                                            echo $deliver['email'];
                                        }else{
                                            echo " ";
                                        } ?></td>                                          
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone</th>
                                        <td><?php if($deliver){
                                            echo $deliver['phone'];
                                        }else{
                                            echo " ";
                                        } ?></td>                                   
                                    </tr>
                                    <tr>
                                        <th scope="row">Street</th>
                                        <td><?php if($deliver){
                                            echo $deliver['street'];
                                        }else{
                                            echo " ";
                                        } ?></td>                                    
                                    </tr>
                                    <tr>
                                        <th scope="row">City</th>
                                        <td><?php if($deliver){
                                            echo $deliver['city'];
                                        }else{
                                            echo " ";
                                        } ?></td>                                   
                                    </tr>
                                    <tr>
                                        <th scope="row">Order Note</th>
                                        <td><?php if($deliver){
                                            echo $deliver['order_note'];
                                        }else{
                                            echo " ";
                                        } ?></td>                                 
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>