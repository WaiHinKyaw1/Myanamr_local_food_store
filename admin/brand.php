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
require_once("../storage/brand_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$brand_name = $brand_name_error = $brand_image_error = "";

if (isset($_POST['create'])) {
    $brand_name = htmlspecialchars($_POST['brand']);
    if($brand_name == "") $brand_name_error = "Brand Name is Blank";
    $image = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    if (!str_contains($_FILES['image']['type'],'image/')) {
        $product_image_error = "please upload only image!";
    }
    $photo = file_get_contents($image);
    $brand_logo = base64_encode($photo);
    $brand = save_brand($mysqli, $brand_name,$brand_logo);
    if ($brand) {
        $_SESSION['status'] = "Brand Create Success";
        $_SESSION['status_code'] = "success";
        header("Location: ../admin/brand.php");
        exit();
    } else {
        $_SESSION['status'] = "Brand Create Fail";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/brand.php");
        exit();
}
}
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_brand($mysqli, $delete_id);
    if ($delete) {
        $_SESSION['status'] = "Delete Success";
        $_SESSION['status_code'] = "success";
        header("Location: ../admin/brand.php");
        exit();
        
    } else {
        $_SESSION['status'] = "Delete Fail";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/brand.php");
        exit();
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
                $_SESSION['status'] = "Update is Success";
                $_SESSION['status_code'] = "success";
                header("Location: ../admin/brand.php");
                exit();
            } else {
                $_SESSION['status'] = "Update is Failed";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/brand.php");
                exit();
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
                    
                    <form method="post" class="form-control" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="brand" class="form-label mt-3">Brand Name</label>
                            <input type="text" class="form-control" required="" value="<?= $brand_name ?>" name="brand" placeholder="Write a brand">
                            <small class="text-danger"><?= $brand_name_error ?></small>
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
                        <?php $brands = get_all_brand($mysqli);
                        if(isset($_GET['search'])){
                            $name = isset($_GET['search']) ? $_GET['search'] : null;
                            $brands = get_brand_by_filter($mysqli,$name);
                        } ?>
                        <?php
                        $i=1;
                        while ($brand = $brands->fetch_assoc()) : ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $brand['brand_name'] ?></td>
                                <td><img style="width: 50px;height: 50px;" class="rounded" src="data:image/png;base64,<?= $brand['brand_logo'] ?>" alt=""></td>
                                <td>
                                    <a href="../admin/brand.php?update_id=<?= $brand['brand_id'] ?>" class="btn btn-secondary">Edit</a>
                                    <a href="../admin/brand.php?delete_id=<?= $brand['brand_id'] ?>" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php
                        $i++;
                        endwhile ?>
                        </tbody>
                        </table>
                </div>            
            </div>
        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>