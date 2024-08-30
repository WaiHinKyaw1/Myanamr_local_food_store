<?php
require_once("../storage/auth_user.php");
require_once("../storage/brand_db.php");
require_once("../storage/category_db.php");
require_once("../storage/product_db.php");
require_once("../storage/database.php");
$success = $invalid = $product_image_error = "";
if (!$user['is_admin']) {
    header("Location: ../admin/layout/error.php");
    die();
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $product = get_product_by_id($mysqli, $product_id);
}
if (isset($_POST['add_qty'])) {
    $qty = $_POST['add'];
    $add_qty = $product['qty'] + $qty;
    $update_qty = update_product_qty($mysqli, $add_qty, $product_id);
    if ($update_qty) {
        $success = "Update Success";
        header("Location: ./product_list.php");
    }
}
if(isset($_POST['change_photo'])){
    $image = $_FILES['photo']['tmp_name'];
    $image_name = $_FILES['photo']['name'];
    if (!str_contains($_FILES['photo']['type'],'image/')) {
        $product_image_error = "please upload only image!";
    }
    $image = file_get_contents($image);
    $product_logo = base64_encode($image);
    $update_image = update_product_image($mysqli,$product_logo,$product_id);
    if($update_image){
        $success = "Update Success";
        header("Location: ./add_qty.php?product_id=$product_id&success=$success");
    }else{
        $invalid = "Update Fail";
    }
}

require_once("../admin/layout/header.php");
require_once("../admin/layout/navbar.php");
require_once("../admin/layout/sidebar.php");
?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
        <?php if ($success) : ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong><?php echo $success ?>!</strong> .
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
            <div class="row justify-content-center ">
                <div class="col-6 align-items-center">
                    <div class="card p-5">
                        <h3 class="text-center mb-5">ADD QTY</h3>
                        <form action="" method="post">
                            <div class="col-sm-5">
                            <h4><input class="form-control" type="number" name="add" id="" placeholder="Add QTY"></h4>
                            </div>
                            <div class="ms-3">
                            <button type="submit" name="add_qty" class="btn btn-primary btn-sm">Save change</button>
                            <a href="./product_list.php" class="btn btn-primary btn-sm">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-6 align-items-center">
                    <div class="card p-5">
                        <h3 class="text-center mb-3">CHANGE PHOTO</h3>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class=" card mb-2">
                            <img
                                src="data:image/png;base64,<?php echo $product['image'] ?>"
                                style="width: 100px;height: 100px;" class="rounded"
                                alt=""
                            />
                            </div>
                            <div class="mb-2">
                                <input type="file" name="photo" placeholder="Upload Photo" id="">
                            </div>
                            <div class=" mt-3">
                            <button type="submit" name="change_photo" class="btn btn-primary btn-sm">Save change</button>
                            <a href="./product_list.php" class="btn btn-primary btn-sm">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>
</div>
</div>
</div>

<?php require_once("../admin/layout/footer.php") ?>