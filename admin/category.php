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
require_once("../storage/category_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$category_name = $category_name_error = $category_img_error = "";
if (isset($_POST['create'])) {

    $category_name = htmlspecialchars($_POST['category']);
    $image = $_FILES['image']['tmp_name'];
    $img_name = $_FILES['image']['name'];
    if(!str_contains($_FILES['image']['type'],'image/')){
        $category_img_error = "Please upload only photo";
    }
    $img = file_get_contents($image);
    $category_image = base64_encode($img);
    $category = save_category($mysqli, $category_name,$category_image);
    if ($category) {
        $_SESSION['status'] = "Category Create Success";
        $_SESSION['status_code'] = "success";
        header("Location: ../admin/category.php");
        exit();
    } else {
        $_SESSION['status'] = "Category Create Fail";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/category.php");
        exit();
    }
}
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_category($mysqli, $delete_id);
    if ($delete) {
        $_SESSION['status'] = "Delete Success";
        $_SESSION['status_code'] = "success";
        header("Location: ../admin/category.php");
        exit();
    } else {
        $_SESSION['status'] = "Delete Fail";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/category.php");
        exit();
    }
}

if (isset($_GET['update_id'])) {
    $category_id = $_GET['update_id'];
    $update = get_category_by_id($mysqli, $category_id);
    $category_name = $update['category_name'];
    if (isset($_POST['update'])) {
        $category_name = $_POST['category'];
        $image = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        if (!str_contains($_FILES['image']['type'],'image/')) {
            $product_image_error = "please upload only image!";
        }
        $image = file_get_contents($image);
        $category_logo = base64_encode($image);
        if ($category_name == "") $category_name_error = "Category Name is Blank";
        if ($category_name_error == "") {
            $category = update_category($mysqli, $category_id, $category_name,$category_logo);
            if ($category) {
                $_SESSION['status'] = "Update Success";
                $_SESSION['status_code'] = "success";
                header("Location: ../admin/category.php");
                exit();
            } else {
                $_SESSION['status'] = "Update Fail!";
                $_SESSION['status_code'] = "error";
                header("Location: ../admin/category.php");
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
                            <label for="category" class="form-label mt-3">Categroy</label>
                            <input type="text" class="form-control" required="" value="<?php echo $category_name ?>" name="category" placeholder="Write a Category">
                        </div>
                        <div class="mb-4">
                            <label for="category" class="form-label mt-3">Image</label>
                            <input type="file" name="image" class="form-control"  id="">
                        </div>
                        <?php if (isset($_GET['update_id'])) : ?>
                            <button type="submit" class="btn btn-primary mb-3" name="update">update</button>
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
                            <?php $categories = get_all_category($mysqli);
                            if(isset($_GET['search'])){
                                $name = isset($_GET['search']) ? $_GET['search'] : null;
                                $categories = get_category_by_filter($mysqli,$name);
                            }
                            ?>
                            <?php while ($category = $categories->fetch_assoc()) : ?>
                                <tr>
                                    <th scope="row"><?php echo $category['category_id'] ?></th>
                                    <td><?php echo $category['category_name'] ?></td>
                                    <td><img style="width: 50px;height: 50px;" class="rounded" src="data:image/png;base64,<?php echo $category['category_img'] ?>" alt=""></td>
                                    <td>
                                        <a href="../admin/category.php?update_id=<?php echo $category['category_id'] ?>" class="btn btn-secondary">Edit</a>
                                        <a href="../admin/category.php?delete_id=<?php echo $category['category_id'] ?>" class="btn btn-danger">Delete</a>
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