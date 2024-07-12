<?php
require_once("../storage/brand_db.php");
require_once("../storage/category_db.php");
require_once("../storage/product_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$success = $invalid = "";
$brand_name = $brand_name_error = $product_image_error = "";

if (isset($_POST['submit'])) {
   
    $product_name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $qty = htmlspecialchars($_POST['qty']);
    $exp_date = htmlspecialchars($_POST['exp_date']);
    $discount = htmlspecialchars($_POST['discount']);    
    $image = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    if (!str_contains($_FILES['image']['type'],'image/')) {
        $product_image_error = "please upload only image!";
    }
    $image = file_get_contents($image);
    $product_logo = base64_encode($image);
    $category_id = htmlspecialchars($_POST['select_category']);
    $brand_id = htmlspecialchars($_POST['select_brand']);
   
    $product = save_product($mysqli,$product_name,$price,$qty,$exp_date,$discount,$product_logo,$category_id,$brand_id);
    if ($product) {
        $success = "Product Create Success";
        header("Location: ../admin/product.php");
    } else {
        $invalid = "Product Create Fail";
        header("Location: ../admin/product.php");
    }
}



?>
<?php require_once("../admin/layout/navbar.php");  ?>
<?php require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row justify-content-center">
                <div class="col-8">
                    <?php if ($success) : ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong><?php echo $success ?>!</strong> .
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <?php if ($invalid) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?php echo $invalid ?>!</strong> .
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>

                    <form method="post" class="form-control" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Product Name</label>
                            <input type="text" class="form-control" required="" name="name" placeholder="Write a Product">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label mt-3">Price</label>
                            <input type="int" class="form-control" required="" name="price" placeholder="Write a Price">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Qty</label>
                            <input type="int" class="form-control" required="" name="qty" placeholder="Write a brand">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Exp Date</label>
                            <input type="date" class="form-control" required="" name="exp_date">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Discount</label>
                            <input type="int" class="form-control" required="" name="discount">
                        </div>
                        <div class="mb-3">
                            <select class="form-select form-control" aria-label="Default select example" name="select_category">
                                <option value="00">Select Your Category</option>
                               <?php $categories = get_all_category($mysqli);
                               while($category = $categories->fetch_assoc()) :
                               ?>
                                <option value="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></option>
                                
                               <?php endwhile ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-select form-control" aria-label="Default select example" name="select_brand">
                                <option value="00">Select Your Brand</option>
                               <?php $brands = get_all_brand($mysqli);
                               while($brand = $brands->fetch_assoc()) :
                               ?>
                                <option value="<?php echo $brand['brand_id'] ?>"><?php echo $brand['brand_name'] ?></option>
                                
                               <?php endwhile ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Image</label>
                            <input type="file" class="form-control" required="" name="image">
                        </div>

                            <button type="submit" class="btn btn-primary mb-3" name="submit">Create</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>