<?php
require_once("../storage/brand_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$success = $invalid = "";
$brand_name = $brand_name_error = $brand_image_error = "";

if (isset($_POST['create'])) {
    $brand_name = htmlspecialchars($_POST['brand']);
    $image = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    if (!str_contains($_FILES['image']['type'],'image/')) {
        $product_image_error = "please upload only image!";
    }
    $image = file_get_contents($image);
    $brand_logo = base64_encode($image);
    $brand = save_brand($mysqli, $brand_name,$brand_logo);
    if ($brand) {
        $success = "Brand Create Success";
        
    } else {
        $invalid = "Brand Create Fail";
        
}
}
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_brand($mysqli, $delete_id);
    if ($delete) {
        $success = "Delete Success";
        header("Location: ../admin/brand.php?success=$success");
        
    } else {
        $invalid = "Delete Unsuccess";
        header("Location: ../admin/brand.php?invalid=$invalid");
    }
}

if (isset($_GET['update_id'])) {
    $brand_id = $_GET['update_id'];
    $update = get_brand_by_id($mysqli, $brand_id);  
    $brand_name = $update['brand_name'];
    if (isset($_POST['update'])){
        $brand_name = $_POST['brand'];
        if ($brand_name == "") $brand_name_error = "brand Name is Blank";
        if ($brand_name_error == "") {
            $brand = update_brand($mysqli, $brand_id, $brand_name);
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
                <div class="col-6">
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
                        <div class="mb-4">
                            <label for="brand" class="form-label mt-3">Brand Name</label>
                            <input type="text" class="form-control" required="" value="<?php echo $brand_name ?>" name="brand" placeholder="Write a brand">
                        </div>
                        <div class="mb-4">
                            <label for="brand" class="form-label mt-3">Brand Image</label>
                            <input type="file" class="form-control" required="" name="image">
                        </div>
                        <?php if (isset($_GET['update_id'])) : ?>
                            <button type="submit" class="btn btn-primary mb-3" name="update">Update</button>
                                <?php else : ?>                 
                                    <button type="submit" class="btn btn-primary mb-3" name="create">Create</button>
                                <?php endif ?>
                    </form>
                </div>

                <div class="col-6">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    <tbody>
                        <?php $brands = get_all_brand($mysqli); ?>
                        <?php while ($brand = $brands->fetch_assoc()) : ?>
                            <tr>
                                <th scope="row"><?php echo $brand['brand_id'] ?></th>
                                <td><?php echo $brand['brand_name'] ?></td>
                                <td><img style="width: 50px;height: 50px;" class="rounded" src="data:image/png;base64,<?php echo $brand['brand_logo'] ?>" alt=""></td>
                                <td>
                                    <a href="../admin/brand.php?update_id=<?php echo $brand['brand_id'] ?>" class="btn btn-secondary">Edit</a>
                                    <a href="../admin/brand.php?delete_id=<?php echo $brand['brand_id'] ?>" class="btn btn-danger">Delete</a>
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