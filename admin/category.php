<?php
require_once("../storage/category_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");
$success = $invalid = "";
$category_name = $category_name_error = "";

if (isset($_POST['create'])) {
   
    $category_name = htmlspecialchars($_POST['category']);
    
    $category = save_category($mysqli, $category_name);
    if ($category) {
        $success = "Category Create Success";
        header("Locaction: ../admin/category.php");
    } else {
        $invalid = "Categroy Create Fail";
        header("Locaction: ../admin/category.php");
    }
}
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_category($mysqli, $delete_id);
    if ($delete) {
        $success = "Delete Success";
        header("Location: ../admin/category.php?success=$success");
    } else {
        $invalid = "Delete Unsuccess";
        header("Location: ../admin/category.php?invalid=$invalid");
    }
}

if (isset($_GET['update_id'])) {
    $category_id = $_GET['update_id'];
    $update = get_category_by_id($mysqli, $category_id);
    $category_name = $update['category_name'];
    if (isset($_POST['update'])) {
        $category_name = $_POST['category'];
        if ($category_name == "") $category_name_error = "Category Name is Blank";
        if ($category_name_error == "") {
            $category = update_category($mysqli, $category_id, $category_name);
            if ($category) {
                $success = "Update is Success";
                header("Location: ../admin/category.php?success=$success");
            } else {
                $invalid = "Update is Failed";
                header("Location: ../admin/category.php?invalid=$invalid");
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
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?php echo $success ?>!</strong> You should check in on some of those fields below.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                    <?php if ($invalid) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong><?php echo $invalid ?>!</strong> You should check in on some of those fields below.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>

                    <form method="post" class="form-control">
                        <div class="mb-4">
                            <label for="category" class="form-label mt-3">Categroy</label>
                            <input type="text" class="form-control" required="" value="<?php echo $category_name ?>" name="category" placeholder="Write a Category">
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
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $categories = get_all_category($mysqli); ?>
                            <?php while ($category = $categories->fetch_assoc()) : ?>
                                <tr>
                                    <th scope="row"><?php echo $category['category_id'] ?></th>
                                    <td><?php echo $category['category_name'] ?></td>
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