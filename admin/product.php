<?php
require_once("../storage/auth_user.php");
    if (!$user['is_admin']) {
        header("Location: ../admin/layout/error.php");
        die();
    }

?>
<?php
require_once("../storage/brand_db.php");
require_once("../storage/category_db.php");
require_once("../storage/product_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$success = $invalid =false;
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

if (isset($_GET['update_id'])) {
    $product_id = $_GET['update_id'];
    $update = get_product_by_id($mysqli, $product_id);  
    $product_name = $update['product_name'];
    $price = $update['price'];
    $qty = $update['qty'];
    $exp_date =$update['ex_date'];
    $discount = $update['discount'];
      if (isset($_POST['update'])){
       
        $product_name = $_POST['name'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $exp_date = $_POST['exp_date'];
        $discount = $_POST['discount'];
        $image = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        if (!str_contains($_FILES['image']['type'],'image/')) {
            $product_image_error = "please upload only image!";
        }
        $image = file_get_contents($image);
        $product_logo = base64_encode($image);
        if ($product_name == "") $product_name_error = "Product Name is Blank";
        if ($price == "") $price_error = "Price is Blank";
        if ($exp_date == "") $exp_date_error = "Exp Date is Blank";
        if ($discount == "") $discount_error = "Discount is Blank";
        
            $product = update_product($mysqli,$product_name,$price,$qty,$exp_date,$discount,$product_logo,$product_id);
            if ($product) {
                $success = "Update is Success";
                header("Location: ../admin/product_list.php?success=$success");
            } else {
                $invalid = "Update is Failed";
                header("Location: ../admin/product_list.php?invalid=$invalid");
            }
        }
    

}


?>
<?php require_once("../admin/layout/navbar.php");  ?>
<?php require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            
            <div class="row justify-content-center">
                <div class="col-6">
                    <h3 class="text-center">Add Product</h3>
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
                            <input type="text" class="form-control" required="" name="name" value="<?php if(isset($_GET['update_id'])) echo $product_name ?>" placeholder="Write a Product">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label mt-3">Price</label>
                            <input type="int" class="form-control" required="" name="price" value="<?php if(isset($_GET['update_id'])) echo $price ?>" placeholder="Write a Price">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Qty</label>
                            <input type="number" class="form-control" required="" name="qty" value="<?php if(isset($_GET['update_id'])) echo $qty ?>" placeholder="Write a Qty">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Exp Date</label>
                            <input type="date" class="form-control" required="" name="exp_date" value="<?php if(isset($_GET['update_id'])) echo $exp_date ?>">
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label mt-3">Discount</label>
                            <input type="int" class="form-control" name="discount" value="<?php if(isset($_GET['update_id'])) echo  $discount ?>" placeholder="Write a Discount">
                        </div>
                       <?php if(isset($_GET['update_id']) == null) : ?>
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
                        <?php endif ?>
            
                        <?php if(isset($_GET['update_id'])) : ?>
                            <button type="submit" class="btn btn-primary mb-3" name="update">Update</button>
                            <?php else : ?>
                            <button type="submit" class="btn btn-primary mb-3" name="submit">Create</button>
                        <?php endif ?>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once("../admin/layout/footer.php") ?>