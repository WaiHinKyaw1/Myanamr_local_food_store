<?php
require_once("../storage/product_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$success = $invalid = "";



if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_brand($mysqli, $delete_id);
    if ($delete) {
        $success = "Delete Success";
        header("Location:../admin/brand.php?success=$success");
        
    } else {
        $invalid = "Delete Unsuccess";
        header("Location: ../admin/brand.php?invalid=$invalid");
    }
}

if (isset($_GET['update_id'])) {
    $product_id = $_GET['update_id'];
    $update = get_brand_by_id($mysqli, $product_id);  
    $product_name = $update['product_name'];
    if (isset($_POST['update'])){
        $product_name = $_POST['product_name'];
        if ($brand_name == "") $brand_name_error = "brand Name is Blank";
        if ($brand_name_error == "") {
            $product = update_brand($mysqli, $brand_id, $brand_name);
            if ($brand) {
                $success = "Update is Success";
                header("Location: ../admin/brand.php?success=$success");
            } else {
                $invalid = "Update is Failed";
                header("Location: ../admin/brand.php?invalid=$invalid");
            }
        }
    }
}

?>
<?php require_once("../admin/layout/navbar.php");  ?>
<?php require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col">
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
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    <tbody>
                        <?php $products = get_all_product($mysqli); ?>
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
                                    <a href="../admin/product.php?update_id=<?php echo $product['product_id'] ?>" class="btn btn-secondary">Edit</a>
                                    <a href="../admin/product_list.php?delete_id=<?php echo $product['product_id'] ?>" class="btn btn-danger">Delete</a>
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