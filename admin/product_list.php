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
require_once("../storage/product_db.php");
require_once("../storage/brand_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$success = $invalid = "";



if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_product($mysqli, $delete_id);
    if ($delete) {
        $success = "Delete Success";
        header("Location:../admin/product_list.php?success=$success");
        
    } else {
        $invalid = "Delete Unsuccess";
        header("Location: ../admin/product_list.php?invalid=$invalid");
    }
}


  

if(isset($_POST['product_id'])){
    $product_id = $_POST['product_id'];
    $product = get_product_by_id($mysqli,$product_id);
    
}
?>
<?php require_once("../admin/layout/navbar.php");  ?>
<?php require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col">
                    <?php if ($success) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?php echo $success ?>!</strong> 
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <?php if ($invalid) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?php echo $invalid ?>!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Exp_date</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Image</th>
                                <th scope="col">Best Seller</th>
                                <th scope="col">IsNew</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    <tbody>
                        <?php
                        $products = get_all_product($mysqli);
                        if(isset($_GET['search'])){
                            $name = isset($_GET['search']) ? $_GET['search'] : null;
                            $products = get_product_by_filter($mysqli,$name);
                        }
                         ?>
                        <?php while ($product = $products->fetch_assoc()) : ?>
                            
                            <tr>
                                <th scope="row"><?php echo $product['product_id'] ?></th>
                                <td><?php echo $product['product_name'] ?></td>
                                <td><?php echo $product['price'] ?></td>
                                <td><?php echo $product['qty'] ?></td>
                                <td><?php echo $product['ex_date'] ?></td>
                                <td><?php echo $product['discount'] ?></td>
                                <td><img style="width: 50px;height: 50px;" class="rounded" src="data:image/png;base64,<?php echo $product['image'] ?>" alt=""></td>
                                <td>
                                    
                                    <?php if($product['best_seller'] == 1) :?>
                                    <a href="./best_seller.php?action=yes&product_id=<?php echo $product['product_id'] ?>" class="btn btn-primary btn-sm">Yes</a>
                                    <?php else : ?>
                                    <a href="./best_seller.php?action=no&product_id=<?php echo $product['product_id'] ?>" class="btn btn-warning btn-sm">No</a>
                                    <?php endif ?>
                                    
                                </td>
                                <td>
                                    <?php if($product['is_new'] == 1) :?>
                                        <a href="./is_new.php?action=yes&product_id=<?php echo $product['product_id'] ?>" class="btn btn-primary btn-sm">Yes</a>
                                    <?php else : ?>
                                        <a href="./is_new.php?action=no&product_id=<?php echo $product['product_id'] ?>" class="btn btn-warning btn-sm">No</a>
                                    <?php endif ?>
                                </td>
                                <td class="d-flex align-items-center">
                                    <a href="../admin/product.php?update_id=<?php echo $product['product_id'] ?>" class="btn btn-secondary btn-sm me-1 mt-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="../admin/product_list.php?delete_id=<?php echo $product['product_id'] ?>" class="btn btn-danger btn-sm mt-2"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile ?>
                        </tbody>
                        </table>
                </div>            
            </div>
        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>